<?php
namespace User\Controller;

use Common\Controller\BaseController;

class SubscribeController extends BaseController {

	public function subscribes($page = 0) {
		if (is_login) {
			$followList = D ( 'UserFollow' )->getFollowList ();
			$map ['uid'] = array (
					'in',
					$followList 
			);
			$start = $page * 16;
			$data ['videos'] = D ( 'VideoVideo' )->field ( 'id,picture_id,video_title' )->order ( 'id desc' )->where ( $map )->limit ( $start . ",16" )->select ();
			if (empty ( $data ['videos'] )) {
				$data ['videos'] = array ();
			}
			$data ['status'] = 1;
			$this->ajaxReturn ( $data );
		} else {
			$data ['status'] = 0;
			$this->ajaxReturn ( $data );
		}
	}

	public function follow($uid) {
		if (is_login && ! empty ( $uid )) {
			D ( 'UserFollow' )->follow ( $uid );
			$data ['status'] = 1;
			$this->ajaxReturn ( $data );
		} else {
			$data ['status'] = 0;
			$this->ajaxReturn ( $data );
		}
	}

	public function unfollow($uid) {
		if (is_login && ! empty ( $uid )) {
			D ( 'UserFollow' )->unfollow ( $uid );
			$data ['status'] = 1;
			$this->ajaxReturn ( $data );
		} else {
			$data ['status'] = 0;
			$this->ajaxReturn ( $data );
		}
	}

	public function isfollow($uid) {
		if (is_login && ! empty ( $uid )) {
			$count = D ( 'UserFollow' )->isFollow ( is_login (), $uid );
			if ($count > 0) {
				$data ['isfollow'] = 1;
				$data ['status'] = 1;
			}
			$this->ajaxReturn ( $data );
		} else {
			$data ['status'] = 0;
			$this->ajaxReturn ( $data );
		}
	}
}
?>