<?php

class AckSensitiveWordDetection {

  //spamwords ac trie tree
  private $ttree = [[]];
  //todo 停用词中间可以忽略的字符
  private $stopwords = [];



  function __construct($spamwordsfile,$stopwordsfile='') {

    mb_internal_encoding("UTF-8");
    $ttree = &$this->ttree;


    $file = fopen($spamwordsfile, "r"); // 以只读的方式打开文件
    if(empty($file)){
        throw new Exception("spamwordsfile not execist", 1);

    }

    while(!feof($file)) {
        //读取每个过滤词构建trietree
        $line = trim(fgets($file));
        $lenght = mb_strlen($line);
        if ($lenght > 0) {

            $nextstate = 0;

            for ($i=0; $i < $lenght; $i++) {
                //数组不停向后扩展 代表另外一个状态
                //每个状态节点里面存储下一个状态的位置
                 $key = mb_substr($line, $i, 1, "utf-8");
                 if (!isset($ttree[$nextstate][$key])) {
                    $ttree[$nextstate][$key] = count($ttree);
                    $ttree[] = array();
                  }
                  $nextstate = $ttree[$nextstate][$key];
            }

            $ttree[$nextstate]['end'][] = $line;   //end节点代表结束节点存储的匹配词

        }
    }
    fclose($file);

    //失败位置加工 & 结束节点合并
    $queue = [];

    //根节点
    foreach($ttree[0] as $key => $nextstate) {
      //下个状态失败后直接返回root
      $ttree[$nextstate]['fail'] = 0;
      //下个状态所在的位置入队列
      $queue[] = $nextstate;
    }


    while (count($queue)) {
      //逐层遍历这颗树 先做失败节点，然后根据失败节点合并结束节点
      $r = array_shift($queue);

      foreach($ttree[$r] as $key => $nextstate) {

        // 这两个节点忽略
        // fail 代表失败回溯节点
        // end 代表结束节点
        if ($key === 'end' || $key === 'fail') continue;


        //失败回溯节点
        $v = $ttree[$r]['fail'];



        //不停的向上回溯，直到root 或 当前节点的上个状态
        while ($v > 0 && !isset($ttree[$v][$key])) $v = $ttree[$v]['fail'];


        //下一个状态的回溯节点： 上个状态的其他分支  或 当前回溯节点
        $ttree[$nextstate]['fail'] = isset($ttree[$v][$key]) ? $ttree[$v][$key] : $v;

        if (isset($ttree[$ttree[$nextstate]['fail']]['end'])) {//回溯节点有结束状态

          if (!isset($ttree[$nextstate]['end'])) $ttree[$nextstate]['end'] = array();
          //当前节点结束状态 合并  回溯节点的结束状态
          $ttree[$nextstate]['end'] = array_merge($ttree[$nextstate]['end'], $ttree[$ttree[$nextstate]['fail']]['end']);
        }
        //下个状态入队列
        $queue[] = $nextstate;


      }
    }

  }



  public function Detection($text) {
    mb_internal_encoding("UTF-8");
    $ttree = &$this->ttree;
    $found = [];
    $nextstate = 0;


    for ($i=0,$l = mb_strlen($text); $i < $l; $i++) {
        $key = mb_substr($text, $i, 1, "utf-8");

        while(!in_array($key, array_keys($ttree[$nextstate]), true) && $nextstate) {
            //如果当前匹配中断 不停向上回溯 找到当前key的上个状态或直到根
            $nextstate = $ttree[$nextstate]['fail'];
        }
        //当前匹配上了 继续
        if (isset($ttree[$nextstate][$key]))
            $nextstate = $ttree[$nextstate][$key];
        //当前匹配有结束状态
        if (isset($ttree[$nextstate]['end'])) {
            //开始准备输出了
            $spamwords = $ttree[$nextstate]['end'];
            foreach($spamwords as $w) {
              $found[] = array(
                          $w,  //spam word
                          $i - mb_strlen($w) + 1 //位置
                        );
            }
        }
    }

    return $found;
  }

};
