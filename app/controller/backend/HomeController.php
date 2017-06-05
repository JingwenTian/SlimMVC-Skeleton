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
    	return $this->container->view->render($response, 'backend/demo/index.phtml', []);
    }

    public function components($request, $response, $args)
    {
    	$components = $request->getQueryParam('c');

    	switch ($components) {
    		default:
    		case 'buttons':
    			return $this->container->view->render($response, 'backend/demo/components.buttons.phtml', []);
    			break;
    		case 'social-buttons':
    			return $this->container->view->render($response, 'backend/demo/components.social.buttons.phtml', []);
    			break;
    		case 'cards':
    			return $this->container->view->render($response, 'backend/demo/components.cards.phtml', []);
    			break;
    		case 'forms':
    			return $this->container->view->render($response, 'backend/demo/components.forms.phtml', []);
    			break;
    		case 'modals':
    			return $this->container->view->render($response, 'backend/demo/components.modals.phtml', []);
    			break;
    		case 'switches':
    			return $this->container->view->render($response, 'backend/demo/components.switches.phtml', []);
    			break;
    		case 'tables':
    			return $this->container->view->render($response, 'backend/demo/components.tables.phtml', []);
    			break;
    		case 'tabs':
    			return $this->container->view->render($response, 'backend/demo/components.tabs.phtml', []);
    			break;
    	}

    }

    public function icons($request, $response, $args)
    {
    	$icons = $request->getQueryParam('c');

    	switch ($icons) {
    		default:
    		case 'awesome':
    			return $this->container->view->render($response, 'backend/demo/icons.font.awesome.phtml', []);
    			break;
    		case 'line':
    			return $this->container->view->render($response, 'backend/demo/icons.simple.line.icons.phtml', []);
    			break;
    	}
    }

    public function widgets($request, $response, $args)
    {
    	return $this->container->view->render($response, 'backend/demo/widgets.phtml', []);
    }

    public function charts($request, $response, $args)
    {
    	return $this->container->view->render($response, 'backend/demo/charts.phtml', []);
    }

    public function pages($request, $response, $args)
    {
    	$pages = $request->getQueryParam('c');

    	switch ($pages) {
    		default:
    		case 'login':
    			return $this->container->view->render($response, 'backend/demo/pages/pages.login.phtml', []);
    			break;
    		case 'register':
    			return $this->container->view->render($response, 'backend/demo/pages/pages.register.phtml', []);
    			break;
    		case '404':
    			return $this->container->view->render($response, 'backend/demo/pages/pages.404.phtml', []);
    			break;
    		case '500':
    			return $this->container->view->render($response, 'backend/demo/pages/pages.500.phtml', []);
    			break;
    	}
    }

}