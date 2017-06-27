<?php 

use App\helper\Support\Str;

if (! function_exists('p')) {
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
}


if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        if (Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}


if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $make
     * @return mixed|\Interop\Container\ContainerInterface
     */
    function app($make = null)
    {
        global $app;

        if (is_null($make)) {
            return $app->getContainer();
        }

        return $app->getContainer()->get($make);
    }
}

if (! function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return \Slim\Views
     */
    function view($reponse = [], $view = null, $data = [])
    {
        $factory = app('view');

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->render($reponse, $view, $data);
    }
}

if (! function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $replace
     * @param  string  $locale
     * @return \Symfony\Component\Translation\Translator
     */
    function trans($id = null, $replace = [], $locale = null)
    {
        if (is_null($id)) {
            return app('translator');
        }

        return app('translator')->trans($id, $replace, null, $locale);
    }
}