<?php
namespace Home\Controller;

use Common\Controller\BaseController;

class IndexController extends BaseController {

	public function index() {
		$data = S ( 'home_index' );
		if (empty ( $data )) {
			$data = array ();
			$data ['slides'] = D ( 'AppSlide' )->cache ( 60 )->field ( 'id,title,type,cover_id,value_id,url' )->order ( 'id desc' )->limit ( 6 )->select ();
			$lasts = M ( 'VideoVideo' )->field ( 'id' )->cache ( 60 )->order ( 'id desc' )->limit ( '10,1' )->select ();
			$data ['hotvideos'] = D ( 'VideoVideo' )->cache ( 60 )->field ( 'id,picture_id,video_title' )->order ( 'total_views desc' )->where ( 'id>' . $lasts [count ( $lasts ) - 1] ['id'] )->limit ( 6 )->select ();
			$data ['commvideos'] = D ( 'VideoVideo' )->cache ( 60 )->where ( 'category_id=2' )->field ( 'id,picture_id,video_title' )->order ( 'id desc' )->limit ( 6 )->select ();
			$data ['commusers'] = D ( 'UserUser' )->cache ( 60 )->where ( 'group_id=3' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 8 )->select ();
			$data ['albumvideos'] = D ( 'VideoVideo' )->cache ( 60 )->where ( 'category_id=4' )->field ( 'id,picture_id,video_title' )->order ( 'id desc' )->limit ( 6 )->select ();
			$data ['videoalbums'] = D ( 'VideoAlbum' )->cache ( 60 )->field ( 'id,album_name,picture_id' )->order ( 'album_weight desc' )->limit ( 6 )->select ();
			$data ['mastervideos'] = D ( 'VideoVideo' )->cache ( 60 )->where ( 'category_id=1' )->field ( 'id,picture_id,video_title' )->order ( 'id desc' )->limit ( 6 )->select ();
			$data ['masterusers'] = D ( 'UserUser' )->cache ( 60 )->where ( 'group_id=2 or group_id=4' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 8 )->select ();
			$data ['matchvideos'] = D ( 'VideoVideo' )->cache ( 60 )->where ( 'category_id=3' )->field ( 'id,picture_id,video_title' )->order ( 'id desc' )->limit ( 6 )->select ();
			$data ['matchusers'] = D ( 'UserUser' )->cache ( 60 )->where ( 'group_id=5' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 8 )->select ();
			$data ['othervideos'] = D ( 'VideoVideo' )->cache ( 60 )->where ( 'category_id>4' )->field ( 'id,picture_id,video_title' )->order ( 'id desc' )->limit ( 6 )->select ();
			$data ['status'] = 1;
			S ( 'home_index', $data, 100 );
		}
		$this->ajaxReturn ( $data );
	}

	public function more($page) {
		$data ['videos'] = D ( 'VideoVideo' )->field ( 'id,uid,picture_id,video_title' )->order ()->limit ( 20 * page, 20 )->select ();
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}

	public function comm($page) {
		$map ['category_id'] = $data ['videos'] = D ( 'VideoVideo' )->field ( 'id,uid,picture_id,video_title' )->order ()->limit ( 20 * page, 20 )->select ();
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}
}