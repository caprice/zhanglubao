<?php

namespace Addons\Rank_checkin;

use Common\Controller\Addon;

/**
 * 签到排名插件
 * @author 想天软件工作室
 */
class Rank_checkinAddon extends Addon
{

    public $info = array(
        'name' => 'Rank_checkin',
        'title' => '签到排名',
        'description' => '设置每天某一时刻开始 按时间先后 签到排名，取前十',
        'status' => 1,
        'author' => '想天软件工作室',
        'version' => '0.1'
    );

    public $admin_list = array(
        'model' => 'Example', //要查的表
        'fields' => '*', //要查的字段
        'map' => '', //查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
        'order' => 'id desc', //排序,
        'listKey' => array( //这里定义的是除了id序号外的表格里字段显示的表头名
            '字段名' => '表头显示名'
        ),
    );

    public function install()
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }

    //实现的Rank钩子方法
    public function Rank($param)
    {

        $getranktime = $this->getConfig();
        $set_ranktime = $getranktime['ranktime'];

        $y = date("Y", time());
        $m = date("m", time());
        $d = date("d", time());


        $start_time = mktime($set_ranktime, 0, 0, $m, $d, $y);
        $this->assign("ss", $start_time);
        $rank=S('check_rank');
        if(empty($rank)){
            $rank = D('Check_info')->where('ctime>' . $start_time)->order('ctime asc')->limit(5)->select();
           S('check_rank',$rank,60);
        }

        if (time() <= $start_time) {
            $this->assign("time", $set_ranktime);
            $this->display('default');
        } else {
            foreach ($rank as &$v) {
                $v['userInfo'] = query_user(array('avatar32','space_url', 'username', 'uid',), $v['uid']);
            }
            //dump($rank);exit;
            $this->assign("rank", $rank);
            $this->display('rank');
        }


    }

}