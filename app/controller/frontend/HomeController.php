<?php 

namespace App\controller\frontend;


class HomeController extends BaseController
{

    public function home($request, $response, $args) 
    {
    	//$this->container->logger->info('hello world');

        // $attrs = $request->getAttributes();
        // echo $attrs['locale'];
        
        // $this->container->cache->set("cache_key", "hello slim");
        // echo $this->container->cache->get("cache_key");

    	//echo trans('home.hello', ['%name%' => 'Slim']);

        //return $this->container->view->render($response, 'frontend/home/index.phtml', ['translator' => $this->container->translator]);
        return view($response, 'frontend/home/index.phtml', ['translator' => $this->container->translator]);
    }


}