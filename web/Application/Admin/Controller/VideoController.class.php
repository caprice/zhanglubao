<?php
namespace Admin\Controller;

class  VideoController extends  AdminController
{

	public function  index()
	{

		$list   = $this->lists('Video');
		int_to_string($list);
		$this->assign('_list', $list);
		$this->meta_title = '视频信息';
		$this->display();
	}

	public function  getVideoInfo()
	{
		$return  = array('status' => 1, 'info' => '解析成功', 'data' => '');
		$url=I('post.link');
		$Video=D('Video');
		$videoInfo=$Video->getVideoInfo($url);
		if ($videoInfo)
		{
			$return=array_merge($videoInfo,$return);
			$this->ajaxReturn($return);
		}else
		{
			$return['info']='视频地址不对';
			$this->ajaxReturn($return);
		}

	}
	public function  add()
	{
		if (IS_POST)
		{
			$data['title']=I('post.title');
			$data['description']=I('post.description');
			$data['tags']=I('post.tags');
			$data['game_id']=I('post.game_id');
			$data['video_url']=I('post.video_url');
			$data['flash_url']=I('post.flash_url');
			$data['cover_url']=I('post.cover_url');
			$data['edit_status']=I('post.edit_status');
			$data['md5']=md5($data['video_url']);
			$Video=D('Video');
			if($Video->addVideo($data))
			{
				$this->success('新增成功！', U('index'));
			}else
			{
				$error = $Video->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '添加视频';
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->display('add');
		}
	}
	public function  edit($id = null)
	{
		if (IS_POST)
		{
				$Video = D('Video');
			if(false !== $Video->update()){
				$this->success('更新成功！', U('index'));
			} else {
				$error = $Team->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '编辑视频';
			empty($id) && $this->error('参数不能为空！');
			$video=D('Video')->field(true)->find($id);
			empty($video) && $this->error('参数错误！');
			$this->assign('video',$video);
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->display('edit');
		}
	}
	
	
	/**
	 *视频状态修改
	 */
	public function changeEditStatus($method=null){
		$id = array_unique((array)I('id',0));
		$id = is_array($id) ? implode(',',$id) : $id;
		if ( empty($id) ) {
			$this->error('请选择要操作的数据!');
		}
		$map['id'] =   array('in',$id);
		 $data    =  array('edit_status' => 0);
		switch ( strtolower($method) ){
			case 'recvideo':
				$data['edit_status']=1;
				break;
			case 'unrecvideo':
				$data['edit_status']=0;
				break;
			default:
				$this->error('参数非法');
		}
		
	 
		$where = array_merge( array('id' => array('in', $id )) ,(array)$where );
        $msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
        if( D('Video')->where($where)->save($data)!==false ) {
            $this->success($msg['success'],$msg['url'],$msg['ajax']);
        }else{
            $this->error($msg['error'],$msg['url'],$msg['ajax']);
        }
        
	}
	

	/**
	 *视频状态修改
	 */
	public function changeStatus($method=null){
		$id = array_unique((array)I('id',0));
		$id = is_array($id) ? implode(',',$id) : $id;
		if ( empty($id) ) {
			$this->error('请选择要操作的数据!');
		}
		$map['id'] =   array('in',$id);
		switch ( strtolower($method) ){
			case 'forbidvideo':
				$this->forbid('Video', $map );
				break;
			case 'resumevideo':
				$this->resume('Video', $map );
				break;
			case 'deletevideo':
				$this->delete('Video', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}
}