<?php

namespace Admin\Model;
use Think\Model;
use Org\Net\Http;
use Org\Net;


class VideoModel extends Model{


	protected $_validate = array(
	array('title', 'require', '标题不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('tags', 'require', '标签不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
	array('game_id', 'require', '请选择游戏', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
	array('description', 'require', '描述不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
	);


	protected $_auto = array(
	array('create_time', NOW_TIME, self::MODEL_INSERT),
	array('update_time', NOW_TIME, self::MODEL_BOTH),
	array('status', '1', self::MODEL_BOTH),
	array('views', '1', self::MODEL_BOTH),
	array('uid', 'get_uid', self::MODEL_INSERT, 'function', 1),
	);

	/**
	 * 更新分类信息
	 * @return boolean 更新状态
	 * @author Rocks
	 */
	public function update(){
		$data = $this->create();
		if(!$data){ //数据对象创建错误
			return false;
		}
		/* 添加或更新数据 */
		if(empty($data['id'])){
			$res = $this->add();
		}else{
			$res = $this->save();
		}
		action_log('update_video', 'video', $data['id'] ? $data['id'] : $res, UID);
		return $res;
	}


	public  function  addVideo($data=array())
	{
		if (!empty($data))
		{
			$image=$this->downfile($data['cover_url']);
			$data['cover']=$image['temp_image']['id'];
			$model = $this->create($data);
			if($model)
			{
				$res=$this->add();
				return  true;
			}else
			{
				return false;
			}

		}else
		{
			$this->error="传入为空";
			return  false;
		}
	}



	public function  downfile($url)
	{
		$path=C('TEMP_PATH');
		$name=md5($url).'.jpg';
		$path=$path.$name;
		Http::curlDownload($url, $path);
		$info['name']=$name;
		$info['type']='image/jpeg';
		$info['tmp_name']=$path;
		$info["error"]= 0;
		$data['temp_image']=$info;

		$Picture = D('Picture');
		$pic_driver = C('PICTURE_UPLOAD_DRIVER');
		$info = $Picture->upload(
		$data,
		C('VIDEO_PICTURE_UPLOAD'),
		C('PICTURE_UPLOAD_DRIVER'),
		C("UPLOAD_{$pic_driver}_CONFIG")
		);

		if($info){
			$return['status'] = 1;
			$return = array_merge($info, $return);
		} else {
			$return['status'] = 0;
			$return['info']   = $Picture->getError();
		}
	 if (file_exists($path)) {
	 	unlink ($myfile);
	 }
		return $return;
	}


	public function getVideoInfo($link) {
		$parseLink = parse_url($link);
		if(preg_match("/(youku.com|youtube.com|qq.com|ku6.com|sohu.com|sina.com.cn|tudou.com|yinyuetai.com)$/i", $parseLink['host'], $hosts)) {
			$flashinfo = $this->_video_getflashinfo($link, $hosts[1]);
		}
		if ($flashinfo['flash_url']) {
			//$flashinfo['host']      = $hosts[1];
			$flashinfo['video_url'] = $link;
			return $flashinfo;
		}else{
			return false;
		}
	}

	public function _weiboTypePublish($type_data){
		$link = $type_data;
		$parseLink = parse_url($link);
		if(preg_match("/(youku.com|youtube.com|qq.com|ku6.com|sohu.com|sina.com.cn|tudou.com|yinyuetai.com)$/i", $parseLink['host'], $hosts)) {
			$flashinfo = $this->_video_getflashinfo($link, $hosts[1]);
		}
		if ($flashinfo['flash_url']) {
			$typedata['flashvar']  = $flashinfo['flash_url'];
			$typedata['flashimg']  = $flashinfo['image_url'];
			$typedata['host']      = $hosts[1];
			$typedata['source']    = $type_data;
			$typedata['title']     = $flashinfo['title'];
		}
		return $typedata;
	}

	//此代码需要持续更新.视频网站有变动.就得修改代码.
	public function _video_getflashinfo($link, $host) {
		$return='';
		if(extension_loaded("zlib")){
			$content = file_get_contents("compress.zlib://".$link);//获取
		}

		if(!$content)
		$content = file_get_contents($link);//有些站点无法获取

		if('youku.com' == $host)
		{
			// 2012/3/7 修复优酷链接图片的获取
			preg_match('/http:\/\/profile\.live\.com\/badge\/\?[^"]+/i', $content, $share_url);
			preg_match('/id\_(.+)\.html/', $share_url[0], $flashvar);
			preg_match('/screenshot=([^"&]+)/', $share_url[0], $img);
			preg_match('/title=([^"&]+)/', $share_url[0], $title);
			if (!empty($title[1])) {
				$title[1] = urldecode($title[1]);
			} else {
				preg_match("/<title>(.*?)<\/title>/i",$content,$title);
			}
			$img[1] = str_ireplace('ykimg.com/0', 'ykimg.com/1', $img[1]);
			$flash_url = 'http://player.youku.com/player.php/sid/'.$flashvar[1].'/v.swf';
		}
		elseif('ku6.com' == $host)
		{
			// 2012/3/7 修复ku6链接和图片抓去
			preg_match("/\/([\w\-\.]+)\.html/",$link,$flashvar);
			//preg_match("/<span class=\"s_pic\">(.*?)<\/span>/i",$content,$img);
			preg_match("/cover: \"(.+?)\"/i", $content, $img);
			preg_match("/<title>(.*?)<\/title>/i",$content,$title);
			$title[1] = iconv("GBK","UTF-8",$title[1]);
			$flash_url = 'http://player.ku6.com/refer/'.$flashvar[1].'/v.swf';
		}
		elseif('tudou.com' == $host && strpos($link,'www.tudou.com/albumplay')!==false) {
			preg_match("/albumplay\/([\w\-\.]+)\//",$link,$flashvar);
			preg_match("/<title>(.*?)<\/title>/i",$content,$title);
			preg_match("/pic: \"(.+?)\"/i", $content, $img);
			$title[1] = iconv("GBK","UTF-8",$title[1]);
			$flash_url = 'http://www.tudou.com/a/'.$flashvar[1].'/&autoPlay=true/v.swf';
		}
		elseif('tudou.com' == $host && strpos($link,'www.tudou.com/programs')!==false) {
			//dump(auto_charset($content,'GBK','UTF8'));
			preg_match("/programs\/view\/([\w\-\.]+)\//",$link,$flashvar);
			preg_match("/<title>(.*?)<\/title>/i",$content,$title);
			preg_match("/pic: \'(.+?)\'/i", $content, $img);
			$title[1] = iconv("GBK","UTF-8",$title[1]);
			$flash_url = 'http://www.tudou.com/v/'.$flashvar[1].'/&autoPlay=true/v.swf';
		}
		elseif('tudou.com' == $host && strpos($link,'www.tudou.com/listplay')!==false) {
			//dump(auto_charset($content,'GBK','UTF8'));
			preg_match("/listplay\/([\w\-\.]+)\//",$link,$flashvar);
			preg_match("/<title>(.*?)<\/title>/i",$content,$title);
			preg_match("/pic:\"(.+?)\"/i", $content, $img);
			$title[1] = iconv("GBK","UTF-8",$title[1]);
			$flash_url = 'http://www.tudou.com/l/'.$flashvar[1].'/&autoPlay=true/v.swf';
		}
		elseif('tudou.com' == $host && strpos($link,'douwan.tudou.com')!==false) {
			//dump(auto_charset($content,'GBK','UTF8'));
			preg_match("/code=([\w\-\.]+)$/",$link,$flashvar);
			preg_match("/title\":\"(.+?)\"/i",$content,$title);
			preg_match("/itempic\":\"(.+?)\"/i", $content, $img);
			$title[1] = iconv("GBK","UTF-8",$title[1]);
			$flash_url = 'http://www.tudou.com/v/'.$flashvar[1].'/&autoPlay=true/v.swf';
		}
		elseif('youtube.com' == $host) {
			preg_match('/http:\/\/www.youtube.com\/watch\?v=([^\/&]+)&?/i',$link,$flashvar);
			preg_match("/<link itemprop=\"thumbnailUrl\" href=\"(.+?)\">/i", $content, $img);
			preg_match("/<title>(.*?)<\/title>/", $content, $title);
			$flash_url = 'http://www.youtube.com/embed/'.$FLASHVAR[1];
		}
		elseif('sohu.com' == $host) {
			preg_match("/og:videosrc\" content=\"(.+?)\"/i", $content, $flashvar);
			preg_match("/og:title\" content=\"(.+?)\"/i", $content, $title);
			preg_match("/og:image\" content=\"(.+?)\"/i", $content, $img);
			$title[1] = iconv("GBK","UTF-8",$title[1]);
			$flash_url = $flashvar[1];
		}
		elseif('qq.com' == $host) {
			preg_match("/vid=([^\_]+)/", $link, $flashvar);
			if (empty($flashvar[1]))
			{
				  preg_match("/vid:\"(.+?)\",/i", $content, $flashvar);
			}
			preg_match('/http:\/\/vpic.video.qq.com\/(.+?)\/'.$flashvar[1].'_160_90_3.jpg/i',$content, $img);
			$img[1]="http://vpic.video.qq.com/".$img[1]."/".$flashvar[1]."_160_90_3.jpg";
			preg_match("/<title>(.*?)<\/title>/", $content, $title);
			$flash_url = 'http://static.video.qq.com/TPout.swf?vid='.$flashvar[1].'&auto=1';
		}
		elseif('sina.com.cn' == $host)
		{
			preg_match("/swfOutsideUrl:\'(.+?)\'/i", $content, $flashvar);
			preg_match("/pic\:[ ]*\'(.*?)\'/i",$content,$img);
			preg_match("/<title>(.*?)<\/title>/i",$content,$title);
			$flash_url = $flashvar[1];

		}
		elseif('yinyuetai.com' == $host)
		{
			preg_match("/video\/([\w\-]+)$/",$link,$flashvar);
			preg_match("/<meta property=\"og:image\" content=\"(.*)\"\/>/i",$content,$img);
			preg_match("/<meta property=\"og:title\" content=\"(.*)\"\/>/i",$content,$title);
			$flash_url = 'http://player.yinyuetai.com/video/player/'.$flashvar[1].'/v_0.swf';
			$base = base64_encode(file_get_contents($img[1]));
			$img[1] = 'data:image/jpeg;base64,'.$base;
		}

		$return['title'] = $title[1];
		$return['flash_url'] = $flash_url;
		$return['image_url'] =$img[1];
		return $return;
	}
}