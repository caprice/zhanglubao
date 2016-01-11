<?php
namespace Sniff\Controller;

use Common\Controller\BaseController;
class DownloadController extends BaseController{
	
	public function download($id,$format="hd")
	{
		$url = D ( 'VideoVideo' )->getFieldById ( $id, 'iframe_url' );
		if ($url) {
			$parseLink = parse_url ( $url );
			if (preg_match ( "/(youku.com|youtube.com|qq.com|ku6.com|sohu.com|sina.com.cn|tudou.com|yinyuetai.com)$/i", $parseLink ['host'], $hosts )) {
				$video = $this->getUrl ( $url, $hosts [1] );
				$this->ajaxReturn ( $video );
			}
		}
	}
	private function getUrl($link, $host) {
		if ('youku.com' == $host) {
			return D ( 'HYouku' )->parse ( $link );
		} elseif ('qq.com' == $host) {
			return D ( 'HTencent' )->parse ( $link );
		}
	}
}
?>