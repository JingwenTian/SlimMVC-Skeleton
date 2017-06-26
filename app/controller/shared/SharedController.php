<?php 
namespace App\controller\shared;


class SharedController extends BaseController
{

    public function captcha( $request, $response, $args )
    {
        $builder = new \Gregwar\Captcha\CaptchaBuilder();
        $builder->build();
        $phrase = $builder->getPhrase();
        $builder->output();
        return $response->withHeader('Content-type', 'image/jpeg');
    }

    public function upload( $request, $response, $args )
    {
        $settings = $this->container->get('settings')['upload'];
        $driver   = $settings['driver'];

        if ($request->isGet()) {
            return $response->withJson([
                "imageUploadUrl" => "/shard/upload",
                'imageUrlPrefix' => $settings['drivers'][$driver]['domain'],
                "imageFieldName" => "file",
                "imageMaxSize" => 2048 * 1000,
                "imageAllowFiles" => ['.gif', '.jpg', '.jpeg', '.png'],
            ]);
        }

        $options  = [
            'maxSize'   => 2048 * 1000,
            'exts'      => ['gif', 'jpg', 'jpeg', 'png'],
        ];
        $upload = new \App\helper\Upload\Upload($options, $driver, $settings['drivers'][$driver]);

        $files = $request->getUploadedFiles();
        if (empty($files['file'])) {
            throw new \Exception('Expected a newfile', 404);
        }
        $result = $upload->uploadOne($files['file']);

        if ($result) {
            return $this->responseSuccess($result);
        }

        return $this->responseFail(409, $upload->getError());

    }

    

}