<?php

namespace Video\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class AlbumUserVideoWidget extends Action {
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($uid) {
		// $videos = S('video_list_hot'.$gameid);
		if (empty ( $videos )) {
			if ($uid) {
				$map ['uid'] = $uid;
			}
			$videos = D ( 'Video' )->getVideosInfo ( $map, 8 );
			S ( 'video_list_hot_uid' . $uid, $videos, 3000 );
		}
		$this->assign ( 'uservideos', $videos );
		$this->display ( 'Widget/Album/uservideo' );
	}
 
}