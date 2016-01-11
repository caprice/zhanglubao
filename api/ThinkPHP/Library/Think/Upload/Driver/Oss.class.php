<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Jay <yangweijiester@gmail.com> <http://code-tech.diandian.com>
// +----------------------------------------------------------------------
namespace Think\Upload\Driver;
use Think\Upload\Driver\Alioss\AliOSS;
class Oss {
    /**
     * 上传文件根目录
     * @var string
     */
    private $rootPath;

    const DEFAULT_URL = 'oss.aliyuncs.com';

    /**
     * 上传错误信息
     * @var string
     */
    private $error = '';

    public $config = array(
    	'AccessKey'=> '',
        'SecretKey'=> '', //阿里云服务器
        'bucket'   => '', //空间名称
        'rename'   => false,
        'timeout'  => 3600, //超时时间
    );

    public $oss = null;

    /**
     * 构造函数，用于设置上传根路径
     * @param array  $config FTP配置
     */
    public function __construct($config){
        /* 默认FTP配置 */
        $this->config = array_merge($this->config, $config);
        
        $ossClass = dirname(__FILE__). "/Alioss/alioss.class.php";
        if(is_file($ossClass))
            require_once($ossClass);
        $this->oss = new AliOSS ( $this->config['AccessId'], $this->config['AccessKey'], self:: DEFAULT_URL );
 
    
    }

    /**
     * 检测上传根目录(阿里云上传时支持自动创建目录，直接返回)
     * @param string $rootpath   根目录
     * @return boolean true-检测通过，false-检测失败
     */
    public function checkRootPath($rootpath){
        /* 设置根目录 */
        $this->rootPath = str_replace('./', '/', $rootpath);
    	return true;
    }

    /**
     * 检测上传目录(阿里云上传时支持自动创建目录，直接返回)
     * @param  string $savepath 上传目录
     * @return boolean          检测结果，true-通过，false-失败
     */
	public function checkSavePath($savepath){
		 $this->savePath = str_replace('./', '/', $savepath);
		return true;
    }

    /**
     * 创建文件夹 (阿里云上传时支持自动创建目录，直接返回)
     * @param  string $savepath 目录名称
     * @return boolean          true-创建成功，false-创建失败
     */
    public function mkdir($savepath){
    	return true;
    }

    /**
     * 保存指定文件
     * @param  array   $file    保存的文件信息
     * @param  boolean $replace 同名文件是否覆盖
     * @return boolean          保存状态，true-成功，false-失败
     */
    public function save(&$file,$replace=true) {
        $object = "{$file['savepath']}{$file['savename']}";
        $object = str_replace('./', '/', $object);
        $extension= pathinfo($file['name'], PATHINFO_EXTENSION);
        $response = $this->oss->upload_file_by_file( $this->config['bucket'], $object, $file['tmp_name'],$extension);
        $url = $this->download($object);
        $file['url'] = $url;
        
        return $response->isOK() ? true : false;
    }
    
    
    
    public function savetxt($data,$path)
    {
    	$option=array(
			'content' => $data,
			'length' => strlen($data),
		);
    	$response=$this->oss->upload_file_by_content($this->config['bucket'], $path, $option);
    	return $response->isOK() ? true : false;
    }
    
    public function  gettxt($path)
    {
    	$respone=$this->oss->get_object($this->config['bucket'], $path);
    	 if ($respone->isOK()) {
    	 	return   $respone->body;
    	 }else 
    	 {
    	 	return '';
    	 }
    	
    }
    

    public function download($file){
        $file = str_replace('./', '/', $file);
        $opt = array();
        $response = $this->config['cdn'].'/'.$file;
        return $response;
    }
    
   /**
     * 获取最后一次上传错误信息
     * @return string 错误信息
     */
    public function getError(){
        return $this->error;
    }
    
    /**
     * 获取请求错误信息
     * @param  string $header 请求返回头信息
     */
    private function error($header) {
        list($status, $stash) = explode("\r\n", $header, 2);
        list($v, $code, $message) = explode(" ", $status, 3);
        $message = is_null($message) ? 'File Not Found' : "[{$status}]:{$message}";
        $this->error = $message;
    }
}
