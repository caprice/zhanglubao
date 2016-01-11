<?php
namespace Competition\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class CAdWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'sort desc')
	{
		//$scrolls = S('index_ad_scroll');
		if (empty($scrolls)) {
			$map['status']=1;
			$map['module']='competition';
			$map['place']=0;
			$scrolls = D('Ad')->getAdsInfo($map,5);
			S('c_ad_scroll', $scrolls, 3000);
		}

		//$recads = S('index_ad_rec');
		if (empty($recads)) {
			$map['status']=1;
			$map['place']=1;
			$map['module']='competition';
			$recads = D('Ad')->getAdsInfo($map,2);
			S('c_ad_rec', $recads, 3000);
		}
	
		$this->assign('scrolls', $scrolls);
		$this->assign('recads', $recads);
		$this->display('Widget/adArea');
	}
}