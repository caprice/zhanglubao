<?php

namespace User\Controller;

use Common\Controller\BaseController;

class UserGroupController extends BaseController {
	public function index() {
		$username = I ( 'group_name' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$map ['group_name'] = array (
				'like',
				'%' . ( string ) $username . '%' 
		);
		$list = $this->lists ( 'UserGroup', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	
	public function add() {
		if (IS_POST) {
			$data ['group_name'] = I ( 'group_name' );
			
			$Group = D ( 'UserGroup' );
			if (false !== $Group->addGroup ( $data )) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Group->getError ();
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
			$data ['id'] = I ( 'id' );
			$data ['group_name'] = I ( 'group_name' );
			$Group = D ( 'UserGroup' );
			if (false !== $Group->editGroup ( $data )) {
				$this->success ( '更新成功！', U ( 'index' ) );
			} else {
				$error = $Group->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			if (! $id) {
				$this->error ( '参数错误' );
			}
			$group = D ( 'UserGroup' )->find ( $id );
			$this->assign ( 'group', $group );
			$this->display ();
		}
	}
	
	
	/**
	 * 会员状态修改
	 */
	public function changeStatus($method = null) {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
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
				$this->forbid ( 'UserGroup', $map );
				break;
			case 'resume' :
				$this->resume ( 'UserGroup', $map );
				break;
			case 'delete' :
				$this->delete ( 'UserGroup', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}

?>