<?php 

/**
 * 调试打印
 *
 * @return [type] [description]
 */
function p()
{
    $args=func_get_args();  
    if(count($args)<1) {
        return;
    }
    echo '<div style="width:100%;text-align:left; background-color: #fff;"><pre style="white-space:pre">';
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