<?php
namespace Admin\Controller;

class  VideoAlbumController extends  AdminController
{
	public function  index()
	{
		$list   = $this->lists('VideoAlbum');
		int_to_string($list);
		$this->assign('_list', $list);

		$this->meta_title = '战队信息';
		$this->display();
		$this->meta_title = '视频专辑';
		$this->display();
	}

	public function add()
	{
		if(IS_POST)
		{
			$VideoAlbum = D('VideoAlbum');
			if(false !== $VideoAlbum->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $VideoAlbum->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '添加专辑';
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->display('edit');
		}
	}
	public function edit($id = null)
	{
		if(IS_POST)
		{
			$VideoAlbum = D('VideoAlbum');
			if(false !== $VideoAlbum->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $VideoAlbum->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '编辑专辑';
			empty($id) && $this->error('参数不能为空！');
			$album=D('VideoAlbum')->field(true)->find($id);
			empty($album) && $this->error('参数错误！');
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->assign('album',$album);
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
			case 'forbidvideoalbum':
				$this->forbid('VideoAlbum', $map );
				break;
			case 'resumevideoalbum':
				$this->resume('VideoAlbum', $map );
				break;
			case 'deletevideoalbum':
				$this->delete('VideoAlbum', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}
}