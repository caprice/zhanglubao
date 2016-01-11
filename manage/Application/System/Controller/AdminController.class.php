<?php

namespace System\Controller;

use Common\Controller\BaseController;
class AdminController extends BaseController {
	
	public function index() {
		$username       =   I('username');
		$map['status']  =   array('egt',0);
		if(is_numeric($username)){
			$map['id|username']=   array(intval($username),array('like','%'.$username.'%'),'_multi'=>true);
		}else{
			$map['username']    =   array('like', '%'.(string)$username.'%');
		}
		
		
		$list = $this->lists ( 'AdminAdmin', $map);
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	 
	public function add() {
		if (IS_POST) {
			$data ['username'] = I ( 'username' );
			$data ['email'] = I ( 'email' );
			$data ['password'] = I ( 'password' );
			$data ['avatar_id'] = I ( 'avatar_id' );
			$Admin = D ( 'AdminAdmin' );
			if (false !== $Admin->addAdmin ( $data )) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Admin->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$countries = $this->getcountries ();
			$this->assign ( 'countries', $countries );
			$this->display ();
		}
	}
	public function edit($id = null) {
		if (IS_POST) {
			$data['id']=I('id');
 			$data ['password'] = I ( 'password' );
			$data ['avatar_id'] = I ( 'avatar_id' );
			$Admin = D ( 'AdminAdmin' );
			if (false !== $Admin->editAdmin ( $data )) {
				 $this->success ( '更新成功！', U ( 'index' ) );
			} else {
				$error = $Admin->getError ();
				 $this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			if (! $id) {
				$this->error ( '参数错误' );
			}
			$user=D('AdminAdmin')->find($id);
			$this->assign('user',$user);
			$countries = $this->getcountries ();
			$this->assign ( 'countries', $countries );
			$this->display ();
		}
	}
	 
	public function changeStatus($method = null) {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
		if (in_array ( C ( 'USER_ADMINISTRATOR' ), $id )) {
			$this->error ( "不允许对超级管理员执行该操作!" );
		}
		$id = is_array ( $id ) ? implode ( ',', $id ) : $id;
		if (empty ( $id )) {
			$this->error ( '请选择要操作的数据!' );
		}
		$map ['id'] = array (
				'in',
				$id 
		);
		
		switch (strtolower ( $method )) {
			case 'forbid' :
				$this->forbid ( 'AdminAdmin', $map );
				break;
			case 'resume' :
				$this->resume ( 'AdminAdmin', $map );
				break;
			case 'delete' :
				$this->delete ( 'AdminAdmin', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}

?>