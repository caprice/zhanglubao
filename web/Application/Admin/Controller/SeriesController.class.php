<?php
namespace Admin\Controller;

use Org\Util\Date;

class  SeriesController extends  AdminController
{

	public function index()
	{
		$list   = $this->lists('MatchSeries');
		int_to_string($list);
		$this->assign('_list', $list);

		$this->meta_title = '系列赛信息';
		$this->display();
	}
	public function  add()
	{
		if(IS_POST)
		{
			$MatchSeries = D('MatchSeries');
			if(false !== $MatchSeries->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $MatchSeries->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->meta_title = '添加比赛';
			$this->display('edit');
		}
	}public function edit($id = null)
	{
		if(IS_POST){
			$MatchSeries = D('MatchSeries');
			if(false !== $MatchSeries->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $MatchSeries->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else {
			empty($id) && $this->error('参数不能为空！');
			$this->meta_title = '编辑战队';
			$series=D('MatchSeries')->field(true)->find($id);
			empty($series) && $this->error('参数错误！');
			$games=$this->getGames();
			$this->assign('games',$games);
			$this->assign('series',$series);
			$this->display('edit');
		}
	}
	
	/**
	 * 系列赛状态修改
	 */
	public function changeStatus($method=null){
		$id = array_unique((array)I('id',0));
		$id = is_array($id) ? implode(',',$id) : $id;
		if ( empty($id) ) {
			$this->error('请选择要操作的数据!');
		}
		$map['id'] =   array('in',$id);
		switch ( strtolower($method) ){
			case 'forbidseries':
				$this->forbid('MatchSeries', $map );
				break;
			case 'resumeseries':
				$this->resume('MatchSeries', $map );
				break;
			case 'deleteseries':
				$this->delete('MatchSeries', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}

}