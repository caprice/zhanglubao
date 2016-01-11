<?php
namespace Video\Controller;

use Common\Controller\BaseController;

class VideoController extends BaseController {

	public function detail($id = null) {
		D ( 'VideoVideo' )->updateHit ( $id );
		$data = S ( 'video_detail_' . $id );
		if (empty ( $data )) {
			$data ['video'] = D ( 'VideoVideo' )->field ( 'id,uid,video_title,picture_id,comment_count' )->find ( $id );
			$data ['relates'] = D ( 'VideoVideo' )->getRelate ( $data ['video'] ['id'], $data ['video'] ['uid'] );
			$data ['comments'] = D ( 'VideoComment' )->getCommentList ( $id, 0 );
			$data ['status'] = 1;
			S ( 'video_detail_' . $id, $data, 600 );
		}
		$this->ajaxReturn ( $data );
	}
}
?>