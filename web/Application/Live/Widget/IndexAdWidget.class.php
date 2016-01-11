<?php
namespace Live\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexAdWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'sort desc')
	{
		// $scrolls = S('live_index_recs');
		if (empty($scrolls)) {
			 
			$scrolls = D('LiveRecommend')->getRecommendsInfo($map,4);
			S('live_index_recs', $scrolls, 4);
		}
		 
		$this->assign('scrolls', $scrolls);
		$this->display('Widget/Index/adArea');
	}
}