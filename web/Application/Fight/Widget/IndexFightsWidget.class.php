<?php
namespace Fight\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexFightsWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'id desc') {
		
		// $fights = S('fight_index_fights');
		if (empty ( $fights )) {
			$Fight =D('Fight');
			$map ['status'] = 1;
			$fights = $Fight->getFightsInfo($map,12,$order);
			S('fight_index_fights', $fights, 3000);
		}
		$this->assign ( 'fights', $fights );
		$this->display ( 'Widget/Index/fights' );
	}
}