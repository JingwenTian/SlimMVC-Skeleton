<?php 

/** 
 * 公共函数库
 * @Author: jing
 * @Usage: use lib\Common;
 *         Common::p($str);
 */

namespace lib;

class Common {

    /** 
     * 优雅的打印调试
     */
    public static function p() {
        $args=func_get_args();  
        if(count($args)<1){
            Debug::addmsg("<font color='red'>必须为p()函数提供参数!");
            return;
        }
        echo '<div style="width:100%;text-align:left; background-color: #fff;"><pre>';
        foreach($args as $arg){
            if(is_array($arg)){
                print_r($arg);
                echo '<br>';
            }else if(is_string($arg)){
                echo $arg.'<br>';
            }else{
                var_dump($arg);
                echo '<br>';
            }
        }
        echo '</pre></div>';
    }

    /**
     * 判断时间戳来输出刚刚/分钟前/小时前/昨天/时间
     * @Usage echo T("时间戳");
     */
    public static function T($time) {
       //获取今天凌晨的时间戳
       $day = strtotime(date('Y-m-d',time()));
       //获取昨天凌晨的时间戳
       $pday = strtotime(date('Y-m-d',strtotime('-1 day')));
       //获取现在的时间戳
       $nowtime = time();
        
       $tc = $nowtime-$time;
       if($time<$pday){
          $str = date('Y-m-d H:i:s',$time);
       }elseif($time<$day && $time>$pday){
          $str = "昨天";
       }elseif($tc>60*60){
          $str = floor($tc/(60*60))."小时前";
       }elseif($tc>60){
          $str = floor($tc/60)."分钟前";
       }else{
          $str = "刚刚";
       }
       return $str;
    }

    public static function is_mobile() {

         //正则表达式,批配不同手机浏览器UA关键词。

         $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";

         $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";

         $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";

         $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";

         $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";

         $regex_match.=")/i";

         return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT'])); //如果UA中存在上面的关键词则返回真。

    }

}




