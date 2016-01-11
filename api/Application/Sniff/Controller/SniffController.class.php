<?php
namespace Sniff\Controller;

use Common\Controller\BaseController;

class SniffController extends BaseController {

	public function sniff($id) {
		$url = D ( 'VideoVideo' )->getFieldById ( $id, 'video_url' );
		$data ['normal'] ['url'] = $url . "&format=super";
		$data ['normal'] ['type'] = 'm3u8';
		$data ['high'] ['url'] = $url . "&format=super";
		$data ['high'] ['type'] = 'm3u8';
		$data ['hd'] ['url'] = $url . "&format=super";
		$data ['hd'] ['type'] = 'm3u8';
		$data ['original'] ['url'] = $url . "&format=super";
		$data ['original'] ['type'] = 'm3u8';
		$this->ajaxReturn($data);
	}

	private function getUrl($link, $host) {
		if ('youku.com' == $host) {
			D ( 'NewYouku' )->parse ( "http://v.youku.com/v_show/id_XMTQwNzI0MjM0MA==.html" );
		} elseif ('qq.com' == $host) {
			return D ( 'HTencent' )->parse ( $link );
		}
	}
}
?>