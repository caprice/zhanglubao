<?php
namespace Home\Controller;
use Common\Controller\BaseController;
class ListController extends BaseController{
	
	public function category($id=0,$page=0)
	{
		$start=$page*16;
		$data['videos']=D('VideoVideo')->where('category_id='.$id)->field ( 'id,picture_id,video_title' )->order('id desc')->limit($start.",16")->select();
		$data ['status'] = 1;
		$this->ajaxReturn($data);
	}
	public function fresh($page=0)
	{
		$start=$page*16;
		$data['videos']=D('VideoVideo')->field ( 'id,picture_id,video_title' )->order('id desc')->limit($start.",16")->select();
		$data ['status'] = 1;
		$this->ajaxReturn($data);
	}
}
?>