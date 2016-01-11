<?php

namespace User\Controller;

use Common\Controller\BaseController;
class UserVerifyController extends BaseController {
	public function index() {
		
		$nickname       =   I('nickname');
		$map['status']  =   array('egt',0);
		$map['user_verify']  =  1;
		if(is_numeric($nickname)){
			$map['uid|nickname']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
		}else{
			$map['nickname']    =   array('like', '%'.(string)$nickname.'%');
		}
		
		
		$list = $this->lists ( 'UserUser', $map);
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
}

?>