<?php
namespace Article\Controller;
 
use Common\Controller\BaseController;
class DcCategoryController extends BaseController {

public function index() {
		$username = I ( 'name' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$map ['name'] = array (
				'like',
				'%' . ( string ) $username . '%' 
		);
		$list = $this->lists ( 'DcCategory', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
	
		$this->display ();
	}
	
	public function add() {
		if (IS_POST) {
			$data ['name'] = I ( 'name' );
			$Category = D ( 'DcCategory' );
			if (false !== $Category->addCategory ( $data )) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Category->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$this->display ();
		}
	}
	
	public function edit($id = null) {
		if (IS_POST) {
			$data ['id'] = I ( 'id' );
			$data ['name'] = I ( 'name' );
			$Category = D ( 'DcCategory' );
			if (false !== $Category->editCategory ( $data )) {
				$this->success ( '更新成功！', U ( 'index' ) );
			} else {
				$error = $Category->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			if (! $id) {
				$this->error ( '参数错误' );
			}
			$category = D ( 'DcCategory' )->find ( $id );
			$this->assign ( 'category', $category );
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
				$this->forbid ( 'DcCategory', $map );
				break;
			case 'resume' :
				$this->resume ( 'DcCategory', $map );
				break;
			case 'delete' :
				$this->delete ( 'DcCategory', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}
