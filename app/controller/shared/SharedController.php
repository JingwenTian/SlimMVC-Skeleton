<?php 

namespace App\controller\shared;

use Interop\Container\ContainerInterface;

class SharedController
{
	protected $container;
    
    public function __construct( ContainerInterface $container ) 
    {
        $this->container = $container;
    }

    public function upload( $request, $response, $args )
    {
        $settings = $this->container->get('settings')['upload'];
        $driver   = $settings['driver'];
        $options  = [
            'maxSize'   => 2048,
            'exts'      => ['gif', 'jpg', 'jpeg', 'png'],
        ];
        $upload = new \App\helper\Upload\Upload($options, $driver, $settings['drivers'][$driver]);

        $files = $request->getUploadedFiles();
        if (empty($files['file'])) {
            throw new \Exception('Expected a newfile', 404);
        }
        $result = $upload->uploadOne($files['file']);
        
        if ($result) {
           return $response->withJson(['code' => 200, 'message' => 'success', 'data' => $result]); 
        }

        return $response->withJson(['code' => 409, 'message' => $upload->getError()]); 

    }

}