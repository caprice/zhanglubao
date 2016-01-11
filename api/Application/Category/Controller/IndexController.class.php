<?php
namespace Category\Controller;

use Common\Controller\BaseController;

class IndexController extends BaseController {

	public function index() {
		$data = S ( 'category_index' );
		if (empty ( $data )) {
			$data ['teams'] = D ( 'UserUser' )->where ( 'group_id=6' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 12 )->select ();
			$data ['matches'] = D ( 'UserUser' )->where ( 'group_id=5' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 12 )->select ();
			$data ['pros'] = D ( 'UserUser' )->where ( 'group_id=2' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 12 )->select ();
			$data ['masters'] = D ( 'UserUser' )->where ( 'group_id=4' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 12 )->select ();
			$data ['comms'] = D ( 'UserUser' )->where ( 'group_id=3' )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( 12 )->select ();
			$data ['heros'] = D ( 'LolHero' )->field ( 'id,name,en_name,nick,avatar' )->order ( 'id desc' )->limit ( 12 )->select ();
			$data ['albums'] = D ( 'VideoAlbum' )->field ( 'id,album_name,picture_id' )->order ( 'album_weight desc' )->limit ( 9 )->select ();
			$data ['status'] = 1;
			S ( 'category_index', $data, 600 );
		}
		$this->ajaxReturn ( $data );
	}
}
?>