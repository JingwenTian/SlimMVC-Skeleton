<?php 

namespace App\controller\backend;

use Interop\Container\ContainerInterface;

class HomeController
{
    protected $container;
    
    public function __construct( ContainerInterface $container ) 
    {
        $this->container = $container;
    }

    public function dashboard($request, $response, $args) 
    {
    	return $this->container->view->render($response, 'backend/home/index.phtml', []);
    }

    

}