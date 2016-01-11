<?php

namespace System\Controller;

use Common\Controller\BaseController;

class CountryController extends BaseController {
	public function index() {
		$username = I ( 'country_name' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$map ['country_name'] = array (
				'like',
				'%' . ( string ) $username . '%' 
		);
		$list = $this->lists ( 'SystemCountry', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	
	public function add() {
		if (IS_POST) {
			$data ['country_name'] = I ( 'country_name' );
			
			$Country = D ( 'SystemCountry' );
			if (false !== $Country->addCountry ( $data )) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Country->getError ();
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
			$data ['country_name'] = I ( 'country_name' );
			$Country = D ( 'SystemCountry' );
			if (false !== $Country->editCountry ( $data )) {
				$this->success ( '更新成功！', U ( 'index' ) );
			} else {
				$error = $Country->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			if (! $id) {
				$this->error ( '参数错误' );
			}
			$country = D ( 'SystemCountry' )->find ( $id );
			$this->assign ( 'country', $country );
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
				$this->forbid ( 'SystemCountry', $map );
				break;
			case 'resume' :
				$this->resume ( 'SystemCountry', $map );
				break;
			case 'delete' :
				$this->delete ( 'SystemCountry', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}

?>