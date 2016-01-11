<?php
namespace Admin\Controller;

class  CommentatorController extends  AdminController
{
	public function index()
	{
		$list   = $this->lists('Commentator');
		int_to_string($list);
		$this->assign('_list', $list);

		$this->meta_title = '解说 信息';
		$this->display();
	}
	public function  add()
	{
		if(IS_POST)
		{
			$Commentator = D('Commentator');
			if(false !== $Commentator->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Commentator->getError();
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
			$Commentator = D('Commentator');
			if(false !== $Commentator->update()){
				$this->success('更新成功！', U('index'));
			} else {
				$error = $Commentator->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else {
			empty($id) && $this->error('参数不能为空！');
			$this->meta_title = '编辑战队';
			$commentator=D('Commentator')->field(true)->find($id);
			empty($commentator) && $this->error('参数错误！');
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->assign('commentator',$commentator);
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
			case 'forbidcommentator':
				$this->forbid('Commentator', $map );
				break;
			case 'resumecommentator':
				$this->resume('Commentator', $map );
				break;
			case 'deletecommentator':
				$this->delete('Commentator', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}
}