<?php
namespace Collect\Controller;

use Common\Controller\BaseController;
use Org\Net\Http;
use Exception;

import ( 'Org.JAE.QueryList' );
class NewsController extends BaseController {

	public function index() {
		set_time_limit ( 0 );
		import ( 'Org.JAE.QueryList' );
		header ( "Content-type: text/html; charset=utf-8" );
		$listurl = "http://qt.qq.com/static/pages/news/phone/c12_list_1.shtml";
		$page=0;
		while ( true ) {
			if ($page>10) {
				break;
			}
			$pageresult = \QueryList::Query ( $listurl );
			$json = $pageresult->getHtmlJSON ();
			if (empty ( $json [0] ['next'] )) {
				echo $listurl;
				dump($json[0]);
				break;
			}
			$listurl = "http://qt.qq.com/static/pages/news/phone/" . $json [0] ['next'];
			
		
			$items = $json [0] ['list'];
			foreach ( $items as $item ) {
				$article_url = $item ['article_url'];
				if (strpos ( $article_url, 'qq.com' )) {
					continue;
				}
			 
				if (! strpos ( $article_url, "article_" )) {
					continue;
				}
				$article_url = "http://qt.qq.com/static/pages/news/phone/" . $article_url;
				$map['title']=$item['title'];
				$iscollect = D ( 'DcDocument' )->where ($map)->find ();
				if (!empty($iscollect)) {
					continue;
				}
				$data ['create_time'] = strtotime ( $item ['insert_date'] );
				$data ['title'] = $item ['title'];
				$data ['description'] = $item ['summary'];
				$data ['cover_id'] = $this->saveCoverImage ( $item ['image_url_small'] );
				if (empty ( $data ['cover_id'] )) {
					continue;
				}
				$Document = D ( 'DcDocument' );
				$data ['title'] = str_replace ( '掌盟', '群挑', $data ['title'] );
				$docid = $Document->addDoc ( $data );
				$pagecontent = \phpQuery::newDocumentFile ( $article_url );
				$content = pq ( ".article_content" )->html ();
				$imgs = pq ( $content )->find ( "img" );
				foreach ( $imgs as $img ) {
					$src = pq ( $img )->attr ( 'src' );
					if (empty($src))
					{
						$src= pq ( $img )->attr ( 'jason' );
					}
				 
					$imgurl = $this->saveArticleImage ( $src );
					$content = str_replace ( $src, $imgurl, $content );
					$content = str_replace ( "jason=","src=", $content );
					$content = str_replace ( "<img", "<img alt='".$item['title']."'", $content );
				}
				
				$content = str_replace ( '掌盟', '群挑', $content );
				$content = preg_replace ( "/<a[^>]*>(.*)<\/a>/isU", '${1}', $content );
				$Article = D ( 'DcArticle' );
				$article ['content'] = trim ( $content );
				$article ['id'] = $docid;
				$article_id = $Article->addArticle ( $article );
				\phpQuery::$documents=array();
				$page++;
			}
		}
	}

	public function saveArticleImage($url) {
		try {
			$config = C ( 'ARTICLE_PICTURE_UPLOAD' );
			$name = md5 ( $url ) . '.jpg';
			$path = $this->getName ( $config ['subName'], $name ) . '/';
			$this->_createFolder ( $config ['rootPath'] . $path );
			$savepath = "./" . $config ['rootPath'] . $path . $name;
			Http::curlDownload ( $url, $savepath );
			$info ['tmp_name'] = $savepath;
			$info ['savename'] = $name;
			$info ['name'] = $name;
			$info ['type'] = 'image/jpeg';
			$info ['size'] = 2048;
			$info ['md5'] = md5_file ( $savepath );
			$info ['ext'] = 'jpg';
			$info ['savepath'] = $path;
			$info ['path'] = $config ['rootPath'] . $path . $name;
			/* 调用文件上传组件上传文件 */
			$Picture = D ( 'DcPicture' );
			$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
			$return = $Picture->uploadOne ( $info, C ( 'ARTICLE_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
			return $return ['url'];
		} catch ( Exception $e ) {
			ob_end_flush ();
			echo $e->getMessage () . "<br/>";
			flush ();
			return;
		}
	}

	public function saveCoverImage($url) {
		try {
			$config = C ( 'ARTICLE_COVER_UPLOAD' );
			$name = md5 ( $url ) . '.jpg';
			$path = $this->getName ( $config ['subName'], $name ) . '/';
			$this->_createFolder ( $config ['rootPath'] . $path );
			$savepath = "./" . $config ['rootPath'] . $path . $name;
			Http::curlDownload ( $url, $savepath );
			$info ['tmp_name'] = $savepath;
			$info ['savename'] = $name;
			$info ['name'] = $name;
			$info ['type'] = 'image/jpeg';
			$info ['size'] = 2048;
			$info ['md5'] = md5_file ( $savepath );
			$info ['ext'] = 'jpg';
			$info ['savepath'] = $path;
			$info ['path'] = $config ['rootPath'] . $path . $name;
			/* 调用文件上传组件上传文件 */
			$Picture = D ( 'DcCover' );
			$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
			$return = $Picture->uploadOne ( $info, C ( 'ARTICLE_COVER_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
			return $return ['id'];
		} catch ( Exception $e ) {
			ob_end_flush ();
			echo $e->getMessage () . "<br/>";
			flush ();
			return;
		}
	}

	public function deleteLocal($file) {
		is_file ( $file ) ? unlink ( $file ) : false;
	}

	/**
	 * 根据指定的规则获取文件或目录名称
	 *
	 * @param array $rule
	 *        	规则
	 * @param string $filename
	 *        	原文件名
	 * @return string 文件或目录名称
	 */
	private function getName($rule, $filename) {
		$name = '';
		if (is_array ( $rule )) { // 数组规则
			$func = $rule [0];
			$param = ( array ) $rule [1];
			foreach ( $param as &$value ) {
				$value = str_replace ( '__FILE__', $filename, $value );
			}
			$name = call_user_func_array ( $func, $param );
		} elseif (is_string ( $rule )) { // 字符串规则
			if (function_exists ( $rule )) {
				$name = call_user_func ( $rule );
			} else {
				$name = $rule;
			}
		}
		return $name;
	}

	/**
	 * 创建多级文件目录
	 *
	 * @param string $path
	 *        	路径名称
	 * @return void
	 */
	private function _createFolder($path) {
		if (! is_dir ( $path )) {
			$this->_createFolder ( dirname ( $path ) );
			mkdir ( $path, 0777, true );
		}
	}

	/**
	 * 创建目录
	 *
	 * @param string $savepath
	 *        	要创建的穆里
	 * @return boolean 创建状态，true-成功，false-失败
	 */
	public function mkdir($savepath) {
		$dir = $this->rootPath . $savepath;
		if (is_dir ( $dir )) {
			return true;
		}
		if (mkdir ( $dir, 0777, true )) {
			return true;
		} else {
			$this->error = "目录 {$savepath} 创建失败！";
			echo "目录失败";
			return false;
		}
	}
}
?>