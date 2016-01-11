<?php

namespace Team\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexVideoWidget extends Action {
	
	

	
	public function lists($map = '', $order = 'id desc') {
		// $videos= S('t_i_video_list');
		if (empty ( $videos )) {
			$map = array ();
			$videos = D ( 'MatchVideo' )->getVideosInfo ( $map, 12 );
			S ( 't_i_video_list', $videos, 3000 );
		}
		$this->assign ( 'videos', $videos );
		$this->display('Widget/Index/videos');
	}
}