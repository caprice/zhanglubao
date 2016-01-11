<?php
namespace Home\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexFightsWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'sort desc')
	{
		$fights = S('index_fight_list');
		if (empty($fights)) {
			$map['status']=1;
			$fights = D('Fight')->getFightsInfo($map,5);
			S('index_fight_list', $fights, 3000);
		}
		$this->assign('fights', $fights);
		$this->display('Widget/Index/fightsList');
	}
}