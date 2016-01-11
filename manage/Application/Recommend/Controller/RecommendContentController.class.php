<?php

namespace Recommend\Controller;

use Common\Controller\BaseController;
class RecommendContentController extends BaseController{
	
	
	public function index() {
		$title = I ( 'rec_title' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$title = I ( 'rec_title' );
		if (! empty ( $title )) {
			$map ['rec_title'] = array (
					'like',
					'%' . ( string ) title . '%' 
			);
		}
		$list = $this->lists ( 'RecommendContent', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
 
	
	
	public function edit($id = null) {
		if (IS_POST) {
			$Content = D ( 'RecommendContent' );
			$data = $Content->create ();
			if ($data) {
				if ($Content->save ()) {
					$this->success ( '更新成功', Cookie ( '__forward__' ) );
				} else {
					$this->error ( '更新失败' );
				}
			} else {
				$this->error ( $Content->getError () );
			}
		} else {
			$info = array ();
			$info = M ( 'RecommendContent' )->field ( true )->find ( $id );
				
			if (false === $info) {
				$this->error ( '获取配置信息错误' );
			}
			$this->assign ( 'info', $info );
			$this->display ();
		}
	}
	
	
	
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
				$this->forbid ( 'RecommendContent', $map );
				break;
			case 'resume' :
				$this->resume ( 'RecommendContent', $map );
				break;
			case 'delete' :
				$this->delete ( 'RecommendContent', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}

?>