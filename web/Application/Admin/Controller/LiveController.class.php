<?php
namespace Admin\Controller;

class  LiveController extends  AdminController
{
	public function  index()
	{
		$list   = $this->lists('Live');
		int_to_string($list);
		$this->assign('_list', $list);

		$this->meta_title = '房间信息';
		$this->display();
	}

	public function add()
	{
		if(IS_POST)
		{
			$Live = D('Live');
			if(false !== $Live->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Live->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '添加专辑';
			$games=$this->getGames();
			$this->assign('sites',$this->getFrom());
			$this->assign('games',$games);
			$this->display('edit');
		}
	}
	public function edit($id = null)
	{
		if(IS_POST)
		{
			$Live = D('Live');
			if(false !== $Live->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Live->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '编辑专辑';
			empty($id) && $this->error('参数不能为空！');
			$live=D('Live')->field(true)->find($id);
			empty($live) && $this->error('参数错误！');
			$games=$this->getGames();
			$this->assign('sites',$this->getFrom());
			$this->assign('games',$games);
			$this->assign('live',$live);
			$this->display('edit');
		}
	}

	private  function  getFrom()
	{
		$data[1]=array('id'=>1,'title'=>'群挑直播');
		$data[2]=array('id'=>2,'title'=>'YY直播');
		$data[3]=array('id'=>3,'title'=>'腾讯直播');
		$data[4]=array('id'=>4,'title'=>'斗鱼直播');
		$data[5]=array('id'=>5,'title'=>'其他直播');
		return $data;
	}

	/**
	 * 直播状态修改
	 */
	public function changeStatus($method=null){
		$id = array_unique((array)I('id',0));
		$id = is_array($id) ? implode(',',$id) : $id;
		if ( empty($id) ) {
			$this->error('请选择要操作的数据!');
		}
		$map['id'] =   array('in',$id);
		switch ( strtolower($method) ){
			case 'forbidlive':
				$this->forbid('Live', $map );
				break;
			case 'resumelive':
				$this->resume('Live', $map );
				break;
			case 'deletelive':
				$this->delete('Live', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}



}