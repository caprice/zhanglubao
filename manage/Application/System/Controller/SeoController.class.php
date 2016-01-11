<?php
 
namespace System\Controller;
 
use Common\Controller\BaseController;
class SEOController extends BaseController
{
	public function index() {
		$title       =   I('title');
		$map['status']  =   array('egt',0);
		$title = I ( 'title' );
		if (!empty($title)) {
			$map['title']    =   array('like', '%'.(string)title.'%');
		}
	
		$list = $this->lists ( 'SeoRule', $map);
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	
	public function add() {
		if(IS_POST){
			$SeoRule = D('SeoRule');
			$data = $SeoRule->create();
			if($data){
				if($SeoRule->add()){
					$this->success('新增成功', U('index'));
				} else {
					$this->error('新增失败');
				}
			} else {
				$this->error($SeoRule->getError());
			}
		} else {
			 
			$this->assign('info',null);
			$this->display('edit');
		}
	}
	
	
	
	public function edit($id = null) {
		if(IS_POST){
			$SeoRule = D('SeoRule');
			$data = $SeoRule->create();
			if($data){
				if($SeoRule->save()){
					$cacheKey = "qt_seo_meta_".$data['app']."_".$data['controller']."_".$data['action'];
					 S ( $cacheKey,null);
					 
					 
					$this->success('更新成功', Cookie('__forward__'));
				} else {
					$this->error('更新失败');
				}
			} else {
				$this->error($SeoRule->getError());
			}
		} else {
			$info = array();
			$info = M('SeoRule')->field(true)->find($id);
	
			if(false === $info){
				$this->error('获取配置信息错误');
			}
			$this->assign('info', $info);
			$this->display();
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
				$this->forbid ( 'SeoRule', $map );
				break;
			case 'resume' :
				$this->resume ( 'SeoRule', $map );
				break;
			case 'delete' :
				$this->delete('SeoRule', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}