<?php
namespace Admin\Controller;

use Org\Util\Date;

class  AdController extends  AdminController
{
	public function  index()
	{
		$list   = $this->lists('Ad');
		int_to_string($list);
		$this->assign('_list', $list);
		$this->meta_title = '广告';
		$this->display();
	}

	public function  add()
	{

		if (IS_POST)
		{
			$Ad = D('Ad');
			if(false !== $Ad->update()){
				$this->success('新增成功！',  U('index?matchid='.I('match_id')));
			} else {
				$error = $Ad->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '添加广告';
			$this->display('edit');
		}

	}
	public function  edit($id=null)
	{
		if (IS_POST)
		{
			$Ad = D('Ad');
			if(false !== $Ad->update()){
				$this->success('新增成功！',  U('index?matchid='.I('match_id')));
			} else {
				$error = $Ad->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$ad=D('Ad')->field(true)->find($id);
			$this->assign('ad',$ad);
			$this->meta_title = '编辑广告';
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
			case 'forbidad':
				$this->forbid('Ad', $map );
				break;
			case 'resumead':
				$this->resume('Ad', $map );
				break;
			case 'deletead':
				$this->delete('Ad', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}
}