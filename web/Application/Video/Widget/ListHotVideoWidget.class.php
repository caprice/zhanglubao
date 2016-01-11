<?php

namespace Video\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class ListHotVideoWidget extends Action {
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($gameid) {
		// $videos = S('video_list_hot'.$gameid);
		if (empty ( $videos )) {
			$map ['edit_status'] = 1;
			if ($gameid) {
				$map ['game_id'] = $gameid;
			}
			$map ['edit_status'] = 1;
			$videos = D ( 'Video' )->getVideosInfo ( $map, 8 );
			S ( 'video_list_hot' . $gameid, $videos, 3000 );
		}
		$this->assign ( 'hots', $videos );
		$this->display ( 'Widget/List/hot' );
	}
	
	
	/* 显示指定分类的同级分类或子分类列表 */
	public function newvideos($gameid) {
		// $videos = S('video_list_new'.$gameid);
		if (empty ( $videos )) {
			if ($gameid) {
				$map ['game_id'] = $gameid;
			}
			$map ['edit_status'] = 1;
			$videos = D ( 'Video' )->getVideosInfo ( $map, 8 );
			S ( 'video_list_new' . $gameid, $videos, 3000 );
		}
		$this->assign ( 'hots', $videos );
		$this->display ( 'Widget/List/hot' );
	}
}