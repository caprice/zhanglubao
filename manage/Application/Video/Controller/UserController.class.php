<?php

namespace Video\Controller;

use Common\Controller\BaseController;
class UserController extends BaseController{
	
	public function ajax()
	{
		$username=I('nickname');
		$map['nickname']=array('like','%'.$username.'%');
		$map['status']=1;
		$users=M('UserUser')->where($map)->limit(6)->select();
		 if (!empty($users)) {
		 	$data['users']=$users;
		 	$data['status']=1;
		 }else 
		 {
		 	$data['users']=array();
		 	$data['status']=0;
		 }
		 
		$this->ajaxReturn($data);
		
	}
}

?>