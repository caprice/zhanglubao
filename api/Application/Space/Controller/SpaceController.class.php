<?php

namespace Space\Controller;

class SpaceController extends BaseSpaceController {
	
	public function index($uid) {
		if (empty($uid)) {
			$this->redirect('http://www.zhanglubao.com');
		}
		$user = D ( 'UserUser' )->getUserInfo ( $uid );
		$map['uid']=$uid;
		$list=$this->listuservs(D('VideoUser'),$map);
		$this->assign ( '_list', $list );
		$this->assign ( 'user', $user );
		$this->display ();
	}
	
	
	
	public function album($uid)
	{
		$user = D ( 'UserUser' )->getUserInfo ( $uid );
		$this->assign ( 'user', $user );
		$map['uid']=$uid;
		$list = $this->listalbums(D('VideoAlbum'),$map);
		$this->assign ( '_list', $list );
		$this->display ();
	}
}

?>