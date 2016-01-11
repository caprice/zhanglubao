<?php
namespace Category\Controller;

use Common\Controller\BaseController;

class ListController extends BaseController {

	public function user($id = 0, $page = 0) {
		$start = $page * 40;
		$data ['status'] = 1;
		$data ['users'] = D ( 'UserUser' )->where ( 'group_id=' . $id )->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( $start . ",40" )->select ();
		$this->ajaxReturn($data);
	}
 
	public function album($page = 0) {
		$start = $page * 15;
		$data ['status'] = 1;
		$data ['albums'] = D ( 'VideoAlbum' )->field ( 'id,album_name,picture_id' )->order ( 'album_weight desc' )->limit ( $start . ",15" )->select ();
		$this->ajaxReturn ( $data );
	}
	
	public function  hero($page=0)
	{
		$start = $page * 40;
		$data ['status'] = 1;
		$data ['heros'] = D ( 'LolHero' )->field ( 'id,name,en_name,nick,avatar' )->order ( 'id desc' )->limit ( $start . ",40" )->select ();
		$this->ajaxReturn ( $data );
	}
	
	public function hotuser($page = 0)
	{
		$start = $page * 40;
		$data ['status'] = 1;
		$map['group_id']=array('in',array(2,4));
		$data ['users'] = D ( 'UserUser' )->where ( $map)->field ( 'uid,nickname,avatar_id' )->order ( 'user_weight desc' )->limit ( $start . ",40" )->select ();
		$this->ajaxReturn($data);
	}
}
?>