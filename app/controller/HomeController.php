<?php 

namespace App\controller;

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

        return $this->container->view->render($response, 'index.phtml', ['translator' => $this->container->translator]);
    }


}