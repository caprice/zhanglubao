<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Weibo\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class TopUserListWidget extends Action
{

    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = array(), $order = 'id desc',$title='最新加入',$tag='top')
    {
        $users = S('weibo_latest_user_'.$tag);
        if (empty($users)) {
            $user = D('Member')->where($map)->order($order)->limit(6)->select();
            foreach ($user as &$uid) {
                $uid['user'] = query_user(array('avatar64', 'nickname', 'space_url', 'space_link'), $uid['uid']);
                $uid['id']=$uid['uid'];
            }
            unset($uid);
            $users = $user;
            S('weibo_latest_user_'.$tag, $users, 300);
        }
        $this->assign('user', $users);
        $this->assign('title',$title);
        $this->display('Widget/userList');
    }

}
