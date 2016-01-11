<?php

namespace Recommend\Controller;

use Common\Controller\BaseController;

class RecommendPlaceController extends BaseController {
	public function index() {
		$title = I ( 'place_title' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$title = I ( 'place_title' );
		if (! empty ( $title )) {
			$map ['place_title'] = array (
					'like',
					'%' . ( string ) title . '%' 
			);
		}
		
		$list = $this->lists ( 'RecommendPlace', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	
	public function recommends($place_id = null) {
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
		$map ['place_id'] = $place_id;
		$list = $this->lists ( 'RecommendContent', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->assign('place_id',$place_id);
		$this->display ();
	}
	
	
	public function addContent($place_id = null) {
		if (IS_POST) {
			$Content = D ( 'RecommendContent' );
			$data = $Content->create ();
			if ($data) {
				
				if ($Content->add ()) {
					
					$this->success ( '新增成功', U ( 'Recommend/RecommendPlace/recommends/place_id/'.$place_id ) );
				} else {
					
					$this->error ( '新增失败' );
				}
			} else {
				$this->error ( $Content->getError () );
			}
		} else {
			$this->assign('place_id',$place_id);
			$this->assign ( 'info', null );
			$this->display (  );
		}
	}
	
	
	
	public function add() {
		if (IS_POST) {
			$Place = D ( 'RecommendPlace' );
			$data = $Place->create ();
			if ($data) {
				if ($Place->add ()) {
					$this->success ( '新增成功', U ( 'index' ) );
				} else {
					$this->error ( '新增失败' );
				}
			} else {
				$this->error ( $Place->getError () );
			}
		} else {
			
			$this->assign ( 'info', null );
			$this->display ( 'edit' );
		}
	}
	public function edit($id = null) {
		if (IS_POST) {
			$Place = D ( 'RecommendPlace' );
			$data = $Place->create ();
			if ($data) {
				if ($Place->save ()) {
					$this->success ( '更新成功', Cookie ( '__forward__' ) );
				} else {
					$this->error ( '更新失败' );
				}
			} else {
				$this->error ( $Place->getError () );
			}
		} else {
			$info = array ();
			$info = M ( 'RecommendPlace' )->field ( true )->find ( $id );
			
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
				$this->forbid ( 'RecommendPlace', $map );
				break;
			case 'resume' :
				$this->resume ( 'RecommendPlace', $map );
				break;
			case 'delete' :
				$this->delete ( 'RecommendPlace', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}

?>