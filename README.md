# 说明

    1. 基于Aho–Corasick线性复杂度
    2. 适用范围： utf8编码的任意语言敏感词库。
    3. 敏感词库：一行一个词。
    3. 逻辑输出：匹配到的敏感词和敏感词所在的位置，如果没有返回空数组

# 测试使用方法

    php demo.php  #1.4w个敏感词

    array(8) {
      [0]=>
      array(2) {
        [0]=>
        string(3) "抽"
        [1]=>
        int(11)
      }
      [1]=>
      array(2) {
        [0]=>
        string(3) "喷"
        [1]=>
        int(17)
      }
      [2]=>
      array(2) {
        [0]=>
        string(3) "色"
        [1]=>
        int(33)
      }
      [3]=>
      array(2) {
        [0]=>
        string(12) "工作人员"
        [1]=>
        int(53)
      }
      [4]=>
      array(2) {
        [0]=>
        string(3) "抽"
        [1]=>
        int(69)
      }
      [5]=>
      array(2) {
        [0]=>
        string(12) "工作人员"
        [1]=>
        int(81)
      }
      [6]=>
      array(2) {
        [0]=>
        string(12) "工作人员"
        [1]=>
        int(97)
      }
      [7]=>
      array(2) {
        [0]=>
        string(3) "喷"
        [1]=>
        int(107)
      }
    }
    use time ms:8

# 参考资料

  内容获取方法：
    https://github.com/search?q=%E6%95%8F%E6%84%9F%E8%AF%8D&type=Repositories

  理论和方法：

      1）Aho-Corasick 多模式匹配算法、AC自动机详解
          https://en.wikipedia.org/wiki/Aho%E2%80%93Corasick_string_matching_algorithm
      dfa（有限确定自动机) 建立失配指针，成为AC自动机 kmp算法的一个扩展
          https://www.cnblogs.com/TIMHY/p/8572881.html

      2）ttmp
         http://www.cnblogs.com/sumtec/archive/2008/02/01/1061742.html

  其他语言实现
      https://github.com/search?q=Aho-Corasick
      java实现
          https://github.com/hankcs/AhoCorasickDoubleArrayTrie
          https://github.com/robert-bor/aho-corasick

  php 实现
      https://github.com/AbelZhou/PHP-TrieTree
      https://github.com/FireLustre/php-dfa-sensitive
      https://github.com/codeplea/ahocorasickphp

  php扩展实现
      https://github.com/wulijun/php-ext-trie-filter
      基于swool的封装
      https://github.com/zoooozz/php-filter-service
      https://github.com/ph4r05/php_aho_corasick

  相关词库
      https://github.com/fighting41love/funNLP

  c trie相关库
      https://linux.thai.net/~thep/datrie/datrie.html

  相关性能数据：
      https://github.com/aojiaotage/text-censor
      https://github.com/AbelZhou/PHP-TrieTree
      https://github.com/toolgood/ToolGood.Words
