<?php
namespace Sniff\Controller;

use Common\Controller\BaseController;

class SaveController extends BaseController {

	public function sniff($id) {
		$url = D ( 'VideoVideo' )->getFieldById ( $id, 'video_url' );
		if ($url) {
			$video = $this->getUrl ( $url );
			return $this->ajaxReturn ( $video );
		}
	}

	private function getUrl($url) {
		return D ( 'Parse' )->parse ( $url );
	}
}
?>