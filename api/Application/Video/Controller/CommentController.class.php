<?php
namespace Video\Controller;

use Common\Controller\BaseController;

class CommentController extends BaseController {

	public function comments($id, $page) {
		$data ['comments'] = D ( 'VideoComment' )->getCommentList ( $id, $page );
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}

	public function add() {
		$data ['status'] = 0;
		if (is_login ()) {
			$videoid = I ( 'videoid' );
			$content = I ( 'content' );
			$uid = is_login ();
			$commentid = D ( 'VideoComment' )->addComment ( $uid, $videoid, $content );
			if ($commentid > 0) {
				$data ['status'] = 1;
			}
			S ( 'video_detail_' . $videoid,null );
		}
		$this->ajaxReturn ( $data );
	}
}
?>