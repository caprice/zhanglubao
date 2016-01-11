<?php

namespace Addons\Support;

use Common\Controller\Addon;

/**
 * 签到插件
 * @author 想天软件工作室
 */
class SupportAddon extends Addon
{

    public $info = array(
        'name' => 'Support',
        'title' => '赞',
        'description' => '赞的功能',
        'status' => 1,
        'author' => '想天软件工作室',
        'version' => '0.1'
    );

    public $admin_list = array(
        'model' => 'Check_info', //要查的表
        'fields' => '*', //要查的字段
        'map' => '', //查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
        'order' => 'uid desc', //排序,
        'listKey' => array( //这里定义的是除了id序号外的表格里字段显示的表头名
            'uid' => 'UID',
            'con_num' => '连续签到次数',
            'total_num' => '总签到次数',
            'ctime' => '签到时间',
        ),
    );

    public function install()
    {

        $db_prefix = C('DB_PREFIX');
        $sql = "
CREATE TABLE IF NOT EXISTS `{$db_prefix}support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appname` varchar(20) NOT NULL COMMENT '应用名',
  `row` int(11) NOT NULL COMMENT '应用标识',
  `uid` int(11) NOT NULL COMMENT '用户',
  `create_time` int(11) NOT NULL COMMENT '发布时间',
  `table` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='支持的表'  ;
        ";

        D('')->execute($sql);

        return true;
    }

    public function uninstall()
    {
        return true;
    }

    //实现的checkin钩子方法
    public function support($param)
    {

        $this->assign($param);


        $support['appname'] = $param['app'];
        $support['table'] = $param['table'];
        $support['row'] = $param['row'];
        $count = D('Support')->where($support)->count();
        $support['uid']=is_login();
        $supported = D('Support')->where($support)->count();
        $this->assign('count',$count);
        $this->assign('supported',$supported);
        $this->display('support');

    }


}








