<?php 

/**	
 * 功能方法集
 */
use lib\Config;
use lib\UploadFile;
use lib\Image;
 
$app->post('/upload', function() use($app) {

	$width = $app->request()->post('width');
	$height = $app->request()->post('height');
	
	$upload = new UploadFile();
	$upload->maxSize  = 2079152; //2M
	$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
	$upload->savePath =  Config::read('UPLOAD');
	$upload->autoSub = false;
	$upload->subType = 'date';
	$upload->dateFormat = 'Ym/d';
	
	$upload->thumb = true;
	$upload->imageClassPath = 'lib/Image.class.php'; 
	$upload->thumbPrefix = 'slim_';
	$upload->thumbMaxWidth = $width; 
	$upload->thumbMaxHeight = $height; 
	//$upload->saveRule = uniqid; 
	$upload->thumbRemoveOrigin = true; 	
	$upload->saveRule = time().'_'.mt_rand(00000,99999);//设置上传文件规则

	if(!$upload->upload()) {
		echo $upload->getErrorMsg();
	}else{
		$info = $upload->getUploadFileInfo();
		echo $upload->thumbPrefix.$info[0]['savename'];
	}

});

