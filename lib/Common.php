<?php 

/** 
 * ����������
 * @Author: jing
 * @Usage: use lib\Common;
 *         Common::p($str);
 */

namespace lib;

class Common {

    /** 
     * ���ŵĴ�ӡ����
     */
    public static function p() {
        $args=func_get_args();  
        if(count($args)<1){
            Debug::addmsg("<font color='red'>����Ϊp()�����ṩ����!");
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
     * �ж�ʱ���������ո�/����ǰ/Сʱǰ/����/ʱ��
     * @Usage echo T("ʱ���");
     */
    public static function T($time) {
       //��ȡ�����賿��ʱ���
       $day = strtotime(date('Y-m-d',time()));
       //��ȡ�����賿��ʱ���
       $pday = strtotime(date('Y-m-d',strtotime('-1 day')));
       //��ȡ���ڵ�ʱ���
       $nowtime = time();
        
       $tc = $nowtime-$time;
       if($time<$pday){
          $str = date('Y-m-d H:i:s',$time);
       }elseif($time<$day && $time>$pday){
          $str = "����";
       }elseif($tc>60*60){
          $str = floor($tc/(60*60))."Сʱǰ";
       }elseif($tc>60){
          $str = floor($tc/60)."����ǰ";
       }else{
          $str = "�ո�";
       }
       return $str;
    }

    public static function is_mobile() {

         //������ʽ,���䲻ͬ�ֻ������UA�ؼ��ʡ�

         $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";

         $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";

         $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";

         $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";

         $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";

         $regex_match.=")/i";

         return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT'])); //���UA�д�������Ĺؼ����򷵻��档

    }

}




