<?php

namespace lib;

/**
 * 常用用具库
 * @Usage use lib\Tools; 
 *        Tools::clearHtml();
 *
 * @Type :
 *
 * 图片
 ---------- isImage($imgformat) -- @return bool //检查是否是图片格式
 ---------- getTimeImageName() -- @return string //根据时间生成图片名
 * 日期
 ---------- dateYears($step=0,$min=1900) -- @return array //生成年份
 ---------- dateDays() -- @return array //生成日
 ---------- dateMonths() -- @return array //生成月
 ---------- hourGenerate($hours, $minutes, $seconds) -- @return string //根据时分秒生成时间字符串
 ---------- dateTimeMinAndMax($date) -- @return string //一日之初和结束
 ---------- isTodayDate($time) -- @return bool //判断时间是否为当天
 ---------- timeDiff($aTime,$bTime) -- @return string //时间格式为YYYYMMDDHHmmss，计算两个时间相差几年、几月、几天、几分……
 ---------- timeDiffBll($postdate) -- @return string //获取指定时间与现在时间的差
 ---------- timeDiffSpace($postdate,$ineffect)  -- @return string //获取指定时间加上指定天数后距离现在的剩余时间
 ---------- float2time($s) -- @return string //计算时间差
 ---------- dateadd($interval, $step, $date) -- @return string //日期计算
 ---------- getSimpleDate($timestamp = null) -- @return string //获取日期
 ---------- getFullDate($timestamp = null) -- @return string //获取完整时间
 ---------- runMicrotime($tag) -- @return string //输出执行时间
 ---------- getMicrotime() -- @return string //获取当前时间截
 ---------- getExactTime() -- @return int //获取精准的时间
 ---------- getYear() -- @return int //获取精准的年份
 * 文件
 ---------- getFileExt($file) -- @return string //获取文件扩展名
 ---------- deleteDirectory($dirname, $delete_self = true) //删除文件夹
 ---------- copyFile($source, $dest) -- @return bool //文件复制
 ---------- downloadFile($url, $filepath) -- @return bool //下载文件保存到指定位置
 ---------- scandir($path, $ext = 'php', $dir = '', $recursive = false) -- @return array //遍历路径
 ---------- getDateDirectoryPath() -- @return string //创建日期目录 
 * 输出
 ---------- displayError($string = 'Fatal error', $error = array(), $htmlentities = true) -- @return string //显示错误信息
 ---------- dieObject($object, $kill = true) -- @return mixed //打印出对象的内容 
 * 字符
 ---------- randPasswd($length = 8, $flag = self::FLAG_NO_NUMERIC) -- @return string //生成随机密码
 ---------- findString($search,$object) -- @return bool //查找字符串
 ---------- clearHtml($str) -- @return string //清除html字符
 ---------- safeOutput($string, $html = false) -- @return string //过滤HTML内容后返回
 ---------- htmlentitiesUTF8($string, $type = ENT_QUOTES) -- @return string //字符转换成HTML实体
 ---------- htmlentitiesDecodeUTF8($string) -- @return string //HTML转换为适用的字符
 ---------- strReplaceFirst($search, $replace, $subject, $cur = 0) -- @return string //替换第一次出现的字符串
 ---------- substr($str, $start, $length = false, $encoding = 'utf-8') -- @return bool|string //截取字符串
 ---------- strtoupper($str) -- @return bool|string //转换成大写字符串
 ---------- cutcn($string,$length,$clearhtml = false,$dot = '...') @return string //截取中文字符，支持清空HTML码
 ---------- cutstr($string, $length, $dot = '...') -- @return string //截取字符串，支持中文
 ---------- replaceAccentedChars($str)  -- @return string //重音字符替换
 ---------- cleanNonUnicodeSupport($pattern) -- @return string //清除Unicode
 ---------- intval($val) -- @return int //转换为int类型
 ---------- strlen($str, $encoding = 'UTF-8') -- @return bool|int //计算字符串长度
 ---------- stripslashes($string) -- @return string //引用字符串
 ---------- strtolower($str) -- @return string //转换成小写字符，支持中文
 ---------- ucfirst($str) -- @return string //首字母大写
 ---------- ceilf($value, $precision = 0) -- @return int|float //取整的值
 ---------- floorf($value, $precision = 0) -- @return int //舍去小数部分取整
 ---------- replaceSpace($url) -- @return string //替换URL空格
 ---------- convertBytes($value) -- @return string //数字转换成 bytes
 ---------- getOctets($option) -- @return string //获得八位字节
 ---------- getPinYin($str,$isShort=false) -- @return string //汉字转换成拼音
 ---------- convertBanJiao($str) -- @return string //全角转半角
 ---------- convertRtoBR($str) -- @return string //换行符转换成BR
 
 * 系统
 ---------- getSiteDir() -- @return string //返回网站的根目录
 ---------- getHttpHost($http = false, $entities = false) -- @return string //获取当前域名
 ---------- getCurrentUrlProtocolPrefix() -- @return string //获取当前URL协议
 ---------- usingSecureMode() -- @return string //判断是否使用了HTTPS
 ---------- cleanUrl($url, $cleanall = true) -- @return string //清理URL中的http头
 ---------- redirect($url, $headers = null) //跳转
 ---------- redirectTo($link) //跳转
 ---------- getServerName() @return string //获取当前服务器名
 ---------- is_mobile_request() -- @return bool //判断是否手机访问
 ---------- getClientIp() -- @return string //获取客户端IP地址
 ---------- getReferer() -- @return string //获取用户来源地址
 ---------- isSpider() -- @return bool //判断是否爬虫，范围略大
 ---------- isCli() -- @return bool //判断是否命令行执行
 ---------- sys_get_temp_dir() -- @return string //临时目录
 ---------- isX86_64arch() -- @return bool //判断是否64位架构
 ---------- getMemoryLimit() -- @return int //获取内存限制
 ---------- getMaxUploadSize($max_size = 0) -- @return mixed //获取服务器配置允许最大上传文件大小
 * 安全
 ---------- secureReferrer($referrer) -- @return string //判断是否本站链接
 ---------- getValue($key, $default_value = false) -- @return string or bool //获取POST或GET的指定字段内容
 ---------- getIsset($key) -- @return bool //判断POST或GET中是否包含指定字段
 ---------- isSubmit($submit) //判断是否为提交操作
 ---------- safePostVars() //对POST内容进行处理
 ---------- removeXSS($str) -- @return mixed //XSS
 ---------- transCase($str)
 * 加密
 ---------- encrypt($string,$key='K6aL3Bo5') -- @return string //加密字符串
 ---------- decrypt($string,$key='K6aL3Bo5') -- @return string //解密字符串 
 * 转换
 ---------- nl2br($str)
 ---------- br2nl($str) 
 * 验证
 ---------- isEmpty($field) -- @return bool //判断是否真为空
 ---------- isInt($field) -- @return bool //匹配是否全数字
 ---------- isEn($field) -- @return bool //匹配是否全字母
 ---------- isCn($field) -- @return bool //是否包含中文 
 * 数据
 ---------- returnMobileJson($code, $data, $native = false) -- @return json //以固定格式将数据及状态码返回手机端
 ---------- returnAjaxJson($array) -- @return json //以固定格式将数据及状态码返回PC端 
 * 数组
 ---------- json_encode($obj) //对象转换成 json 格式
 ---------- json_decode($obj) //json 转换为对象
 ---------- simpleArray($array, $key) -- @return array|null //从array中取出指定字段
 ---------- object2array(&$object)
 ---------- arrayUnique($array) -- @return array //移除数组中重复的值
 ---------- arrayUnique2d($array, $keepkeys = true) -- @return array //移除数组中重复的值
 ---------- walkArray(&$array, $function, $keys = false) //遍历数组 
 * SEO
 ---------- getSeoReferrer($nourl='') -- @return array //获得从搜索引擎过来的关键词和搜索引擎的类型 
 * 采集
 ---------- file_get_contents($url, $use_include_path = false, $stream_context = null, $curl_timeout = 8) //优化的file_get_contents操作
 ---------- curl($url, $method = 'GET', $postFields = null, $header = null)  //curl操作 
 * 其它
 ---------- getGravity($time, $viewcount) -- @return float|int //HackNews热度计算公式
 ---------- getGravityS($stime, $viewcount)
 ---------- ZipTest($from_file)
 ---------- ZipExtract($from_file, $to_dir)
 ---------- cmpWord($a, $b) //PSCWS分词
 ---------- getPageLimit($total_rows,$page_num,$rows_per_page=10) //计算翻页获取记录值
 ---------- getPageTag($pageindex,$rowscount,$pagelink,$pagesize=9) //获取翻页码
 */
 
class Tools 
{
	//==============================================
	// 图片
	//==============================================	
	
	/**
	 * 检查是否是图片格式
	 * @return bool
	 */
	public static function isImage($imgformat)
	{
		$imgformat = strtolower($imgformat);
		$f = array("image/pjpeg","image/gif","image/bmp","image/x-png","image/jpg");
		$c = count($f);
		
		for($i = 0; $i < $c;$i++)
		{
			if($imgformat == $f[$i])
				return true;
		}
		
		return false;
	}

	/**
	 * 根据时间生成图片名
	 * @return float|string
	 */
	public static function getTimeImageName()
	{
		return self::getMicrotime();
	}	
	
	//==============================================
	// 日期
	//==============================================
	
	/**
	 * 生成年份
	 * @return array
	 */
	public static function dateYears($step=0,$min=1900) 
	{
		$years = array();

		for ($i = date('Y') - $step; $i >= $min; $i--)
			$years[] = $i;
			
		return $years;
	}

	/**
	 * 生成日
	 * @return array
	 */
	public static function dateDays() 
	{
		$days = array();

		for ($i = 1; $i != 32; $i++)
			$days[] = $i;
			
		return $days;
	}

	/**
	 * 生成月
	 * @return array
	 */
	public static function dateMonths() 
	{
		$months = array();

		for ($i = 1; $i != 13; $i++)
			$months[$i] = date('F', mktime(0, 0, 0, $i, date('m'), date('Y')));
			
		return $months;
	}

	/**
	 * 根据时分秒生成时间字符串
	 * @return string
	 */
	public static function hourGenerate($hours, $minutes, $seconds) 
	{
		return implode(':', array($hours, $minutes, $seconds));
	}

	/**
	 * 一日之初和结束
	 * @return string
	 */
	public static function dateTimeMinAndMax($date) 
	{
		return array
				(
					'min'=>$date.self::hourGenerate(0, 0, 0),
					'max'=>$date.self::hourGenerate(23, 59, 59)
				);
	}
	
	/**
	 * 判断时间是否为当天
	 * @return bool
	 */
	public static function isTodayDate($time)
	{
		date_default_timezone_set('PRC');
		
		if (date('Y-m-d', $_SERVER['REQUEST_TIME']) == date('Y-m-d', $time))
			return true;
			
		return false;
	}
		
	/**
	 * 时间格式为YYYYMMDDHHmmss，计算两个时间相差几年、几月、几天、几分……
	 * @return string
	 */	
	public static function timeDiff($aTime,$bTime)
	{
		// 分割第一个时间
		$ayear = substr ( $aTime , 0 , 4 );
		$amonth = substr ( $aTime , 4 , 2 );
		$aday = substr ( $aTime , 6 , 2 );
		$ahour = substr ( $aTime , 8 , 2 );
		$aminute = substr ( $aTime , 10 , 2 );
		$asecond = substr ( $aTime , 12 , 2 );
		// 分割第二个时间
		$byear = substr ( $bTime , 0 , 4 );
		$bmonth = substr ( $bTime , 4 , 2 );
		$bday = substr ( $bTime , 6 , 2 );
		$bhour = substr ( $bTime , 8 , 2 );
		$bminute = substr ( $bTime , 10 , 2 );
		$bsecond = substr ( $bTime , 12 , 2 );
		// 生成时间戳
		$a = mktime ( $ahour , $aminute , $asecond , $amonth , $aday , $ayear );
		$b = mktime ( $bhour , $bminute , $bsecond , $bmonth , $bday , $byear );
		$timeDiff ['second'] = $a - $b ;
		// 采用了四舍五入,可以修改
		$timeDiff ['mintue'] = round($timeDiff['second']/60);
		$timeDiff ['hour'] = round($timeDiff['mintue']/60);
		$timeDiff ['day'] = round($timeDiff['hour']/24);
		$timeDiff ['week'] = round($timeDiff['day']/7);
		$timeDiff ['month'] = round($timeDiff['day']/30); // 按30天来算
		$timeDiff ['year'] = round($timeDiff['day']/365); // 按365天来算
		
		return $timeDiff ;
	}

	/**
	 * 获取指定时间与现在时间的差
	 * @return string
	 */		
	public static function timeDiffBll($postdate)
	{
		date_default_timezone_set('PRC');
		
		$result = self::timeDiff(date("YmdHis"),date("YmdHis",strtotime($postdate)));
		
		if($result['second'] < 60 && $result['second'] > 0)
			return $result['second']."秒前";
	
		if($result['mintue'] < 60 && $result['mintue'] > 0)
			return $result['mintue']."分钟前";
			
		if($result['hour'] < 24 && $result['hour'] > 0)
			return $result['hour']."小时前";		
			
		if($result['day'] < 31 && $result['day'] > 0)
			return $result['day']."天前";	
			
		if($result['month'] <= 12 && $result['month'] > 0)
			return $result['month']."月前";			
		else
		{
			if ($result['year'] != 0)
				return $result['year']."年前";			
		}
		
		return "2秒前";
	}

	/**
	 * 获取指定时间加上指定天数后距离现在的剩余时间
	 * @postdate 发布时间
	 * @ineffect 有效时间
	 * @return string
	 */		
	public static function timeDiffSpace($postdate,$ineffect) 	
	{
		extract($params);
	
		date_default_timezone_set('PRC');	
		
		$bTime = date("YmdHis");	
		$aTime = date("YmdHis", strtotime("$postdate + $ineffect day"));
	
		 // 分割第一个时间
		$ayear = substr ( $aTime , 0 , 4 );
		$amonth = substr ( $aTime , 4 , 2 );
		$aday = substr ( $aTime , 6 , 2 );
		$ahour = substr ( $aTime , 8 , 2 );
		$aminute = substr ( $aTime , 10 , 2 );
		$asecond = substr ( $aTime , 12 , 2 );
		// 分割第二个时间
		$byear = substr ( $bTime , 0 , 4 );
		$bmonth = substr ( $bTime , 4 , 2 );
		$bday = substr ( $bTime , 6 , 2 );
		$bhour = substr ( $bTime , 8 , 2 );
		$bminute = substr ( $bTime , 10 , 2 );
		$bsecond = substr ( $bTime , 12 , 2 );
		
		// 生成时间戳
		$a = mktime ($ahour , $aminute , $asecond , $amonth , $aday , $ayear);
		$b = mktime ($bhour , $bminute , $bsecond , $bmonth , $bday , $byear);
		
		$c =  $a - $b;
		
		if($c <= 0)
			return "已过期";
		else
			return self::float2time($c);
	}
	
	/**
	 * 计算时间差
	 * @return string
	 */			
	public static function float2time($s)
	{
		$m=(int)($s/60);
		if($m<1)
		{
			return $s."秒";    
		}else{
			$s=$s%60;
			$h=(int)($m/60);
			if($h<1)
			{
				return $m."分".$s."秒";
			}else{
				$m=$m%60;
				$d=(int)($h/24);
				if($d<1)
				{
					return $h."时".$m."分".$s."秒";
				}else{
					$h=(int)($h%24);
					return $d."天".$h."时".$m."分".$s."秒";
				}
			}
		}
	}	
	
	/**
	 * 日期计算
	 * @return string
	 */
	public static function dateadd($interval, $step, $date)
	{
		date_default_timezone_set('PRC');
		
		list($year, $month, $day) = explode('-', $date);
		
		if (strtolower($interval) == 'y')
		{
			return date('Y-m-d', mktime(0, 0, 0, $month, $day, intval($year) + intval($step)));
		}
		elseif (strtolower($interval) == 'm')
		{
			return date('Y-m-d', mktime(0, 0, 0, intval($month) + intval($step), $day, $year));
		}
		elseif (strtolower($interval) == 'd')
		{
			return date('Y-m-d', mktime(0, 0, 0, $month, intval($day) + intval($step), $year));
		}
		
		return date('Y-m-d');
	}

	/**
	 * 获取日期
	 * @return string
	 */
	public static function getSimpleDate($timestamp = null) 
	{
		date_default_timezone_set('PRC');
		
		if ($timestamp == null) 
		{
			$d = date('Y-m-d');
		}
		else 
		{
			$d = date('Y-m-d', $timestamp);
		}
		
		if($d == "1970-01-01")
		{
			$d = "";
		}
		
		return $d;
	}

	/**
	 * 获取完整时间
	 * @return string
	 */
	public static function getFullDate($timestamp = null) 
	{
		date_default_timezone_set('PRC');
		
		if ($timestamp == null) 
		{
			return date('Y-m-d H:i');
		}
		else 
		{
			return date('Y-m-d H:i', $timestamp);
		}
	}
	
	/**
	 * 输出执行时间
	 * @return string
	 */	
	public static function runMicrotime($tag) 
	{
		date_default_timezone_set('PRC');
		
		list($usec, $sec) = explode(' ', microtime());
		return $tag.':'.((float)$usec + (float)$sec);
	}	
	
	/**
	 * 获取当前时间截
	 * @return string
	 */		
	public static function getMicrotime() 
	{
		date_default_timezone_set('PRC');
		return strtotime(date('Y-m-d H:i:s'));
	}	
	
	/**
	 * 获取精准的时间
	 * @return int
	 */
	public static function getExactTime() 
	{
		date_default_timezone_set('PRC');
		
		return time() + microtime();
	}	
	
	public static function getYear()
	{
		date_default_timezone_set('PRC');
		
		return date('Y');		
	}
		
	//==============================================
	// 文件
	//==============================================	
	
	/**
	 * 获取文件扩展名
	 * @return mixed|string
	 */
	public static function getFileExt($file) {
		if (is_uploaded_file($file)) {
			return "unknown";
		}
		return pathinfo($file, PATHINFO_EXTENSION);
	}
		
	/**
	 * 删除文件夹
	 */
	public static function deleteDirectory($dirname, $delete_self = true) 
	{
		$dirname = rtrim($dirname, '/') . '/';
		if (is_dir($dirname)) {
			$files = scandir($dirname);
			foreach ($files as $file)
				if ($file != '.' && $file != '..' && $file != '.svn') {
					if (is_dir($dirname . $file))
						Tools::deleteDirectory($dirname . $file, true);
					elseif (file_exists($dirname . $file))
						unlink($dirname . $file);
				}
			if ($delete_self)
				rmdir($dirname);
		}
	}	
	
	/**
	 * 文件复制
	 * @return bool
	 */
	public static function copyFile($source, $dest) 
	{
		if (file_exists($dest) || is_dir($dest)) {
			return false;
		}
		return copy($source, $dest);
	}	
	
	/**
	 * 下载文件保存到指定位置
	 * @return bool
	 */
	public static function downloadFile($url, $filepath) 
	{
		if (Validate::isAbsoluteUrl($url) && !empty($filepath)) {
			$file = self::file_get_contents($url);
			$fp = @fopen($filepath, 'w');
			if ($fp) {
				@fwrite($fp, $file);
				@fclose($fp);
				return $filepath;
			}
		}
		return false;
	}	
		
	/**
	 * 遍历路径
	 * @return array
	 */
	public static function scandir($path, $ext = 'php', $dir = '', $recursive = false) 
	{
		$path = rtrim(rtrim($path, '\\'), '/') . '/';
		$real_path = rtrim(rtrim($path . $dir, '\\'), '/') . '/';
		$files = scandir($real_path);
		if (!$files)
			return array();

		$filtered_files = array();

		$real_ext = false;
		if (!empty($ext))
			$real_ext = '.' . $ext;
		$real_ext_length = strlen($real_ext);

		$subdir = ($dir) ? $dir . '/' : '';
		foreach ($files as $file) {
			if (!$real_ext || (strpos($file, $real_ext) && strpos($file, $real_ext) == (strlen($file) - $real_ext_length)))
				$filtered_files[] = $subdir . $file;

			if ($recursive && $file[0] != '.' && is_dir($real_path . $file))
				foreach (Tools::scandir($path, $ext, $subdir . $file, $recursive) as $subfile)
					$filtered_files[] = $subfile;
		}
		return $filtered_files;
	}
		
	/**
	 * 创建日期目录
	 * @return string
	 */	
	public static function getDateDirectoryPath()
	{
		$filename= date("Ymdhis");
		$today=    time();
		$year=     date("Y",$today);
		$month=    date("m",$today);
		$date=     date("d",$today);
		
		//年目录
		$yearDir= "${year}";
		if(!is_dir($yearDir))mkdir($yearDir);
		
		//月目录
		$monthDir="${yearDir}/${month}";
		if(!is_dir($monthDir))mkdir($monthDir);
		
		//日目录
		$dayDir="${monthDir}/${date}";
		if(!is_dir($dayDir))mkdir($dayDir);
		
		//扩展目录
		if($ext != "")
		{
			$extDir="${dayDir}/${ext}";
			if(!is_dir($extDir))mkdir($extDir);
			
			return $extDir;
		}
	
		 return $dayDir;
	}	
	
	//获取文件目录列表,该方法返回数组
	function getDir($dir)
	{
		$dirArray[]=NULL;
		if (false != ($handle = opendir ( $dir ))) {
			$i=0;
			while ( false !== ($file = readdir ( $handle )) ) {
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if ($file != "." && $file != ".."&&!strpos($file,".")) {
					$dirArray[$i]=$file;
					$i++;
				}
			}
			//关闭句柄
			closedir ( $handle );
		}
		return $dirArray;
	}
 
	//获取文件列表
	function getFile($dir,$path='')
	{
		$fileArray[]=NULL;
		
		if (false != ($handle = opendir ($dir)))
		{
			$i=0;
			
			while ( false !== ($file = readdir ( $handle )) ) {

				if ($file != "." && $file != ".."&&strpos($file,"."))
				{
					$fileArray[$i] = $path.$file;
					
					if($i==100)
					{
						break;
					}
					
					$i++;
				}
			}
			//关闭句柄
			closedir ( $handle );
		}
		
		return $fileArray;
	}
		
	//==============================================
	// 输出
	//==============================================	
	
	/**
	 * 显示错误信息
	 * @return string
	 */
	public static function displayError($string = 'Fatal error', $error = array(), $htmlentities = true) 
	{
		if (DEBUG_MODE) {
			if (!is_array($error) || empty($error))
				return str_replace('"', '&quot;', $string) . ('<pre>' . print_r(debug_backtrace(), true) . '</pre>');
			$key = md5(str_replace('\'', '\\\'', $string));
			$str = (isset($error) AND is_array($error) AND key_exists($key, $error)) ? ($htmlentities ? htmlentities($error[$key], ENT_COMPAT, 'UTF-8') : $error[$key]) : $string;
			return str_replace('"', '&quot;', stripslashes($str));
		}
		else {
			return str_replace('"', '&quot;', $string);
		}
	}

	/**
	 * 打印出对象的内容
	 * @return mixed
	 */
	public static function dieObject($object, $kill = true)
	{
		echo '<pre style="text-align: left;">';
		print_r($object);
		echo '</pre><br />';
		if ($kill)
			die('END');
		return ($object);
	}

	//==============================================
	// 字符
	//==============================================
	
	/**
	 * 查找字符串
	 * @return bool	 
	 */	
	public static function httpImage($url,$http)
	{
		if(strstr($url,"http://") != "")
			return $url;
		else
			return $http.$url;
	}		
		
	const FLAG_NUMERIC = 1;
	const FLAG_NO_NUMERIC = 2;
	const FLAG_ALPHANUMERIC = 3;

	/**
	 * 生成随机密码
	 * @return string
	 */
	public static function randPasswd($length = 8, $flag = self::FLAG_NO_NUMERIC)
	{
		switch ($flag) {
			case self::FLAG_NUMERIC:
				$str = '0123456789';
				break;
			case self::FLAG_NO_NUMERIC:
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case self::FLAG_ALPHANUMERIC:
			default:
				$str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
		}

		for ($i = 0, $passwd = ''; $i < $length; $i++)
			$passwd .= Tools::substr($str, mt_rand(0, Tools::strlen($str) - 1), 1);
			
		return $passwd;
	}
	
	/**
	 * 清除html字符
	 * @return string
	 */		
	public static function clearHtml($str)
	{
		$str = str_replace('&amp;','',$str);
		$str = str_replace('nbsp;','',$str);		
		$str = str_replace('&nbsp;','',$str);				
		return strip_tags($str);
	}
	
	/**
	 * 查找字符串
	 * @return bool	 
	 */	
	public static function findString($search,$object)
	{
		if(strstr($object,$search) != "")
			return TRUE;
		else
			return FALSE;
	}	
	
	/**
	 * 过滤HTML内容后返回
	 * @return string		 
	 */
	public static function safeOutput($string, $html = false)
	{
		if (!$html)
			$string = strip_tags($string);
			
		return @Tools::htmlentitiesUTF8($string, ENT_QUOTES);
	}

	/**
	 * 字符转换成HTML实体
	 * @return string		 
	 */
	public static function htmlentitiesUTF8($string, $type = ENT_QUOTES)
	{
		if (is_array($string))
			return array_map(array('Tools', 'htmlentitiesUTF8'), $string);
			
		return htmlentities((string) $string, $type, 'utf-8');
	}

	/**
	 * HTML转换为适用的字符
	 * @return string		 
	 */
	public static function htmlentitiesDecodeUTF8($string) 
	{
		if (is_array($string))
			return array_map(array('Tools', 'htmlentitiesDecodeUTF8'), $string);
		return html_entity_decode((string) $string, ENT_QUOTES, 'utf-8');
	}

	/**
	 * 替换第一次出现的字符串
	 * @return string		 
	 */
	public static function strReplaceFirst($search, $replace, $subject, $cur = 0)
	{
		return (strpos($subject, $search, $cur)) ? substr_replace($subject, $replace, (int) strpos($subject, $search, $cur), strlen($search)) : $subject;
	}	
	
	/**
	 * 截取字符串
	 * @return bool|string
	 */
	public static function substr($str, $start, $length = false, $encoding = 'utf-8')
	{
		if (is_array($str) || is_object($str))
			return false;
		if (function_exists('mb_substr'))
			return mb_substr($str, intval($start), ($length === false ? self::strlen($str) : intval($length)), $encoding);
		return substr($str, $start, ($length === false ? Tools::strlen($str) : intval($length)));
	}	
	
	/**
	 * 转换成大写字符串
	 * @return bool|string
	 */
	public static function strtoupper($str)
	{
		if (is_array($str))
			return false;
		if (function_exists('mb_strtoupper'))
			return mb_strtoupper($str, 'utf-8');
		return strtoupper($str);
	}	
	
	public static function cutcn($string,$length,$clearhtml = false,$dot = '...')
	{
		$string = self::htmlentitiesDecodeUTF8($string);
		
		if($clearhtml)
		{
			$string = self::clearHtml($string);
		}

		$string = self::cutstr($string,$length * 2,$dot);
		return trim($string);
	}
	
	/**
	 * 截取字符串，支持中文
	 * @return string
	 */
	public static function cutstr($string, $length, $dot = '...')
	{		
		$charset = "utf8";
	
		if(strlen($string) <= $length) 
		{	
			return $string;
		}
	
		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	
		$strcut = '';
		
		if(strtolower($charset) == 'utf8') {
	
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {
	
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t <= 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}
	
				if($noc >= $length) {
					break;
				}
	
			}
			if($noc > $length) {
				$n -= $tn;
			}
	
			$strcut = substr($string, 0, $n);
	
		} else {
			for($i = 0; $i < $length; $i++) {
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			}
		}
	
		$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	
		return $strcut.$dot;
	}

	/**
	 * 重音字符替换
	 * @return string
	 */
	public static function replaceAccentedChars($str) 
	{
		$patterns = array(
			/* Lowercase */
			'/[\x{0105}\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}]/u',
			'/[\x{00E7}\x{010D}\x{0107}]/u',
			'/[\x{010F}]/u',
			'/[\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{011B}\x{0119}]/u',
			'/[\x{00EC}\x{00ED}\x{00EE}\x{00EF}]/u',
			'/[\x{0142}\x{013E}\x{013A}]/u',
			'/[\x{00F1}\x{0148}]/u',
			'/[\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F8}]/u',
			'/[\x{0159}\x{0155}]/u',
			'/[\x{015B}\x{0161}]/u',
			'/[\x{00DF}]/u',
			'/[\x{0165}]/u',
			'/[\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{016F}]/u',
			'/[\x{00FD}\x{00FF}]/u',
			'/[\x{017C}\x{017A}\x{017E}]/u',
			'/[\x{00E6}]/u',
			'/[\x{0153}]/u',
			/* Uppercase */
			'/[\x{0104}\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}]/u',
			'/[\x{00C7}\x{010C}\x{0106}]/u',
			'/[\x{010E}]/u',
			'/[\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{011A}\x{0118}]/u',
			'/[\x{0141}\x{013D}\x{0139}]/u',
			'/[\x{00D1}\x{0147}]/u',
			'/[\x{00D3}]/u',
			'/[\x{0158}\x{0154}]/u',
			'/[\x{015A}\x{0160}]/u',
			'/[\x{0164}]/u',
			'/[\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{016E}]/u',
			'/[\x{017B}\x{0179}\x{017D}]/u',
			'/[\x{00C6}]/u',
			'/[\x{0152}]/u'
		);

		$replacements = array(
			'a',
			'c',
			'd',
			'e',
			'i',
			'l',
			'n',
			'o',
			'r',
			's',
			'ss',
			't',
			'u',
			'y',
			'z',
			'ae',
			'oe',
			'A',
			'C',
			'D',
			'E',
			'L',
			'N',
			'O',
			'R',
			'S',
			'T',
			'U',
			'Z',
			'AE',
			'OE'
		);

		return preg_replace($patterns, $replacements, $str);
	}

	/**
	 * 清除Unicode
	 * @return string
	 */
	public static function cleanNonUnicodeSupport($pattern)
	{
		if (!defined('PREG_BAD_UTF8_OFFSET'))
			return $pattern;
			
		return preg_replace('/\\\[px]\{[a-z]\}{1,2}|(\/[a-z]*)u([a-z]*)$/i', "$1$2", $pattern);
	}

	/**
	 * 转换为int类型
	 * @return int
	 */
	public static function intval($val) 
	{
		if (is_int($val))
			return $val;
		if (is_string($val))
			return (int) $val;
		return (int) (string) $val;
	}

	/**
	 * 计算字符串长度
	 * @return bool|int
	 */
	public static function strlen($str, $encoding = 'UTF-8') 
	{
		if (is_array($str) || is_object($str))
			return false;
			
		$str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
		
		if (function_exists('mb_strlen'))
			return mb_strlen($str, $encoding);
			
		return strlen($str);
	}

	/**
	 * 引用字符串
	 * @return string
	 */
	public static function stripslashes($string) 
	{
		if (get_magic_quotes_gpc())
			$string = stripslashes($string);
			
		return $string;
	}
	
	/**
	 * 转换成小写字符，支持中文
	 * @return string
	 */
	public static function strtolower($str)
	{
		if (is_array($str))
			return false;
			
		if (function_exists('mb_strtolower'))
			return mb_strtolower($str, 'utf-8');
			
		return strtolower($str);
	}	

	/**
	 * 首字母大写
	 * @return string	 
	 */
	public static function ucfirst($str)
	{
		return self::strtoupper(self::substr($str, 0, 1)) . self::substr($str, 1);
	}
	
	/**
	 * 取整的值
	 * @return int|float	 
	 */		
	public static function ceilf($value, $precision = 0) 
	{
		$precisionFactor = $precision == 0 ? 1 : pow(10, $precision);
		$tmp = $value * $precisionFactor;
		$tmp2 = (string) $tmp;

		if (strpos($tmp2, '.') === false)
			return ($value);
		if ($tmp2[strlen($tmp2) - 1] == 0)
			return $value;
		return ceil($tmp) / $precisionFactor;
	}

	/**
	 * 舍去小数部分取整
	 * @return int	 
	 */
	public static function floorf($value, $precision = 0)
	{
		$precisionFactor = $precision == 0 ? 1 : pow(10, $precision);
		$tmp = $value * $precisionFactor;
		$tmp2 = (string) $tmp;
		// If the current value has already the desired precision
		if (strpos($tmp2, '.') === false)
			return ($value);
		if ($tmp2[strlen($tmp2) - 1] == 0)
			return $value;
		return floor($tmp) / $precisionFactor;
	}

	/**
	 * 替换URL空格
	 * @return string	 
	 */
	public static function replaceSpace($url) 
	{
		return urlencode(strtolower(preg_replace('/[ ]+/', '-', trim($url, ' -/,.?'))));
	}
		
	
	/**
	 * 数字转换成 bytes
	 * @return string	 
	 */	
	public static function convertBytes($value)
	{
		if (is_numeric($value))
			return $value;
		else {
			$value_length = strlen($value);
			$qty = (int) substr($value, 0, $value_length - 1);
			$unit = strtolower(substr($value, $value_length - 1));
			switch ($unit) {
				case 'k':
					$qty *= 1024;
					break;
				case 'm':
					$qty *= 1048576;
					break;
				case 'g':
					$qty *= 1073741824;
					break;
			}
			return $qty;
		}
	}
	
	
	/**
	 * 获得八位字节
	 * @return string	 
	 */	
	public static function getOctets($option)
	{
		if (preg_match('/[0-9]+k/i', $option))
			return 1024 * (int) $option;

		if (preg_match('/[0-9]+m/i', $option))
			return 1024 * 1024 * (int) $option;

		if (preg_match('/[0-9]+g/i', $option))
			return 1024 * 1024 * 1024 * (int) $option;

		return $option;
	}	
	
	public static function convertPinyin($num)
	{    
		$d=array(array("a",-20319),array("ai",-20317),array("an",-20304),array("ang",-20295),array("ao",-20292),array("ba",-20283),array("bai",-20265),array("ban",-20257),array("bang",-20242),array("bao",-20230),array("bei",-20051),array("ben",-20036),array("beng",-20032),array("bi",-20026),array("bian",-20002),array("biao",-19990),array("bie",-19986),array("bin",-19982),array("bing",-19976),array("bo",-19805),array("bu",-19784),array("ca",-19775),array("cai",-19774),array("can",-19763),array("cang",-19756),array("cao",-19751),array("ce",-19746),array("ceng",-19741),array("cha",-19739),array("chai",-19728),array("chan",-19725),array("chang",-19715),array("chao",-19540),array("che",-19531),array("chen",-19525),array("cheng",-19515),array("chi",-19500),array("chong",-19484),array("chou",-19479),array("chu",-19467),array("chuai",-19289),array("chuan",-19288),array("chuang",-19281),array("chui",-19275),array("chun",-19270),array("chuo",-19263),array("ci",-19261),array("cong",-19249),array("cou",-19243),array("cu",-19242),array("cuan",-19238),array("cui",-19235),array("cun",-19227),array("cuo",-19224),array("da",-19218),array("dai",-19212),array("dan",-19038),array("dang",-19023),array("dao",-19018),array("de",-19006),array("deng",-19003),array("di",-18996),array("dian",-18977),array("diao",-18961),array("die",-18952),array("ding",-18783),array("diu",-18774),array("dong",-18773),array("dou",-18763),array("du",-18756),array("duan",-18741),array("dui",-18735),array("dun",-18731),array("duo",-18722),array("e",-18710),array("en",-18697),array("er",-18696),array("fa",-18526),array("fan",-18518),array("fang",-18501),array("fei",-18490),array("fen",-18478),array("feng",-18463),array("fo",-18448),array("fou",-18447),array("fu",-18446),array("ga",-18239),array("gai",-18237),array("gan",-18231),array("gang",-18220),array("gao",-18211),array("ge",-18201),array("gei",-18184),array("gen",-18183),array("geng",-18181),array("gong",-18012),array("gou",-17997),array("gu",-17988),array("gua",-17970),array("guai",-17964),array("guan",-17961),array("guang",-17950),array("gui",-17947),array("gun",-17931),array("guo",-17928),array("ha",-17922),array("hai",-17759),array("han",-17752),array("hang",-17733),array("hao",-17730),array("he",-17721),array("hei",-17703),array("hen",-17701),array("heng",-17697),array("hong",-17692),array("hou",-17683),array("hu",-17676),array("hua",-17496),array("huai",-17487),array("huan",-17482),array("huang",-17468),array("hui",-17454),array("hun",-17433),array("huo",-17427),array("ji",-17417),array("jia",-17202),array("jian",-17185),array("jiang",-16983),array("jiao",-16970),array("jie",-16942),array("jin",-16915),array("jing",-16733),array("jiong",-16708),array("jiu",-16706),array("ju",-16689),array("juan",-16664),array("jue",-16657),array("jun",-16647),array("ka",-16474),array("kai",-16470),array("kan",-16465),array("kang",-16459),array("kao",-16452),array("ke",-16448),array("ken",-16433),array("keng",-16429),array("kong",-16427),array("kou",-16423),array("ku",-16419),array("kua",-16412),array("kuai",-16407),array("kuan",-16403),array("kuang",-16401),array("kui",-16393),array("kun",-16220),array("kuo",-16216),array("la",-16212),array("lai",-16205),array("lan",-16202),array("lang",-16187),array("lao",-16180),array("le",-16171),array("lei",-16169),array("leng",-16158),array("li",-16155),array("lia",-15959),array("lian",-15958),array("liang",-15944),array("liao",-15933),array("lie",-15920),array("lin",-15915),array("ling",-15903),array("liu",-15889),array("long",-15878),array("lou",-15707),array("lu",-15701),array("lv",-15681),array("luan",-15667),array("lue",-15661),array("lun",-15659),array("luo",-15652),array("ma",-15640),array("mai",-15631),array("man",-15625),array("mang",-15454),array("mao",-15448),array("me",-15436),array("mei",-15435),array("men",-15419),array("meng",-15416),array("mi",-15408),array("mian",-15394),array("miao",-15385),array("mie",-15377),array("min",-15375),array("ming",-15369),array("miu",-15363),array("mo",-15362),array("mou",-15183),array("mu",-15180),array("na",-15165),array("nai",-15158),array("nan",-15153),array("nang",-15150),array("nao",-15149),array("ne",-15144),array("nei",-15143),array("nen",-15141),array("neng",-15140),array("ni",-15139),array("nian",-15128),array("niang",-15121),array("niao",-15119),array("nie",-15117),array("nin",-15110),array("ning",-15109),array("niu",-14941),array("nong",-14937),array("nu",-14933),array("nv",-14930),array("nuan",-14929),array("nue",-14928),array("nuo",-14926),array("o",-14922),array("ou",-14921),array("pa",-14914),array("pai",-14908),array("pan",-14902),array("pang",-14894),array("pao",-14889),array("pei",-14882),array("pen",-14873),array("peng",-14871),array("pi",-14857),array("pian",-14678),array("piao",-14674),array("pie",-14670),array("pin",-14668),array("ping",-14663),array("po",-14654),array("pu",-14645),array("qi",-14630),array("qia",-14594),array("qian",-14429),array("qiang",-14407),array("qiao",-14399),array("qie",-14384),array("qin",-14379),array("qing",-14368),array("qiong",-14355),array("qiu",-14353),array("qu",-14345),array("quan",-14170),array("que",-14159),array("qun",-14151),array("ran",-14149),array("rang",-14145),array("rao",-14140),array("re",-14137),array("ren",-14135),array("reng",-14125),array("ri",-14123),array("rong",-14122),array("rou",-14112),array("ru",-14109),array("ruan",-14099),array("rui",-14097),array("run",-14094),array("ruo",-14092),array("sa",-14090),array("sai",-14087),array("san",-14083),array("sang",-13917),array("sao",-13914),array("se",-13910),array("sen",-13907),array("seng",-13906),array("sha",-13905),array("shai",-13896),array("shan",-13894),array("shang",-13878),array("shao",-13870),array("she",-13859),array("shen",-13847),array("sheng",-13831),array("shi",-13658),array("shou",-13611),array("shu",-13601),array("shua",-13406),array("shuai",-13404),array("shuan",-13400),array("shuang",-13398),array("shui",-13395),array("shun",-13391),array("shuo",-13387),array("si",-13383),array("song",-13367),array("sou",-13359),array("su",-13356),array("suan",-13343),array("sui",-13340),array("sun",-13329),array("suo",-13326),array("ta",-13318),array("tai",-13147),array("tan",-13138),array("tang",-13120),array("tao",-13107),array("te",-13096),array("teng",-13095),array("ti",-13091),array("tian",-13076),array("tiao",-13068),array("tie",-13063),array("ting",-13060),array("tong",-12888),array("tou",-12875),array("tu",-12871),array("tuan",-12860),array("tui",-12858),array("tun",-12852),array("tuo",-12849),array("wa",-12838),array("wai",-12831),array("wan",-12829),array("wang",-12812),array("wei",-12802),array("wen",-12607),array("weng",-12597),array("wo",-12594),array("wu",-12585),array("xi",-12556),array("xia",-12359),array("xian",-12346),array("xiang",-12320),array("xiao",-12300),array("xie",-12120),array("xin",-12099),array("xing",-12089),array("xiong",-12074),array("xiu",-12067),array("xu",-12058),array("xuan",-12039),array("xue",-11867),array("xun",-11861),array("ya",-11847),array("yan",-11831),array("yang",-11798),array("yao",-11781),array("ye",-11604),array("yi",-11589),array("yin",-11536),array("ying",-11358),array("yo",-11340),array("yong",-11339),array("you",-11324),array("yu",-11303),array("yuan",-11097),array("yue",-11077),array("yun",-11067),array("za",-11055),array("zai",-11052),array("zan",-11045),array("zang",-11041),array("zao",-11038),array("ze",-11024),array("zei",-11020),array("zen",-11019),array("zeng",-11018),array("zha",-11014),array("zhai",-10838),array("zhan",-10832),array("zhang",-10815),array("zhao",-10800),array("zhe",-10790),array("zhen",-10780),array("zheng",-10764),array("zhi",-10587),array("zhong",-10544),array("zhou",-10533),array("zhu",-10519),array("zhua",-10331),array("zhuai",-10329),array("zhuan",-10328),array("zhuang",-10322),array("zhui",-10315),array("zhun",-10309),array("zhuo",-10307),array("zi",-10296),array("zong",-10281),array("zou",-10274),array("zu",-10270),array("zuan",-10262),array("zui",-10260),array("zun",-10256),array("zuo",-10254));
		
		if($num>0&$num<160)
		{    
		   return chr($num);    
		}    
		elseif($num<-20319||$num>-10247)
		{    
		   return "";    
		}
		else
		{    
		   for($i=count($d)-1;$i>=0;$i--)    
		   {
			   if($d[$i][1]<=$num)break;
		   }  
			 
		   return $d[$i][0];    
		   
		}    
	}    

	/**
	 * 汉字转换成拼音
	 * @return string	 
	 */	     
	public static function getPinYin($str,$isShort=false)
	{    
		$str = iconv('utf-8','gbk',$str);
		$ret="";   
		 
		for($i=0;$i<strlen($str);$i++)
		{    
		   $p=ord(substr($str,$i,1));    
		   
		   if($p>160)
		   {    
			$q=ord(substr($str,++$i,1));    
			$p=$p*256+$q-65536;    
		   } 
		
		   $word = self::convertPinyin($p);
		
		   if($isShort)
			   $word = substr($word,0,1);
			  
		   $ret.= $word;
		}    
		
		return $ret;    
	} 
	
	public static function convertRtoBR($str)
	{
		$str = str_replace("\r","<br>",$str);
		return $str;
	}
	
	/**
	 * 全角转半角
	 * @return string	 
	 */	   	
	function convertBanJiao($str)
	{
	    $ret='';
	
	    for($i=0;$i<strlen($str);$i++)
		{
	        $s1=$str[$i];
	
	        if(($c=ord($s1))&0x80){
	            $s2=$str[++$i];
	            $s3=$str[++$i];
	            $c=(($c&0xF)<<12)|((ord($s2)&0x3F)<<6)|(ord($s3)&0x3F);
	            if($c==12288){
	                $ret.=' ';
	            }elseif($c>65280&&$c<65375&&$c!=65374){
	                $c-=65248;
	                $ret.=chr($c);
	            }else{
	                $ret.=$s1.$s2.$s3;
	            }
	        }else{
	            $ret.=$str[$i];
	        }
	    }
	
	    return $ret;
	}		
	
	//==============================================
	// 系统
	//==============================================
	
	/**
	 * 返回网站的根目录
	 * @return string
	 */	
	public static function getSiteDir()
	{
		return $_SERVER['DOCUMENT_ROOT'];
	}		

	/**
	 * 获取当前域名
	 * @return string	 
	 */
	public static function getHttpHost($http = false, $entities = false)
	{
		$host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
		
		if ($entities)
			$host = htmlspecialchars($host, ENT_COMPAT, 'UTF-8');
		if ($http) {
			$host = self::getCurrentUrlProtocolPrefix().$host;
		}
		return $host;
	}	
	
	/**
	 * 获取当前URL协议
	 * @return string
	 */
	public static function getCurrentUrlProtocolPrefix()
	{
		if (Tools::usingSecureMode())
			return 'https://';
		else
			return 'http://';
	}
	
	/**
	 * 判断是否使用了HTTPS
	 */
	public static function usingSecureMode()
	{
		if (isset($_SERVER['HTTPS']))
			return ($_SERVER['HTTPS'] == 1 || strtolower($_SERVER['HTTPS']) == 'on');
		if (isset($_SERVER['SSL']))
			return ($_SERVER['SSL'] == 1 || strtolower($_SERVER['SSL']) == 'on');
			
		return false;
	}	
	
	/**
	 * 清理URL中的http头
	 * @return string
	 */
	public static function cleanUrl($url, $cleanall = true)
	{
		if (strpos($url, 'http://') !== false){
			if ($cleanall) {
				return '/';
			}
			else {
				return str_replace('http://', '', $url);
			}
		}
		
		return $url;
	}
	
	/**
	 * 跳转
	 */
	public static function redirect($url, $headers = null)
	{
		if (!empty($url)) {
			if ($headers) {
				if (!is_array($headers))
					$headers = array($headers);

				foreach ($headers as $header)
					header($header);
			}

			header('Location:'.$url);
			exit;
		}
	}
	
	public static function redirectTo($link)
	{
		if (strpos($link, 'http') !== false) {
			header('Location: ' . $link);
		}
		else {
			header('Location: ' . Tools::getHttpHost(true) . '/' . $link);
		}
		exit;
	}	
		
	/**
	 * 获取当前服务器名
	 * @return string
	 */
	public static function getServerName()
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_SERVER']) && $_SERVER['HTTP_X_FORWARDED_SERVER'])
			return $_SERVER['HTTP_X_FORWARDED_SERVER'];
			
		return $_SERVER['SERVER_NAME'];
	}		
	
	/**
	 * 判断是否手机访问
	 * @return bool
	 */	
	public static function is_mobile_request()
	{
		$_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
	 
		$mobile_browser = '0';
	 
		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
			$mobile_browser++;
	 
		if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
			$mobile_browser++;
	 
		if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
			$mobile_browser++;
	 
		if(isset($_SERVER['HTTP_PROFILE']))
			$mobile_browser++;
	 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
		$mobile_agents = array(
							'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
							'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
							'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
							'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
							'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
							'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
							'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
							'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
							'wapr','webc','winw','winw','xda','xda-'
							);
	 
		if(in_array($mobile_ua, $mobile_agents))
			$mobile_browser++;
	 
		if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
			$mobile_browser++;
	 
		// Pre-final check to reset everything if the user is on Windows
		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
			$mobile_browser=0;
	 
		// But WP7 is also Windows, with a slightly different characteristic
		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
			$mobile_browser++;
	 
		if($mobile_browser>0)
			return true;
		else
			return false;
	}
	
	/**
	* 获取客户端IP地址
	* @return string
	*/
	public static function getClientIp() 
	{
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
			return $_SERVER["HTTP_CLIENT_IP"];
	  
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			$proxy_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		elseif (($tmp_ip = getenv("HTTP_X_FORWARDED_FOR")))
			$proxy_ip = $tmp_ip;
		else
			$proxy_ip = '';
	  
		if ('' !== $proxy_ip) {
			if (false === strpos($proxy_ip, ','))
				return $proxy_ip;
	  
			foreach (explode(',', $proxy_ip) as $curr_ip) {// 处理可能有多级代理的情况
				if (false === stripos($curr_ip, 'unknown'))
					$curr_ip = ltrim($curr_ip);
				else
					continue;
	  
				if (0 === strpos($curr_ip, '192.168.'))
					continue; // 内网IP
				if (0 === strpos($curr_ip, '10.'))
					continue; // 内网IP
				if (0 === strpos($curr_ip, '172.16.'))
					continue; // 内网IP
				return $curr_ip;
			}
		}
	  
		if (!empty($_SERVER["REMOTE_ADDR"]))
			return $_SERVER["REMOTE_ADDR"];
		elseif (($retvl = getenv("HTTP_CLIENT_IP")))
			return $retvl;
		elseif (($retvl = getenv("REMOTE_ADDR")))
			return $retvl;
		else
			return '0.0.0.0';
	}
	
	/**
	 * 获取用户来源地址
	 * @return string
	 */
	public static function getReferer() 
	{
		if (isset($_SERVER['HTTP_REFERER'])) {
			return $_SERVER['HTTP_REFERER'];
		}
		else if(isset($_SERVER['REQUEST_URI'])) {
			return $_SERVER['REQUEST_URI'];
		}
		else {
			return "";
		}
	}	
	
	/**
	 * 判断是否爬虫，范围略大
	 * @return bool
	 */
	public static function isSpider()
	{
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		$spiders = array('spider', 'bot');
		foreach ($spiders as $spider) {
			if (strpos($ua, $spider) !== false) {
				return true;
			}
		}
		return false;
	}

	/**
	 * 判断是否命令行执行
	 * @return bool
	 */
	public static function isCli()
	{
		if (isset($_SERVER['SHELL']) && !isset($_SER['HTTP_HOST'])) {
			return true;
		}
		return false;
	}	
	
	/**
	 * 临时目录
	 * @return string
	 */	
	public static function sys_get_temp_dir()
	{
		if(function_exists('sys_get_temp_dir')){
			return sys_get_temp_dir();
		}
		if( $temp=getenv('TMP') ){
			return $temp;
		}
		if( $temp=getenv('TEMP') ) {
			return $temp;
		}
		if( $temp=getenv('TMPDIR') ) {
			return $temp;
		}
		$temp = tempnam(__FILE__,'');
		if ( file_exists($temp) ){
			unlink($temp);
			return dirname($temp);
		}
		return null;
	}	
	
	/**
	 * 判断是否64位架构
	 * @return bool
	 */
	public static function isX86_64arch() 
	{
		return (PHP_INT_MAX == '9223372036854775807');
	}
	
	/**
	 * 获取内存限制
	 * @return int
	 */
	public static function getMemoryLimit()
	{
		$memory_limit = @ini_get('memory_limit');
		return Tools::getOctets($memory_limit);
	}		
	
	/**
	 * 获取服务器配置允许最大上传文件大小
	 * @return mixed
	 */
	public static function getMaxUploadSize($max_size = 0)
	{
		$post_max_size = Tools::convertBytes(ini_get('post_max_size'));
		$upload_max_filesize = Tools::convertBytes(ini_get('upload_max_filesize'));
		if ($max_size > 0)
			$result = min($post_max_size, $upload_max_filesize, $max_size);
		else
			$result = min($post_max_size, $upload_max_filesize);
		return $result;
	}		

	//==============================================
	// 安全
	//==============================================	
	
	/**
	 * 判断是否本站链接
	 * @return string
	 */
	public static function secureReferrer($referrer)
	{
		if (preg_match('/^http[s]?:\/\/'.Tools::getServerName().'(:443)?\/.*$/Ui',$referrer))
			return $referrer;
			
		return '/';
	}
	
	/**
	 * 获取POST或GET的指定字段内容
	 * @return string or bool
	 */
	public static function getValue($key, $default_value = false) 
	{
		if (!isset($key) || empty($key) || !is_string($key))
			return false;
			
		$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default_value));

		if (is_string($ret) === true)
			$ret = trim(urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret))));
			
		return !is_string($ret) ? $ret : stripslashes($ret);
	}

	/**
	 * 判断POST或GET中是否包含指定字段 
	 * @return bool
	 */
	public static function getIsset($key)
	{
		if (!isset($key) || empty($key) || !is_string($key))
			return false;
			
		return isset($_POST[$key]) ? true : (isset($_GET[$key]) ? true : false);
	}

	/**
	 * 判断是否为提交操作
	 */
	public static function isSubmit($submit) 
	{
		return (isset($_POST[$submit]) || isset($_POST[$submit . '_x']) || isset($_POST[$submit . '_y']) || isset($_GET[$submit]) || isset($_GET[$submit . '_x']) || isset($_GET[$submit . '_y']));
	}

	/**
	 * 对POST内容进行处理
	 */
	public static function safePostVars()
	{
		if (!is_array($_POST))
			return array();
		$_POST = array_map(array('Tools', 'htmlentitiesUTF8'), $_POST);
	}		

	/**
	 * XSS
	 * @return mixed
	 */
	public static function removeXSS($str) 
	{
		$str = str_replace('<!--  -->', '', $str);
		$str = preg_replace('~/\*[ ]+\*/~i', '', $str);
		$str = preg_replace('/\\\0{0,4}4[0-9a-f]/is', '', $str);
		$str = preg_replace('/\\\0{0,4}5[0-9a]/is', '', $str);
		$str = preg_replace('/\\\0{0,4}6[0-9a-f]/is', '', $str);
		$str = preg_replace('/\\\0{0,4}7[0-9a]/is', '', $str);
		$str = preg_replace('/&#x0{0,8}[0-9a-f]{2};/is', '', $str);
		$str = preg_replace('/&#0{0,8}[0-9]{2,3};/is', '', $str);
		$str = preg_replace('/&#0{0,8}[0-9]{2,3};/is', '', $str);

		$str = htmlspecialchars($str);
		//$str = preg_replace('/&lt;/i', '<', $str);
		//$str = preg_replace('/&gt;/i', '>', $str);

		// 非成对标签
		$lone_tags = array("img", "param", "br", "hr");
		foreach ($lone_tags as $key => $val) {
			$val = preg_quote($val);
			$str = preg_replace('/&lt;' . $val . '(.*)(\/?)&gt;/isU', '<' . $val . "\\1\\2>", $str);
			$str = self::transCase($str);
			$str = preg_replace_callback('/<' . $val . '(.+?)>/i', create_function('$temp', 'return str_replace("&quot;","\"",$temp[0]);'), $str);
		}
		$str = preg_replace('/&amp;/i', '&', $str);

		// 成对标签
		$double_tags = array("table", "tr", "td", "font", "a", "object", "embed", "p", "strong", "em", "u", "ol", "ul", "li", "div", "tbody", "span", "blockquote", "pre", "b", "font");
		foreach ($double_tags as $key => $val) {
			$val = preg_quote($val);
			$str = preg_replace('/&lt;' . $val . '(.*)&gt;/isU', '<' . $val . "\\1>", $str);
			$str = self::transCase($str);
			$str = preg_replace_callback('/<' . $val . '(.+?)>/i', create_function('$temp', 'return str_replace("&quot;","\"",$temp[0]);'), $str);
			$str = preg_replace('/&lt;\/' . $val . '&gt;/is', '</' . $val . ">", $str);
		}
		// 清理js
		$tags = Array(
			'javascript',
			'vbscript',
			'expression',
			'applet',
			'meta',
			'xml',
			'behaviour',
			'blink',
			'link',
			'style',
			'script',
			'embed',
			'object',
			'iframe',
			'frame',
			'frameset',
			'ilayer',
			'layer',
			'bgsound',
			'title',
			'base',
			'font'
		);

		foreach ($tags as $tag) 
		{
			$tag = preg_quote($tag);
			$str = preg_replace('/' . $tag . '\(.*\)/isU', '\\1', $str);
			$str = preg_replace('/' . $tag . '\s*:/isU', $tag . '\:', $str);
		}

		$str = preg_replace('/[\s]+on[\w]+[\s]*=/is', '', $str);

		Return $str;
	}

	public static function transCase($str) 
	{
		$str = preg_replace('/(e|ｅ|Ｅ)(x|ｘ|Ｘ)(p|ｐ|Ｐ)(r|ｒ|Ｒ)(e|ｅ|Ｅ)(s|ｓ|Ｓ)(s|ｓ|Ｓ)(i|ｉ|Ｉ)(o|ｏ|Ｏ)(n|ｎ|Ｎ)/is', 'expression', $str);
		return $str;
	}	

	//==============================================
	// 加密
	//==============================================
	
	public static function urlencrypt($string)
	{
		return base64_encode(urlencode($string));
	}
	
	public static function urldecrypt($string)
	{
		return urldecode(base64_decode($string));
	}	
	
	/**
	 * 加密字符串
	 * @return string
	 */			
	public static function encrypt($string,$key='K6aL3Bo5') 
	{	
		//加密方法 
		$cipher_alg = MCRYPT_TRIPLEDES;
		
		//初始化向量来增加安全性 
		$iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg,MCRYPT_MODE_ECB), MCRYPT_RAND); 
		 
		//开始加密 
		$encrypted_string = mcrypt_encrypt($cipher_alg, $key, $string, MCRYPT_MODE_ECB, $iv); 
		
		return base64_encode($encrypted_string);//转化成16进制
	}

	/**
	 * 解密字符串
	 * @return string
	 */	
	public static function decrypt($string,$key='K6aL3Bo5') 
	{
	   $string = base64_decode($string);
	
	   //加密方法 
	   $cipher_alg = MCRYPT_TRIPLEDES;
	
	   //初始化向量来增加安全性 
	   $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg,MCRYPT_MODE_ECB), MCRYPT_RAND); 
	
	   //开始加密 
	   $decrypted_string = mcrypt_decrypt($cipher_alg, $key, $string, MCRYPT_MODE_ECB, $iv); 
	
	   return trim($decrypted_string);
	}
	
	/**
	 * 计算字符串的32位哈希值
	 * @return int
	 */
	public static function Hash32($str, $useMd5 = false) 
	{
		if (true === $useMd5)
			return crc32(md5($str));
		else
			return crc32($str);
	}

	//==============================================
	// 转换
	//==============================================
	public static function nl2br($str)
	{
		return preg_replace("/((<br ?\/?>)+)/i", "<br />", str_replace(array("\r\n", "\r", "\n"), "<br />", $str));
	}

	public static function br2nl($str)
	{
		return str_replace("<br />", "\n", $str);
	}

	//==============================================
	// 验证
	//==============================================
	/**
	 * 判断是否真为空
	 * @return bool
	 */
	public static function isEmpty($field) 
	{
		return ($field === '' || $field === null);
	}		
	
	/**
	 * 匹配是否全数字
	 * @return bool
	 */	
	public static function isInt($field)
	{
		return preg_match("/^\d*$/",$field);		
	}
	
	/**
	 * 匹配是否全字母
	 * @return bool
	 */	
	public static function isEn($field)
	{
	  return preg_match("/^[a-zA-Z]*$/i",$field);		
	}	
	
	/**
	 * 是否包含中文
	 * @return bool
	 */	
	public static function isCn($field)
	{
	  return preg_match("/[\x{4e00}-\x{9fa5}]/u",$field);		
	}	
	
	/**
	 * 判断是否为整数(包括负整数和正整数)
	 * @return bool
	 */
	public static function isInteger($arg) 
	{
		try {
			if (is_nan($arg))
				return false;
		} catch (Exception $ex) {
			return false;
		}

		if (is_numeric($arg) AND (false === strpos($arg, '.')) AND (false === stripos($arg, 'e'))) {
			return true;
		}
		else
			return false;
	}	
	
	/**
	 * 判断是否为浮点数（支持字符串验证）
	 * @return bool
	 */
	public static function isFloat($arg) 
	{
		try {
			if (is_nan($arg))
				return false;
		} catch (Exception $ex) {
			return false;
		}

		return is_float(abs($arg));
	}	
	
	/**
	 * 判断是否为自然数
	 * 自然数是零和所有的正整数
	 * @return bool
	 */
	public static function isNaturalNumber($arg) 
	{
		try {
			if (is_nan($arg))
				return false;
		} catch (Exception $ex) {
			return false;
		}

		if (is_numeric($arg) AND ($arg >= 0) AND (false === strpos($arg, '.')) AND (false === stripos($arg, 'e'))) {
			return true;
		}
		else
			return false;
	}

	/**
	 * 判断是否为负数
	 * @return bool
	 */
	public static function isNegative($arg) 
	{
		try {
			if (is_nan($arg))
				return false;
		} catch (Exception $ex) {
			return false;
		}
		if (is_numeric($arg) AND ($arg < 0))
			return true;
		else
			return false;
	}
	
	/**
	 * 如果 $arg 超出范围，返回 true，否则返回 false
	 * @return bool
	 */
	public static function isOutOfRange($arg, $min = null, $max = null)
	{
		if (!is_numeric($arg))
			throw new InvalidArgumentException('$arg');

		if (isset($min)) {
			if (!is_numeric($min))
				throw new InvalidArgumentException('$min');
			$t1 = true;
		}
		else
			$t1 = false;
		if (isset($max)) {
			if (!is_numeric($max))
				throw new InvalidArgumentException('$max');
			$t2 = true;
		}
		else
			$t2 = false;
		if (!$t1 AND !$t2)
			throw new InvalidArgumentException('$min and $max is null');

		if ($t1 AND $t2)
			return (($arg < $min) OR ($arg > $max));
		elseif ($t1)
			return ($arg < $min);
		else
			return ($arg > $max);
	}	

	//==============================================
	// 数据
	//==============================================	
	/**
	 * 对象转换成 json 格式
	 */	
	public static function json_encode($obj)
	{
		return json_encode($obj,JSON_UNESCAPED_UNICODE);
	}
	/**
	 * json 转换成对象
	 */	
	public static function json_decode($obj)
	{
		return json_decode($obj,true);
	}	
	
	/**
	 * 以固定格式将数据及状态码返回手机端
	 * @return json
	 */
	public static function returnMobileJson($code, $data, $native = false)
	{
		if (!headers_sent()) {
			header("Content-Type: application/json; charset=utf-8");
		}
		if (is_array($data) && $native) {
			self::walkArray($data, 'urlencode', true);
			echo(urldecode(json_encode(array('code' => $code, 'data' => $data))));
		}
		elseif (is_string($data) && $native) {
			echo(urldecode(json_encode(array('code' => $code, 'data' => urlencode($data)))));
		}
		else {
			echo(json_encode(array('code' => $code, 'data' => $data)));
		}
		ob_end_flush();
		exit;
	}	

	/**
	 * 以固定格式将数据及状态码返回PC端
	 * @return json
	 */	
	public static function returnAjaxJson($array) 
	{
		if (!headers_sent()) {
			header("Content-Type: application/json; charset=utf-8");
		}
		echo(json_encode($array));
		ob_end_flush();
		exit;
	}	

	//==============================================
	// 数组
	//==============================================	
		
	/**
	 * 从array中取出指定字段
	 * @return array|null
	 */
	public static function simpleArray($array, $key)
	{
		if (!empty($array) && is_array($array)) {
			$result = array();
			foreach ($array as $k => $item) {
				$result[$k] = $item[$key];
			}
			return $result;
		}
		return null;
	}

	public static function object2array(&$object)
	{
		return json_decode(json_encode($object), true);
	}

	/*
	* 移除数组中重复的值
	* @return array
	*/
	public static function arrayUnique($array)
	{
		if (version_compare(phpversion(), '5.2.9', '<'))
			return array_unique($array);
		else
			return array_unique($array, SORT_REGULAR);
	}

	/*
	* 移除数组中重复的值
	* @return array
	*/
	public static function arrayUnique2d($array, $keepkeys = true) 
	{
		$output = array();
		if (!empty($array) && is_array($array)) {
			$stArr = array_keys($array);
			$ndArr = array_keys(end($array));

			$tmp = array();
			foreach ($array as $i) {
				$i = join("¤", $i);
				$tmp[] = $i;
			}

			$tmp = array_unique($tmp);

			foreach ($tmp as $k => $v) {
				if ($keepkeys)
					$k = $stArr[$k];
				if ($keepkeys) {
					$tmpArr = explode("¤", $v);
					foreach ($tmpArr as $ndk => $ndv) {
						$output[$k][$ndArr[$ndk]] = $ndv;
					}
				}
				else {
					$output[$k] = explode("¤", $v);
				}
			}
		}
		return $output;
	}	
	
	/**
	 * 遍历数组
	 */
	public static function walkArray(&$array, $function, $keys = false) 
	{
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				self::recursive($array[$key], $function, $keys);
			}
			elseif (is_string($value)) {
				$array[$key] = $function($value);
			}

			if ($keys && is_string($key)) {
				$newkey = $function($key);
				if ($newkey != $key) {
					$array[$newkey] = $array[$key];
					unset($array[$key]);
				}
			}
		}
	}		
	
	//==============================================
	// SEO相关
	//==============================================
	/*
	* 获得从搜索引擎过来的关键词和搜索引擎的类型
	* @return array
	*/
	function getSeoReferrer($nourl='')
	{
		$referer = self::getReferer();
				
		if($referer == "") return null;
		
		$regx_1 = "";
		$regx_2 = "";
		
		$word = "";		
		$type = "";
		
		if($nourl != "")
		{
			if(self::findString($nourl,$referer))
			{
				return null;
			}
		}
		
		if(self::findString("baidu.com",$referer))
		{
			$regx_1 = "/wd=(.*?)\&/x";
			$regx_2 = "/wd=(.*)/x";
			
			$type = "baidu";
		}
		else if(self::findString("soso.com",$referer))
		{
			$regx_1 = "/w=(.*?)\&/x";
			$regx_2 = "/w=(.*)/x";
			
			$type = "soso";			
		}
		else if(self::findString("google.com",$referer))
		{
			$regx_1 = "/q=(.*?)\&/x";
			$regx_2 = "/q=(.*)/x";
			
			$type = "google";				
		}
		else if(self::findString("sogou.com",$referer))
		{
			$regx_1 = "/query=(.*?)\&/x";
			$regx_2 = "/query=(.*)/x";
			
			$type = "sogou";				
		}
		else if(self::findString("so.",$referer))
		{
			$regx_1 = "/q=(.*?)\&/x";
			$regx_2 = "/q=(.*)/x";
			
			$type = "360";			
		}
		else if(self::findString("bing.com",$referer))
		{
			$regx_1 = "/q=(.*?)\&/x";
			$regx_2 = "/q=(.*)/x";
			
			$type = "bing";		
		}	
		else if(self::findString("yahoo.cn",$referer))
		{
			$regx_1 = "/q=(.*?)\&/x";
			$regx_2 = "/q=(.*)/x";
			
			$type = "yahoo";				
		}
		else if(self::findString("youdao.com",$referer))
		{
			$regx_1 = "/q=(.*?)\&/x";
			$regx_2 = "/q=(.*)/x";
			
			$type = "youdao";				
		}											
				
		if($regx_1 == "") return null;
		
		$datetime = strtotime(localdate());
		
		if(preg_match($regx_1,$referer, $param))
		{
			$word = trim(urldecode($param[1]));
		}
		else
		{
			if(preg_match($regx_2,$referer, $param))
			{
				$word = trim(urldecode($param[1]));
			}
			else
			{
				return null;
			}
		}

		$encode = mb_detect_encoding($word, array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
		$word = trim(iconv($encode, 'UTF-8', $word));

		return array('word'=>$word,'type'=>$type);
	}

	//==============================================
	// 采集
	//==============================================
	
	/**
	 * 优化的file_get_contents操作，超时关闭
	 * @return bool|mixed|string
	 */
	public static function file_get_contents($url, $use_include_path = false, $stream_context = null, $curl_timeout = 8)
	{
		if ($stream_context == null && preg_match('/^https?:\/\//', $url))
			$stream_context = @stream_context_create(array('http' => array('timeout' => $curl_timeout)));
		if (in_array(ini_get('allow_url_fopen'), array('On', 'on', '1')) || !preg_match('/^https?:\/\//', $url))
			return @file_get_contents($url, $use_include_path, $stream_context);
		elseif (function_exists('curl_init')) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($curl, CURLOPT_TIMEOUT, $curl_timeout);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$opts = stream_context_get_options($stream_context);
			if (isset($opts['http']['method']) && Tools::strtolower($opts['http']['method']) == 'post') {
				curl_setopt($curl, CURLOPT_POST, true);
				if (isset($opts['http']['content'])) {
					parse_str($opts['http']['content'], $datas);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $datas);
				}
			}
			$content = curl_exec($curl);
			curl_close($curl);
			return $content;
		}
		else
			return false;
	}		
	
	/**
	 * curl操作
	 */
	public static function curl($url, $method = 'GET', $postFields = null, $header = null) 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);

		if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		switch ($method) {
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, true);
				if (!empty($postFields) && is_array($postFields)) {
					$postBodyString = "";
					$postMultipart = false;
					foreach ($postFields as $k => $v) {
						if ("@" != substr($v, 0, 1)) { //判断是不是文件上传
							$postBodyString .= "$k=" . urlencode($v) . "&";
						}
						else { //文件上传用multipart/form-data，否则用www-form-urlencoded
							$postMultipart = true;
						}
					}
					unset($k, $v);
					if ($postMultipart) {
						curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
					}
					else {
						curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
					}
				}
				break;
			default:
				if (!empty($postFields) && is_array($postFields))
					$url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($postFields);
				break;
		}
		curl_setopt($ch, CURLOPT_URL, $url);

		if (!empty($header) && is_array($header)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		$reponse = curl_exec($ch);
		if (curl_errno($ch)) {
			throw new Exception(curl_error($ch), 0);
		}
		curl_close($ch);
		return $reponse;
	}

	//==============================================
	// 其它
	//==============================================	
	
	/**
	 * 反序列化
	 */
	public static function getUnSerialize($val)
	{
		return unserialize($val);
	}
	
	/**
	 * 序列化
	 */
	public static function getSerialize($val)
	{
		return serialize($val);
	}	
	
	/**
	 * HackNews热度计算公式
	 * @return float|int
	 */
	public static function getGravity($time, $viewcount)
	{
		$timegap = ($_SERVER['REQUEST_TIME'] - strtotime($time)) / 3600;
		if ($timegap <= 24) {
			return 999999;
		}
		return round((pow($viewcount, 0.8) / pow(($timegap + 24), 1.2)), 3) * 1000;
	}

	public static function getGravityS($stime, $viewcount)
	{
		$timegap = ($_SERVER['REQUEST_TIME'] - $stime) / 3600;
		if ($timegap <= 24) {
			return 999999;
		}
		return round((pow($viewcount, 0.8) / pow(($timegap + 24), 1.2)), 3) * 1000;
	}
	
	public static function ZipTest($from_file) 
	{
		$zip = new PclZip($from_file);
		return ($zip->privCheckFormat() === true);
	}

	public static function ZipExtract($from_file, $to_dir)
	{
		if (!file_exists($to_dir))
			mkdir($to_dir, 0777);
		$zip = new PclZip($from_file);
		$list = $zip->extract(PCLZIP_OPT_PATH, $to_dir);
		return $list;
	}		
	
	/*
	* PSCWS分词
	*/
	public static function cmpWord($a, $b)
	{
		if ($a['word'] > $b['word']) {
			return 1;
		}
		elseif ($a['word'] == $b['word']) {
			return 0;
		}
		else {
			return -1;
		}
	}
	
	//获取分页的 Limit 值
	public static function getPageLimit($total_rows,$page_num,$rows_per_page=10)
	{
		if($total_rows == "0")
			return $total_rows;
		
		$last_page = ceil($total_rows / $rows_per_page);

        $page_num = (int) $page_num;

        if ($page_num < 1)
        {
           $page_num = 1;
        }
        elseif ($page_num > $last_page)
        {
           $page_num = $last_page;
        }

        $upto = ($page_num - 1) * $rows_per_page;
		
		if($upto != 0)
		{
        	return $upto.',' .$rows_per_page;
		}
		else
		{
			return $rows_per_page;
		}
	}	
	
	public static function getPageMaxNum($rowscount,$pagesize=9)
	{
		if($rowscount == 0) return 0;
		$pagecount = ceil($rowscount / $pagesize);
		
		return $pagecount;
	}
	
	

	//分页
	//$pageindex:当前页码
	//$rowscount:记录总数
	//$pagelink:页面链接
	//$pagesize:数字分页的显示数量，默认：10
	//$extClass:扩展样式
	public static function getPageNum($pageindex,$rowscount,$pagelink,$pagesize=9,$pagestyle='page-num')
	{
		$html = '';

		if($rowscount == 0)
			return $html;
		
		$isauto = true;
		$pagecount = ceil($rowscount / $pagesize);
		$numSize = 9;
	
		$plus = ceil($numSize / 2);	

		if($numSize - $plus + $pageindex > $pagecount) 
			$plus = $numSize - $pagecount + $pageindex;
			
		$min = $pageindex - $plus + 1;
		$min = ($min >=1)?$min:1;
		$max = $min + $numSize;

		if($pagecount < $numSize)
			$max = $pagecount;

		if($pagecount != 1)
		{
			$html = "<ul class=\"page-num ${pagestyle}\">\r\n";
			
			if($pageindex >= 6)
			{
				$html .= "<li class=\"num\"><a href=\"".str_replace("{0}", 1, $pagelink)."\">1</a></li>\r\n";       
				$html .= "<li class=\"more\">.</li>\r\n"; 
			}
			
			for($i = $min;$i <= $max;$i++)
			{
				if(($numSize < $pagecount) && ($i == $pagecount))
					break;
				
				if($i == $pageindex)
					$html .= "<li class=\"act\"><span>${i}</span></li>\r\n";                    
				else
					$html .= "<li class=\"num\"><a href=\"".str_replace("{0}", $i, $pagelink)."\">${i}</a></li>\r\n";                   			
			}
			
			if($pagecount > $numSize)
			{
				$html .= "<li class=\"more\">.</li>\r\n";
				$html .= "<li class=\"num\"><a href=\"".str_replace("{0}", $pagecount, $pagelink)."\">${pagecount}</a></li>\r\n";
			}
			
			$html .= "</ul>\r\n";
		}
	
		return $html;
	}
}