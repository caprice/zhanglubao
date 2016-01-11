<?php
namespace Home\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexTeamsWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
        $teams = S('index_team_list');
        if (empty($teams)) {
            $teams = D('Team')->getTeamsInfo($map,10);
            S('index_team_list', $teams, 3000);
        }
        $this->assign('teams', $teams);
        $this->display('Widget/Index/teamList');
    }
}