<?php

namespace User\Controller;

use Common\Controller\BaseController;

class UserController extends BaseController {
	public function index() {
		
		$nickname       =   I('nickname');
		$map['status']  =   array('egt',0);
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
	
	 
	public function add() {
		if (IS_POST) {
			$data ['nickname'] = I ( 'nickname' );
			$data ['user_verify'] = I ( 'user_verify' );
			$data ['verify_content'] = I ( 'verify_content' );
			$data ['avatar_id'] = I ( 'avatar_id' );
			$data['group_id']=I('group_id');
			$data['user_weight']=I('user_weight');
			$User = D ( 'UserUser' );
			if (false !== $User->addUser ( $data )) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $User->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$groups=$this->getUserGroups();
			$this->assign('groups',$groups);
			$countries = $this->getcountries ();
			$this->assign ( 'countries', $countries );
			$this->display ();
		}
	}
	public function edit($uid = null) {
		if (IS_POST) {
			$data['uid']=I('uid');
			$data ['nickname'] = I ( 'nickname' );
			$data ['user_verify'] = I ( 'user_verify' );
			$data ['verify_content'] = I ( 'verify_content' );
			$data ['avatar_id'] = I ( 'avatar_id' );
			$data['group_id']=I('group_id');
			$data['user_weight']=I('user_weight');
			$User = D ( 'UserUser' );
			if (false !== $User->editUser ( $data )) {
				$this->success ( '更新成功！', U ( 'index' ) );
			} else {
				$error = $User->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			if (! $uid) {
				$this->error ( '参数错误' );
			}
			$user=D('UserUser')->find($uid);
			$this->assign('user',$user);
			$countries = $this->getcountries ();
			$this->assign ( 'countries', $countries );
			
			$groups=$this->getUserGroups();
			$this->assign('groups',$groups);
			$this->display ();
		}
	}
	
	/**
	 * 会员状态修改
	 * 
	 * @author rocks
	 */
	public function changeStatus($method = null) {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
		if (in_array ( C ( 'USER_ADMINISTRATOR' ), $id )) {
			$this->error ( "不允许对超级管理员执行该操作!" );
		}
		$id = is_array ( $id ) ? implode ( ',', $id ) : $id;
		if (empty ( $id )) {
			$this->error ( '请选择要操作的数据!' );
		}
		$map ['uid'] = array (
				'in',
				$id 
		);
		
		switch (strtolower ( $method )) {
			case 'forbiduser' :
				$this->forbid ( 'UserUser', $map );
				break;
			case 'resumeuser' :
				$this->resume ( 'UserUser', $map );
				break;
			case 'deleteuser' :
				$this->delete ( 'UserUser', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
	
	
	public function ajax()
	{
		$nickname=I('nickname');
		$map['nickname']=   array('like','%'.$nickname.'%');
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