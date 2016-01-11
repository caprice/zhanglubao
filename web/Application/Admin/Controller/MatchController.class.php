<?php
namespace Admin\Controller;

use Org\Util\Date;

class  MatchController extends  AdminController
{

	public function index()
	{
		$list   = $this->lists('Match');
		int_to_string($list);
		$this->assign('_list', $list);
		$this->meta_title = '比赛信息';
		$this->display();
	}
	public function  add($seriesid = null)
	{
		if(IS_POST)
		{
			$Match = D('Match');
			if(false !== $Match->update()){
				$seriesid=I('post.series_id');
				
				$SeriesModel=D('Series');
				$SeriesModel->where('id='.$seriesid)->setInc('match_count',1); 
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Match->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->assign('seriesid',$seriesid);
			$this->meta_title = '添加比赛';
			$this->display('add');
		}
	}
	
	
	public function edit($id = null)
	{
		if(IS_POST){
			$Match = D('Match');
			if(false !== $Match->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Match->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else {
			empty($id) && $this->error('参数不能为空！');
			$this->meta_title = '编辑战队';
			$macth=D('Match')->field(true)->find($id);
			empty($macth) && $this->error('参数错误！');
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->assign('match',$macth);
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
			case 'forbidmatch':
				$this->forbid('Match', $map );
				break;
			case 'resumematch':
				$this->resume('Match', $map );
				break;
			case 'deletematch':
				$this->delete('Match', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}
	
	public function  addVideo($matchid=null)
	{
		if(IS_POST)
		{
			$data['video_id']=I('post.video_id');
			$data['match_id']=I('post.match_id');
			$MatchVideo=D('MatchVideo');
			$MatchVideo->add($data);
			$this->success('新增成功！',  U('addVideo?matchid='.$matchid));
		}else
		{
			$match=D('Match')->field(true)->find($matchid);
			$this->assign('match',$match);
			$this->display();
		}
	}

}