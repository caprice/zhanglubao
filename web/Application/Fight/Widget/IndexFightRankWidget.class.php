<?php

namespace Fight\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexFightRankWidget extends Action {
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'win_fights desc') {
		
		// $members = S('fight_index_members');
		if (empty ( $members )) {
			$Member = D ( 'Member' );
			$map ['status'] = 1;
			$members = $Member->getMembersInfo ( $map, 8, $order );
			 S('fight_index_members', $members, 3000);
		}
		
		$this->assign ( 'members', $members );
		$this->display ( 'Widget/Index/fightrank' );
	}
}