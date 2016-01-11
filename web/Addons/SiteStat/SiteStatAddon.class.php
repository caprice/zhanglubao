<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------


namespace Addons\SiteStat;
use Common\Controller\Addon;

/**
 * 系统环境信息插件
 * @author thinkphp
 */

class SiteStatAddon extends Addon{

    public $info = array(
        'name'=>'SiteStat',
        'title'=>'站点统计信息',
        'description'=>'统计站点的基础信息',
        'status'=>1,
        'author'=>'thinkphp',
        'version'=>'0.2'
    );

    public function install(){
        return true;
    }

    public function uninstall(){
        return true;
    }

    //实现的AdminIndex钩子方法
    public function AdminIndex($param){
        $config = $this->getConfig();
        $this->assign('addons_config', $config);
		$map['status'] = array('egt',0);
		$maps['is_read'] = array('eq',0);
        if($config['display']){
            $info['user']		=	M('Member')->where($map)->count();
            $info['users']		=	M('Ucenter_member')->where($map)->count();
            $info['userall']		=	M('Ucenter_member')->count();
            $info['action']		=	M('ActionLog')->count();
            $info['document']	=	M('Document')->count();
            $info['forumall']	=	M('Forum_post')->count();
            $info['forumtie']	=	M('Forum_post')->where($map)->count();
            $info['weiboall']	=	M('Weibo')->count();
            $info['weibo']	=	M('Weibo')->where($map)->count();
            $info['messageall']	=	M('Message')->count();
            $info['message']	=	M('Message')->where($maps)->count();
            $info['category']	=	M('Category')->count();
            $info['model']		=	M('Model')->count();
            $this->assign('info',$info);
            $this->display('info');
        }
    }
}