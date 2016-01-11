<?php
namespace Top\Controller;

use Common\Controller\BaseController;

class ListController extends BaseController {

	 

	public function day($page = 0) {
		$start = $page * 16;
		$map ['last_view'] = array (
				'gt',
				strtotime ( "-4 day" ) 
		);
		$data ['videos'] = D ( 'VideoVideo' )->field ( 'id,picture_id,video_title' )->where ( $map )->order ( 'day_views desc' )->limit ( $start . ",16" )->select ();
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}

	public function week($page = 0) {
		$start = $page * 16;
		$map ['last_view'] = array (
				'gt',
				strtotime ( "-14 day" ) 
		);
		$data ['videos'] = D ( 'VideoVideo' )->field ( 'id,picture_id,video_title' )->where ( $map )->order ( 'week_views desc' )->limit ( $start . ",16" )->select ();
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}

	public function month($page = 0) {
		$start = $page * 16;
		$map ['last_view'] = array (
				'gt',
				strtotime ( "-30 day" ) 
		);
		$data ['videos'] = D ( 'VideoVideo' )->field ( 'id,picture_id,video_title' )->where ( $map )->order ( 'month_views desc' )->limit ( $start . ",16" )->select ();
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}

	public function all($page = 0) {
		$start = $page * 16;
		$data ['videos'] = D ( 'VideoVideo' )->field ( 'id,picture_id,video_title' )->order ( 'total_views desc' )->limit ( $start . ",16" )->select ();
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}
}
?>