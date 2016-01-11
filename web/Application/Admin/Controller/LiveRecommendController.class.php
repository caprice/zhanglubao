<?php
namespace Admin\Controller;

class  LiveRecommendController extends  AdminController
{
	public function  index()
	{
		$list   = $this->lists('LiveRecommend');
		int_to_string($list);
		$this->assign('_list', $list);
		$this->meta_title = '热门直播信息';
		$this->display();
	}
	
	
	public function add()
	{
		if(IS_POST)
		{
			$LiveRecommend = D('LiveRecommend');
			if(false !== $LiveRecommend->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $LiveRecommend->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '添加推荐直播';
			$this->display('edit');
		}
	}
	public function edit($id = null)
	{
		if(IS_POST)
		{
			$LiveRecommend = D('LiveRecommend');
			if(false !== $LiveRecommend->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $LiveRecommend->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		}else
		{
			$this->meta_title = '编辑推荐直播';
			empty($id) && $this->error('参数不能为空！');
			$liverecommend=D('LiveRecommend')->field(true)->find($id);
			empty($liverecommend) && $this->error('参数错误！');
			$this->assign('liverecommend',$liverecommend);
			$this->display('edit');
		}
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
			case 'forbidliverecommend':
				$this->forbid('LiveRecommend', $map );
				break;
			case 'resumeliverecommend':
				$this->resume('LiveRecommend', $map );
				break;
			case 'deleteliverecommend':
				$this->delete('LiveRecommend', $map );
				break;
			default:
				$this->error('参数非法');
		}
	}
}