<?php
namespace Admin\Controller;
use User\Api\UserApi;


class  TeamController extends  AdminController
{
	public function index()
	{
		$list   = $this->lists('Team');
		int_to_string($list);
		$this->assign('_list', $list);

		$this->meta_title = '战队信息';
		$this->display();
	}
	public function  add()
	{
		if(IS_POST)
		{
			$Team = D('Team');
			$res=$Team->update();
			if(false !== $res){
				$data['title']=I('post.name');
				$data['description']=I('post.description');
				$data['tags']=I('post.tags');
				$Forum = D('Forum');
				$forumdata=$Forum->addForum($data);
				if(false !== $forumdata){
					$team['id']=$res;
					$team['forum_id']=$forumdata;
					$Team->updateTeam($team);
				}else
				{
					$error = $Forum->getError();
					$this->error(empty($error) ? '未知错误！' : $error);
				}
					
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Team->getError();
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


	public function  addMember($id=null)
	{

		if(IS_POST)
		{



			$username = I('post.username');
			$email = I('post.email');
			$real_name=I('post.real_name');
			$game_uname=I('post.game_uname');
			$place=I('post.place');
			$role=I('post.role');
			$hero=I('post.hero');
			$verified=1;
			$verified_info=I('post.team_name').'战队'.$place;
			$tid=I('post.team_id');

			D('Team')->where('id='.$tid)->setInc('members',1);


			$password="quntiao#147258";
			/* 调用注册接口注册用户 */
			$User   =   new UserApi;
			$uid    =   $User->register($username, $password, $email);
			if(0 < $uid){ //注册成功
				$user = array('uid' => $uid, 'nickname' => $username, 'status' => 1);
				$user['verified']=1;
				$user['verified_info']=$verified_info;
				$user['game_uname']=$game_uname;
				$user['real_name']=$real_name;

				if(!M('Member')->add($user)){
					$this->error('用户添加失败！');
				}


				$TeamMember=D('TeamMember');
				$tmember['uid']=$uid;
				$tmember['team_id']=$tid;
				$tmember['role']=$role;
				$tmember['place']=$place;
				$tmember['hero']=$hero;

				if(!$TeamMember->updateMember($tmember)){
					$this->error('成员添加失败！');
				}

				$Avatar = D('Avatar');
				$pic_driver = C('PICTURE_UPLOAD_DRIVER');
				$avatarConfig=C('AVATAR_PICTURE_UPLOAD');
				$info = $Avatar->uploadByUid(
				$_FILES,
				$uid,
				C('AVATAR_PICTURE_UPLOAD'),
				C('PICTURE_UPLOAD_DRIVER'),
				C("UPLOAD_{$pic_driver}_CONFIG")
				);
					
				$this->success('新增成功！', U('Team/addMember?id='.$tid));


			} else { //注册失败，显示错误信息
				$this->error($uid);
			}





		}else {
			empty($id) && $this->error('参数不能为空！');
			$this->assign('team_id',$id);
			$this->display('addMember');
		}

	}

	private  function  uploadIcon($files)
	{
		$Picture = D('Picture');
		$pic_driver = C('PICTURE_UPLOAD_DRIVER');
		$teamConfig=C('TEAM_PICTURE_UPLOAD');
		$teamConfig['subName'][1]=$teamid;
		$info = $Picture->upload(
		$files,
		$teamConfig,
		C('PICTURE_UPLOAD_DRIVER'),
		C("UPLOAD_{$pic_driver}_CONFIG")
		);

		/* 记录图片信息 */
		if($info){
			$return['status'] = 1;
			$return = array_merge($info['team_icon'], $return);
		} else {
			$this->error($Picture->getError());
		}
		return $return['id'];
	}


	public function  edit($id = null)
	{
		if(IS_POST){
			$Team = D('Team');
			if(false !== $Team->update()){
				$this->success('更新成功！', U('index'));
			} else {
				$error = $Team->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else {
			empty($id) && $this->error('参数不能为空！');
			$this->meta_title = '编辑战队';
			$team=D('Team')->field(true)->find($id);
			empty($team) && $this->error('参数错误！');
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->assign('team',$team);
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
			case 'forbidteam':
				$this->forbid('Team', $map );
				break;
			case 'resumeteam':
				$this->resume('Team', $map );
				break;
			case 'deleteteam':
				$this->delete('Team', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}
}