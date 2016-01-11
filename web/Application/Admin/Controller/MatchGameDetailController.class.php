<?php
namespace Admin\Controller;

use Org\Util\Date;

class  MatchGameDetailController extends  AdminController
{
	public function  index()
	{
		$matchgameid=I('matchgameid');
		empty($matchgameid) && $this->error('参数错误！');
		$map['match_game_id']=$matchgameid;
		$list   = $this->lists('MatchGameDetail',$map);
		int_to_string($list);
		$this->assign('_list', $list);
		$this->meta_title = '比赛场次';
		$this->assign('matchgameid',$matchgameid);
		$this->display();
	}

	public function  add($matchgameid=null)
	{

		if (IS_POST)
		{
			$MatchGameDetail = D('MatchGameDetail');
			if(false !== $MatchGameDetail->update()){
				$data['video_id']=I('post.video_id');
				$data['match_id']=I('post.match_id');
				$data['match_game_id']=intval(I('post.match_game_id'));
				
				$MatchGameVideo=D('MatchGameVideo');
				$MatchGameVideo->add($data);

				unset($data['match_game_id']);
				$MatchVideo=D('MatchVideo');
				$MatchVideo->add($data);
				
				$data['team_id']=I('post.blue_team_id');
				unset($data['match_id']);
				$BlueTeamVideo=D('TeamVideo');
				$BlueTeamVideo->add($data);
				
				$data['team_id']=I('post.red_team_id');
				$RedTeamVideo=D('TeamVideo');
				$RedTeamVideo->add($data);
				
				
				
				$this->success('新增成功！',  U('index?matchgameid='.I('post.match_game_id')));
			} else {
				$error = $MatchGameDetail->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			empty($matchgameid) && $this->error('参数错误！');
				
			$matchGame=D('MatchGame')->field(true)->find($matchgameid);
			$this->assign('matchgame',$matchGame);
			$this->assign('match_game_id',$matchgameid);
				
			$this->meta_title = '添加小组赛';
			$this->display('edit');
		}

	}
	public function  edit($id=null)
	{
		if (IS_POST)
		{
			$MatchGameDetail = D('MatchGameDetail');
			if(false !== $MatchGameDetail->update()){
				$this->success('新增成功！', U('index?matchgameid='.I('match_game_id')));
			} else {
				$error = $MatchGameDetail->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			empty($id) && $this->error('参数错误！');
			$macthgamedetail=D('MatchGameDetail')->field(true)->find($id);
			$this->assign('matchgamedetail',$macthgamedetail);
			
						$matchGame=D('MatchGame')->field(true)->find($id);
			$this->assign('matchgame',$matchGame);
			$this->assign('match_game_id',$matchgameid);
			
			$this->meta_title = '编辑结果';
			$this->display('edit');
		}
	}

	public function  delete($id=null,$matchgameid=null)
	{
		$MatchGameDetail = D('MatchGameDetail');
		$result=$MatchGameDetail->where(array('id'=>$id,))->delete();
		if ($result)
		{
			$this->success('删除成功！',U('index?matchgameid='.$matchgameid));
		}else
		{

		}
	}

}