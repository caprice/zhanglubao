<?php
namespace Home\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexGuessWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'id desc')
    { 
    	
    	
          //$matches = S('index_guess_list');
        if (empty($matches)) {
        	$map['status']=1;
        	$map['game_status']=array('lt',2);
            $matches = D('MatchGame')->getMatchGamesInfo($map,3,'follows desc');
            S('index_guess_list', $matches, 3000);
        }
        $this->assign('guesses', $matches);
        $this->display('Widget/Index/guessList');
    }
}