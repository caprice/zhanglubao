<?php
namespace Fight\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexLolWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'id desc') {
		
		// $fights = S('fight_index_lols');
		if (empty ( $fights )) {
			$Fight =D('Fight');
			$map ['status'] = 1;
			$map['game_id']=10005;
			$fights = $Fight->getFightsInfo($map,12,$order);
			S('fight_index_lols', $fights, 3000);
		}
		$this->assign ( 'lols', $fights );
		$this->display ( 'Widget/Index/lol' );
	}
}