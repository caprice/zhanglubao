<?php
// +----------------------------------------------------------------------
// | all for fight
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.quntiao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Rocks 
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Admin\Builder\AdminListBuilder;
use Admin\Builder\AdminConfigBuilder;

/**
 * 后台头衔控制器
 * @author Rocks
 */
class RankController extends AdminController
{

    /**
     * 头衔管理首页
     * @author Rocks
     */
    public function index($page = 1, $r = 20)
    {
        //读取数据
        $model = D('Rank');
        $list = $model->page($page, $r)->select();
        foreach ($list as &$val) {
            $val['u_name'] = D('member')->where('uid=' . $val['uid'])->getField('nickname');
        }
        $totalCount = $model->count();
        //显示页面
        $builder = new AdminListBuilder();
        $builder
            ->title('头衔列表')
            ->buttonNew(U('Rank/editRank'))
            ->keyId()->keyTitle()->keyText('u_name', '上传者')->keyCreateTime()->keyDoActionEdit('editRank?id=###')->keyDoAction('deleteRank?id=###', '删除')
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function deleteRank($id = null)
    {
        if (!$id) {
            $this->error('请选择头衔');
        }
        $result = D('rank')->where('id=' . $id)->delete();
        $result1 = D('rank_user')->where('rank_id=' . $id)->delete();
        if ($result) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    public function editRank($id = null)
    {
        //判断是否为编辑模式
        $isEdit = $id ? true : false;
        //如果是编辑模式
        if ($isEdit) {
            $rank = M('rank')->where(array('id' => $id))->find();
        }
        //显示页面
        $builder = new AdminConfigBuilder();
        $builder
            ->title($isEdit ? '编辑头衔' : '新增头衔')
            ->keyId()->keyTitle()->keySingleImage('logo', '头衔图标', '图标')
            ->data($rank)
            ->buttonSubmit(U('doEditRank'))->buttonBack()
            ->display();
    }

    public function doEditRank($id = null, $title, $logo)
    {
        $is_Edit = $id ? true : false;
        $data = array('title' => $title, 'logo' => $logo);
        $model = D('rank');
        if ($is_Edit) {
            $data_old = $model->where('id=' . $id)->find();
            if ($title != '') {
                $data_old['title'] = $data['title'];
            }
            if ($logo != '') {
                $data_old['logo'] = $data['logo'];
            }
            if ($title == '' && $logo == '') {
                $this->error('信息不完整');
            }
            $result = $model->where('id=' . $id)->save($data_old);
            if (!$result) {
                $this->error('修改失败');
            }
        } else {
            if ($title == '' || $logo == '') {
                $this->error('信息不完整');
            }
            $data = $model->create($data);
            $data['uid'] = is_login();
            $data['create_time'] = time();
            $result = $model->add($data);
            if (!$result) {
                $this->error('创建失败');
            }
        }
        $this->success($is_Edit ? '编辑成功' : '添加成功', U('Rank/index'));
    }

    public function userList()
    {
        $nickname = I('nickname');
        $map['status'] = array('egt', 0);
        if (is_numeric($nickname)) {
            $map['uid|nickname'] = array(intval($nickname), array('like', '%' . $nickname . '%'), '_multi' => true);
        } else {
            $map['nickname'] = array('like', '%' . (string)$nickname . '%');
        }
        $list = $this->lists('Member', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '用户列表';
        $this->display();
    }

    public function userRankList($id = null, $page = 1)
    {
        if (!$id) {
            $this->error('请选择用户');
        }
        $u_name = D('member')->where('uid=' . $id)->getField('nickname');
        $model = D('rank_user');
        $rankList = $model->where('uid=' . $id)->page($page, 20)->order('create_time asc')->select();
        $totalCount = $model->where('uid=' . $id)->count();
        foreach ($rankList as &$val) {
            $val['title'] = D('rank')->where('id=' . $val['rank_id'])->getField('title');
            $val['is_show'] = $val['is_show'] ? '显示' : '不显示';
        }
        $builder = new AdminListBuilder();
        $builder
            ->title($u_name . '的头衔列表')
            ->buttonNew(U('Rank/userAddRank?id=' . $id), '关联新头衔')
            ->keyId()->keyText('title', '头衔名称')->keyText('reason', '颁发理由')->keyText('is_show', '是否显示在昵称右侧')->keyCreateTime()->keyDoActionEdit('Rank/userChangeRank?id=###')->keyDoAction('Rank/deleteUserRank?id=###', '删除')
            ->data($rankList)
            ->pagination($totalCount, 20)
            ->display();
    }

    public function userAddRank($id = null)
    {
        if (!$id) {
            $this->error('请选择用户');
        }
        $data['uid'] = $id;
        $ranks = D('rank')->select();
        if (!$ranks) {
            $this->error('还没有头衔，请先添加头衔');
        }
        foreach ($ranks as $val) {
            $rank_ids[$val['id']] = $val['title'];
        }
        $data['rank_id'] = $ranks[0]['id'];
        $data['is_show'] = 1;
        $builder = new AdminConfigBuilder();
        $builder
            ->title('添加头衔关联')
            ->keyId()->keyReadOnly('uid', '用户ID')->keyText('reason', '关联理由')->keyRadio('is_show', '是否显示在昵称右侧', null, array(1 => '是', 0 => '否'))->keySelect('rank_id', '头衔编号', null, $rank_ids)
            ->data($data)
            ->buttonSubmit(U('doUserAddRank'))->buttonBack()
            ->display();
    }

    public function userChangeRank($id = null)
    {
        if (!$id) {
            $this->error('请选择要修改的头衔关联');
        }
        $data = D('rank_user')->where('id=' . $id)->find();
        if (!$data) {
            $this->error('该头衔关联不存在');
        }
        $ranks = D('rank')->select();
        if (!$ranks) {
            $this->error('还没有头衔，请先添加头衔');
        }
        foreach ($ranks as $val) {
            $rank_ids[$val['id']] = $val['title'];
        }
        $builder = new AdminConfigBuilder();
        $builder
            ->title('编辑头衔关联')
            ->keyId()->keyReadOnly('uid', '用户ID')->keyText('reason', '关联理由')->keyRadio('is_show', '是否显示在昵称右侧', null, array(1 => '是', 0 => '否'))->keySelect('rank_id', '头衔编号', null, $rank_ids)
            ->data($data)
            ->buttonSubmit(U('doUserAddRank'))->buttonBack()
            ->display();
    }

    public function doUserAddRank($id = null, $uid, $reason, $is_show, $rank_id)
    {
        $is_Edit = $id ? true : false;
        $data = array('uid' => $uid, 'reason' => $reason, 'is_show' => $is_show, 'rank_id' => $rank_id);
        $model = D('rank_user');
        if ($is_Edit) {
            $data = $model->create($data);
            $data['create_time'] = time();
            $result = $model->where('id=' . $id)->save($data);
            if (!$result) {
                $this->error('关联失败');
            }
        } else {
            $rank_user = $model->where(array('uid' => $uid, 'rank_id' => $rank_id))->find();
            if ($rank_user) {
                $this->error('该用户已经拥有该头衔，请选着其他头衔');
            }
            $data = $model->create($data);
            $data['create_time'] = time();
            $result = $model->add($data);
            if (!$result) {
                $this->error('关联失败');
            } else {
                $rank = D('rank')->where('id=' . $data['rank_id'])->find();
                //$logoUrl=getRootUrl().D('picture')->where('id='.$rank['logo'])->getField('path');
                $u_name = D('member')->where('uid=' . $uid)->getField('nickname');
                $content = '管理员给你颁发了头衔：[' . $rank['title'] . ']'; //<img src="'.$logoUrl.'" title="'.$rank['title'].'" alt="'.$rank['title'].'">';

                $user = query_user(array('username', 'space_link'), $uid);

                $content1 = '管理员给@' . $user['username'] . ' 颁发了新的头衔：[' . $rank['title'] . ']，颁发理由：' . $reason; //<img src="'.$logoUrl.'" title="'.$rank['title'].'" alt="'.$rank['title'].'">';
                clean_query_user_cache($uid,array('rank_link'));
                $this->sendMessage($data, $content);
                //写入数据库
                $model = D('Weibo/Weibo');
                $result = $model->addWeibo(is_login(), $content1);
            }
        }
        $this->success($is_Edit ? '编辑关联成功' : '添加关联成功', U('Rank/userRankList?id=' . $uid));
    }

    public function deleteUserRank($id = null)
    {
        if (!$id) {
            $this->error('请选择头衔关联');
        }
        $result = D('rank_user')->where('id=' . $id)->delete();
        if ($result) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    public function sendMessage($data, $content)
    {
        /**
         * @param $to_uid 接受消息的用户ID
         * @param string $content 内容
         * @param string $title 标题，默认为  您有新的消息
         * @param $url 链接地址，不提供则默认进入消息中心
         * @param $int $from_uid 发起消息的用户，根据用户自动确定左侧图标，如果为用户，则左侧显示头像
         * @param int $type 消息类型，0系统，1用户，2应用
         */
        D('Message')->sendMessage($data['uid'], $content, '头衔颁发', U('Usercenter/Message/message'), is_login(), 1);
    }
}
