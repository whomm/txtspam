<?php
require './ack.php';

function msectime() {
  list($msec, $sec) = explode(' ', microtime());
  $msectime = (int)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
  return $msectime;
}



$swd = new AckSensitiveWordDetection('./spamwords.txt');
$stime = msectime();
var_dump($swd->Detection('【加完油出来  #男子抽烟遭灭火器喷头# 】杭州某加油站里，一辆黑色车子加完油出来，在出口停了下来，加油站工作人员走近一看，驾驶员居然正在抽烟！停车位置靠近油库，工作人员赶紧劝阻，可驾驶员不听，工作人员只好用灭火器喷了他的头，驾驶员很恼怒，被行政拘留三天。@黄金眼融媒
L黄金眼融媒的酷燃视频#周杰伦被小学生围着签名# 哈哈哈哈哈，周杰伦配文：你们开心，我就开心，看起来像学校签名会，刚出道的感觉。[允悲][允悲][允悲] L娱乐有饭的秒拍视频 ​​​​
'));
$etime = msectime();
$utime = $etime-$stime;
echo "use time ms:$utime\n";
