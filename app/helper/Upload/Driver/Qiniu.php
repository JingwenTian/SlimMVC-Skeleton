<?php 

namespace App\helper\Upload\Driver;

use Qiniu\Storage\UploadManager;
use Qiniu\Auth;

class Qiniu
{
	private $rootPath;

	private $error = '';

    private $config = [
    	'access_key' => '', 
        'secret_key' => '',
        'domain'    => '', 
        'bucket'    => '', 
        'timeout'   => 300, 
    ];

    public function __construct($config)
    {
        $this->config = array_merge($this->config, $config);

        $this->qiniu = new UploadManager();
        $this->auth  = new Auth($this->config['access_key'], $this->config['secret_key']);
    }

    public function checkRootPath($rootpath)
    {
        $this->rootPath = trim($rootpath, './') . '/';
        return true;
    }

    public function checkSavePath($savepath)
    {
        return true;
    }

    public function mkdir($savepath)
    {
        return true;
    }

    public function save($file, $replace = true)
    {
    	$token = $this->auth->uploadToken($this->config['bucket']);

        $remotePath 	= $file['savepath'] . $file['savename'];
     
        list($result, $error) = $this->qiniu->put($token, $remotePath, $file['stream']);

        if ($error !== null) {
        	$this->error = $error;
        	return false;
        }

        $upInfo = [
                    'hash'  => $result['hash'],
                    'path'  => $result['key'],
                    'url'   => "{$this->config['domain']}/{$remotePath}",
                  ];
        return $upInfo;
    }

    public function getError()
    {
        return $this->error;
    }

}
