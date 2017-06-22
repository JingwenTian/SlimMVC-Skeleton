<?php 

namespace App\helper\Upload;

class Upload 
{
	protected $config = [
		'mimes'         =>  [], //允许上传的文件MiMe类型
        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
        'exts'          =>  [], //允许上传的文件后缀
        'autoSub'       =>  true, //自动子目录保存文件
        'subName'       =>  ['date', 'Y-m-d'], //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath'      =>  './uploads/', //保存根路径
        'savePath'      =>  '', //保存路径
        'saveName'      =>  ['uniqid', ''], //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
        'replace'       =>  false, //存在同名是否覆盖
        'hash'          =>  true, //是否生成hash编码
        'driver'        =>  '', // 文件上传驱动
        'driverConfig'  =>  [], // 上传驱动配置
	];

	private $error = '';

	private $uploader;


	public function __construct( array $config = [], $driver = '', array $driverConfig = []  )
	{
		$this->config = array_merge($this->config, $config);

		$this->setDriver($driver, $driverConfig);

		if(!empty($this->config['mimes'])) {
            if(is_string($this->mimes)) {
                $this->config['mimes'] = explode(',', $this->mimes);
            }
            $this->config['mimes'] = array_map('strtolower', $this->mimes);
        }

        if(!empty($this->config['exts'])) {
            if (is_string($this->exts)) {
                $this->config['exts'] = explode(',', $this->exts);
            }
            $this->config['exts'] = array_map('strtolower', $this->exts);
        }

	}


	public function __get( $name ) 
	{
        return $this->config[$name];
    }

    public function __set( $name, $value )
    {
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
            if($name == 'driverConfig') {
                $this->setDriver(); 
            }
        }
    }

    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    public function getError()
    {
        return $this->error;
    }

    public function uploadOne( $file )
    {
        $info = $this->upload([$file]);
        return $info ? $info[0] : $info;
    }

    public function upload( $files ) 
    {
        if(empty($files)) {
            $this->error = '没有上传的文件！';
            return false;
        }

        if(!$this->uploader->checkRootPath($this->rootPath)) {
            $this->error = $this->uploader->getError();
            return false;
        }

        if(!$this->uploader->checkSavePath($this->savePath)) {
            $this->error = $this->uploader->getError();
            return false;
        }

        $info    =  [];
        if(function_exists('finfo_open')) {
            $finfo   =  finfo_open ( FILEINFO_MIME_TYPE );
        }

        $files   =  $this->dealFiles($files);

        foreach ($files as $key => $file) 
        {
        	$file['name']  = strip_tags($file['name']);
        	$file['key']   = !isset($file['key']) ? $key : $file['key'];
        	
        	if(isset($finfo)){
                $file['type']   =   finfo_file ( $finfo,  $file['tmp_name'] );
            }

            if (!$this->check($file)) {
                continue;
            }

            if($this->hash) {
                $file['md5']  = md5_file($file['tmp_name']);
                $file['sha1'] = sha1_file($file['tmp_name']);
            }

            $savename = $this->getSaveName($file);
            if(false == $savename) {
                continue;
            } else {
                $file['savename'] = $savename;
            }

            $subpath = $this->getSubPath($file['name']);
            if(false === $subpath){
                continue;
            } else {
                $file['savepath'] = $this->savePath . $subpath;
            }

            // 对图像文件进行严格检测
            $ext = strtolower($file['ext']);
            if(in_array($ext, array('gif','jpg','jpeg','bmp','png','swf'))) {
                $imginfo = getimagesize($file['tmp_name']);
                if(empty($imginfo) || ($ext == 'gif' && empty($imginfo['bits']))) {
                    $this->error = '非法图像文件！';
                    continue;
                }
            }

            if ($upinfo = $this->uploader->save($file, $this->replace)) {
                $extends = [
                                'origin_name'   => $file['name'],
                                'name'          => $file['savename'],
                                'ext'           => $ext,
                                'size'          => $file['size'],
                                'mime'          => $file['type'], 
                            ];
                $info[$key] = array_merge($upinfo, $extends);
            } else {
                $this->error = $this->uploader->getError();
            }

        }

        if(isset($finfo)) {
            finfo_close($finfo);
        }

        return empty($info) ? false : $info;

    }


	private function setDriver($driver = null, $config = null)
	{
        $driver = $driver ? : ($this->driver ? : '');
        $config = $config ? : ($this->driverConfig ? : []); 

        $class = strpos($driver,'\\') ? $driver : 'App\\helper\\Upload\\Driver\\' . ucfirst(strtolower($driver));
        $this->uploader = new $class($config);

        if(!$this->uploader) {
            throw new \Exception("No upload driver: {$name}", 500);
        }
    }

    private function dealFiles($files) 
    {
		$fileArray  = [];
		$files = !is_array($files) ? [$files] : $files;
		foreach ($files as $key => $file) {
			$fileArray[$key] = [
				'name'		=> $file->getClientFilename(),
				'tmp_name'	=> $file->file,
				'type'		=> $file->getClientMediaType(),
				'ext'		=> pathinfo($file->getClientFilename(), PATHINFO_EXTENSION),
				'size'		=> $file->getSize(),
				'error'		=> $file->getError(),
				'stream'	=> $file->getStream(),
			]; 
		}
       return $fileArray;
    }

    private function check($file) 
    {
        if ($file['error'] != UPLOAD_ERR_OK) {
            $this->error($file['error']);
            return false;
        }

        if (empty($file['name'])){
            $this->error = '未知上传错误！';
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            $this->error = '非法上传文件！';
            return false;
        }

        if (!$this->checkSize($file['size'])) {
            $this->error = '上传文件大小不符！';
            return false;
        }

        if (!$this->checkMime($file['type'])) {
            $this->error = '上传文件MIME类型不允许！';
            return false;
        }

        if (!$this->checkExt($file['ext'])) {
            $this->error = '上传文件后缀不允许';
            return false;
        }

        return true;
    }

    private function error($errorNo) 
    {
        switch ($errorNo) {
            case UPLOAD_ERR_INI_SIZE: // 1
                $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值！';
                break;
            case UPLOAD_ERR_FORM_SIZE: // 2
                $this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值！';
                break;
            case UPLOAD_ERR_PARTIAL: // 3
                $this->error = '文件只有部分被上传！';
                break;
            case UPLOAD_ERR_NO_FILE: // 4
                $this->error = '没有文件被上传！';
                break;
            case UPLOAD_ERR_NO_TMP_DIR: // 6
                $this->error = '找不到临时文件夹！';
                break;
            case UPLOAD_ERR_CANT_WRITE: // 7
                $this->error = '文件写入失败！';
                break;
            default:
                $this->error = '未知上传错误！';
        }
    }

    private function checkSize($size)
    {
        return !($size > $this->maxSize) || (0 == $this->maxSize);
    }

    private function checkMime($mime) 
    {
        return empty($this->config['mimes']) ? true : in_array(strtolower($mime), $this->mimes);
    }

    private function checkExt($ext) 
    {
        return empty($this->config['exts']) ? true : in_array(strtolower($ext), $this->exts);
    }

    private function getSubPath($filename) 
    {
        $subpath = '';
        $rule    = $this->subName;
        if ($this->autoSub && !empty($rule)) {
            $subpath = $this->getName($rule, $filename) . '/';

            if(!empty($subpath) && !$this->uploader->mkdir($this->savePath . $subpath)) {
                $this->error = $this->uploader->getError();
                return false;
            }
        }
        return $subpath;
    }

    private function getSaveName($file) 
    {
        $rule = $this->saveName;

        if (empty($rule)) { 
            $filename = substr(pathinfo("_{$file['name']}", PATHINFO_FILENAME), 1);
            $savename = $filename;
        } else {
            $savename = $this->getName($rule, $file['name']);
            if(empty($savename)) {
                $this->error = '文件命名规则错误！';
                return false;
            }
        }

        $ext = empty($this->config['saveExt']) ? $file['ext'] : $this->saveExt;

        return $savename . '.' . $ext;
    }

    private function getName($rule, $filename)
    {
        $name = '';

        if(is_array($rule)) { 
            $func     = $rule[0];
            $param    = (array) $rule[1];
            foreach ($param as &$value) {
               $value = str_replace('__FILE__', $filename, $value);
            }
            $name = call_user_func_array($func, $param);

        } elseif (is_string($rule)) { 
            if(function_exists($rule)) {
                $name = call_user_func($rule);
            } else {
                $name = $rule;
            }
        }
        return $name;
    }


}
