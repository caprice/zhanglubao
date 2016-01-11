<?php
namespace Admin\Controller;

class  MasterController extends  AdminController
{
	public function index()
	{
		$list   = $this->lists('Master');
		int_to_string($list);
		$this->assign('_list', $list);

		$this->meta_title = '解说 信息';
		$this->display();
	}
	public function  add()
	{
		if(IS_POST)
		{
			$Master = D('Master');
			if(false !== $Master->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Master->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->meta_title = '添加战队';
			$this->display('edit');
		}
	}

 

	public function  edit($id = null)
	{
		if(IS_POST){
			$Master = D('Master');
			if(false !== $Master->update()){
				$this->success('更新成功！', U('index'));
			} else {
				$error = $Master->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else {
			empty($id) && $this->error('参数不能为空！');
			$this->meta_title = '编辑战队';
			$master=D('Master')->field(true)->find($id);
			empty($master) && $this->error('参数错误！');
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->assign('master',$master);
			$this->display('edit');
		}
	}

	/**
	 * 团队状态修改
	 */
	public function changeStatus($method=null){
		$id = array_unique((array)I('id',0));
		$id = is_array($id) ? implode(',',$id) : $id;
		if ( empty($id) ) {
			$this->error('请选择要操作的数据!');
		}
		$map['id'] =   array('in',$id);
		switch ( strtolower($method) ){
			case 'forbidmater':
				$this->forbid('Master', $map );
				break;
			case 'resumemater':
				$this->resume('Master', $map );
				break;
			case 'deletemater':
				$this->delete('Master', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}
}