<?php
namespace Home\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexVideosWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'sort desc')
	{
		$videos = S('index_video_list');
		if (empty($videos)) {
			$map['status']=1;
			$videos = D('Video')->getVideosInfo($map,12);
			S('index_video_list', $videos, 3000);
		}


		$recvideos = S('index_video_reclist');
		if (empty($recvideos)) {
			$map['status']=1;
			$map['edit_status']=1;
			$recvideos = D('Video')->getVideosInfo($map,2);
			S('index_video_reclist', $recvideos, 3000);
		}
		
		$this->assign('recvideos', $recvideos);
		$this->assign('videos', $videos);
		$this->display('Widget/Index/videoList');
	}
}