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

        return $this->container->renderer->render($response, 'index.phtml', []);
    }


}