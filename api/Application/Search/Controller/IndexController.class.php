<?php
namespace Search\Controller;

use Common\Controller\BaseController;

class IndexController extends BaseController {

	public function index() {
		$map ['last_view'] = array (
				'gt',
				strtotime ( "-200 day" ) 
		);
		$data ['videos'] = D ( 'VideoVideo' )->field ( 'id,picture_id,video_title' )->where ( $map )->order ( 'week_views desc' )->limit ( 8 )->select ();
		 if (empty($data['videos'])) {
		 	$data ['videos']=array();
		 }
		$data ['users'] = D ( 'UserUser' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 12 )->select ();
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}
}
?>