<?php 

namespace App\controller\frontend;

use Interop\Container\ContainerInterface;

class HomeController
{
    protected $container;
    
    public function __construct( ContainerInterface $container ) 
    {
        $this->container = $container;
    }

    public function home($request, $response, $args) 
    {
    	$this->container->logger->info('hello world');

        // $attrs = $request->getAttributes();
        // echo $attrs['locale'];
        
        // $this->container->cache->set("cache_key", "hello slim");
        // echo $this->container->cache->get("cache_key");

        return $this->container->view->render($response, 'frontend/home/index.phtml', ['translator' => $this->container->translator]);
        
    }


}