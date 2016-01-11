<?php

namespace Web\Controller;

use Common\Controller\BaseController;


class FriendLinkController extends BaseController{
	
	public function index() {
		$name = I ( 'name' );
		$map ['status'] = array (
				'egt',
				0
		);
		if (!empty($name)) {
				$map ['name'] = array (
				'like',
				'%' . ( string ) $name . '%'
		);
		}
	
		$list = $this->lists ( 'WebFriendlink', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	
	public function add() {
	 if(IS_POST){
            $FrindLink = D('WebFriendlink');
            $data = $FrindLink->create();
            if($data){
                if($FrindLink->add()){
                	S ( 'h_i_friendlinks',null );
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($FrindLink->getError());
            }
        } else {
        	
            $this->assign('info',null);
            $this->display('edit');
        }
	}
	
	
	
	public function edit($id = null) {
	 if(IS_POST){
            $FrindLink = D('WebFriendlink');
            $data = $FrindLink->create();
            if($data){
                if($FrindLink->save()){
                	S ( 'h_i_friendlinks',null );
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($FrindLink->getError());
            }
        } else {
            $info = array();
            $info = M('WebFriendlink')->field(true)->find($id);

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
				$this->forbid ( 'WebFriendlink', $map );
				break;
			case 'resume' :
				$this->resume ( 'WebFriendlink', $map );
				break;
			case 'delete' :
				M('WebFriendlink')->where($map)->delete();
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}

?>