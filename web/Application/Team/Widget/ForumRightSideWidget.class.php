<?php
namespace Team\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class ForumRightSizeWidget extends Action
{
 
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'id desc')
	{
	         //$posts = S('index_team_forums');
        if (empty($posts)) {
        	$map['status']=1;
            $posts = D('ForumPost')->getForumPostsInfo($map,16);
            S('index_team_forums', $posts, 3000);
        }
        
         $this->assign('posts', $posts);
		$this->display('Widget/Index/forums');
	}
	
	
}