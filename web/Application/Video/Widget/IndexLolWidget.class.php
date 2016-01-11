<?php

namespace Video\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexLolWidget extends Action {
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'sort desc') {
		//$videos = S ( 'video_index_lols' );
		if (empty ( $videos )) {
			$map ['game_id'] = 10005;
			$videos = D ( 'Video' )->getVideosInfo ( $map, 12 );
			S ( 'video_index_lols', $videos, 3000 );
		}
		
		//$recvideos = S ( 'video_index_reclols' );
		if (empty ( $recvideos )) {
			$map ['game_id'] = 10005;
			$map ['edit_status'] = 1;
			$recvideos = D ( 'Video' )->getVideosInfo ( $map, 2 );
			S ( 'video_index_reclols', $recvideos, 3000 );
		}
		
		$this->assign ( 'reclols', $recvideos );
		$this->assign ( 'lols', $videos );
		$this->display ( 'Widget/Index/lol' );
	}
}