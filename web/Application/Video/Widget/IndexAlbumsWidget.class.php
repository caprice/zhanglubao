<?php

namespace Video\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexAlbumsWidget extends Action {
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'sort desc') {
		// $albums = S('video_index_album');
		if (empty ( $albums )) {
			$map ['status'] = 1;
			$albums = D ( 'VideoAlbum' )->getAlbumsInfo ( $map, 12 );
			S ( 'video_index_album', $albums, 3000 );
		}
		$this->assign ( 'albums', $albums );
		$this->display ( 'Widget/Index/albums' );
	}
}