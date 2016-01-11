<?php
/**
 * 所属项目 OnePlus.
 * 开发者: 想天
 * 创建日期: 3/12/14
 * 创建时间: 12:49 PM
 * 版权所有 想天工作室(www.ourstu.com)
 */

namespace Usercenter\Controller;

use Think\Controller;

class SessionController extends BaseController
{
    protected $mTalkModel;

    public function _initialize()
    {
        parent::_initialize();
        $this->mTalkModel = D('Talk');
    }

    public function getSession($id)
    {
        $id = intval($id);
        //获取当前会话
        $talk = $this->getTalk(0, $id);
        $uids = D('Talk')->getUids($talk['uids']);
        foreach ($uids as $uid) {
            if ($uid != is_login()) {
                $talk['first_user'] = query_user(array('avatar64', 'username'), $uid);
                $talk['ico'] = $talk['first_user']['avatar64'];
                break;
            }
        }
        $map['talk_id'] = $talk['id'];
        D('TalkPush')->where(array('uid'=>get_uid(),'source_id'=>$id))->setField('status',-1);
        D('TalkMessagePush')->where(array('uid'=>get_uid(),'talk_id'=>$id))->setField('status',-1);
        $messages = D('TalkMessage')->where($map)->order('create_time desc')->limit(20)->select();
        $messages = array_reverse($messages);
        foreach ($messages as &$mes) {
            $mes['user'] = query_user(array('avatar64', 'uid', 'username'), $mes['uid']);
            $mes['ctime'] = date('m-d h:i', $mes['create_time']);
            $mes['avatar64'] = $mes['user']['avatar64'];
        }
        unset($mes);
        $talk['messages'] = $messages;
        $talk['self'] = query_user(array('avatar128'), is_login());
        $talk['mid'] = is_login();
        echo json_encode($talk);
    }

    /**消息页面
     * @param int    $page
     * @param string $tab 当前tab
     */
    public function message($page = 1, $tab = 'unread')
    {
        //从条件里面获取Tab
        $map = $this->getMapByTab($tab, $map);

        $map['to_uid'] = is_login();

        $messages = D('Message')->where($map)->order('create_time desc')->page($page, 10)->select();
        $totalCount = D('Message')->where($map)->order('create_time desc')->count(); //用于分页

        foreach ($messages as &$v) {
            if ($v['from_uid'] != 0) {
                $v['from_user'] = query_user(array('username', 'space_url', 'avatar64', 'space_link'), $v['from_uid']);
            }
        }

        $this->assign('totalCount', $totalCount);
        $this->assign('messages', $messages);

        //设置Tab
        $this->defaultTabHash('message');
        $this->assign('tab', $tab);
        $this->display();
    }

    /**
     * 会话列表页面
     */
    public function session()
    {
        $this->defaultTabHash('session');
        $talks = D('Talk')->where('uids like' . '"%[' . is_login() . ']%"' . ' and status=1')->order('update_time desc')->select();
        foreach ($talks as $key => $v) {
            $users = array();
            $uids_array = $this->mTalkModel->getUids($v['uids']);
            foreach ($uids_array as $uid) {
                $users[] = query_user(array('avatar64', 'username', 'space_link', 'id'), $uid);
            }
            $talks[$key]['users'] = $users;
            $talks[$key]['last_message'] = D('Talk')->getLastMessage($talks[$key]['id']);
        }
        $this->assign('talks', $talks);
        $this->display();
    }

    /**对话页面
     * 创建会话或显示现有会话。
     * @param int $message_id 消息ID 只提供消息则从消息自动创建一个会话
     * @param int $talk_id 会话ID
     */
    public function talk($message_id = 0, $talk_id = 0)
    {
        //获取当前会话
        $talk = $this->getTalk($message_id, $talk_id);
        $map['talk_id'] = $talk['id'];
        $messages = D('TalkMessage')->where($map)->order('create_time desc')->limit(20)->select();
        $messages = array_reverse($messages);
        foreach ($messages as &$mes) {
            $mes['user'] = query_user(array('avatar128', 'uid', 'username'), $mes['uid']);
            $mes['content'] = op_t($mes['content']);
        }
        unset($mes);
        $this->assign('messages', $messages);

        $this->assign('talk', $talk);
        $self = query_user(array('avatar128'), is_login());
        $this->assign('self', $self);
        $this->assign('mid', is_login());
        $this->defaultTabHash('session');
        $this->display();
    }

    /**
     * 删除现有会话
     */
    public function doDeleteTalk($talk_id)
    {
        $this->requireLogin();

        //确认当前用户属于会话。
        $talk = D('Talk')->find($talk_id);
        $uid = get_uid();
        if (false === strpos($talk['uids'], "[$uid]")) {
            $this->error('您没有权限删除该会话');
        }

        //如果删除前会话中只有两个人，就将会话标记为已删除。
        $uids = explode(',', $talk['uids']);
        if (count($uids) <= 2) {
            D('Talk')->where(array('id' => $talk_id))->setField('status', -1);
            D('Message')->where(array('talk_id' => $talk_id))->setField('talk_id', 0);
        } //如果删除前会话中有多个人，就退出会话。
        else {
            $uids = array_diff($uids, array("[$uid]"));
            $uids = implode(',', $uids);
            D('Talk')->where(array('id' => $talk_id))->save(array('uids' => $uids));
            D('Message')->where(array('talk_id' => $talk_id, 'uid' => get_uid()))->setField('talk_id', 0);
        }

        //返回成功结果
        $this->success('删除成功', 'refresh');
    }

    /**回复的时候调用，通过该函数，会回调应用对应的postMessage函数实现对原始内容的数据添加。
     * @param $content 内容文本
     * @param $talk_id 会话ID
     */
    public function postMessage($content, $talk_id)
    {
        //空的内容不能发送
        if (!trim($content)) {
            $this->error('内容不能为空');
        }

        D('TalkMessage')->addMessage($content, is_login(), $talk_id);
        $talk = D('Talk')->find($talk_id);
        $message = D('Message')->find($talk['message_id']);
        $messageModel = $this->getMessageModel($message);
        $rs = $messageModel->postMessage($message, $talk, $content, is_login());

        D('TalkMessage')->sendMessage($content, $this->mTalkModel->getUids($talk['uids']), $talk_id);
        if (!$rs) {
            $this->error('写入数据库错误');
        }

        $this->success("发送成功");
    }

    /**
     * @param $message
     * @return \Model
     */
    private function getMessageModel($message)
    {

        $appname = ucwords($message['appname']);
        $messageModel = D($appname . '/' . $appname . 'Message');
        return $messageModel;
    }

    /**
     * @param $message_id
     * @param $talk_id
     * @param $map
     * @return array
     */
    private function getTalk($message_id, $talk_id)
    {
        if ($message_id != 0) {
            /*如果是传递了message_id，就是创建对话*/
            $message = D('Message')->find($message_id);

            //权限检测，防止越权创建会话
            if (($message['to_uid'] != $this->mid && $message['from_uid'] != $this->mid) || !$message) {
                $this->error('非法操作。');
            }

            //如果已经创建过会话了，就不再创建
            $map['message_id'] = $message_id;
            $map['status'] = 1;
            $talk = D('Talk')->where($map)->find();
            if ($talk) {
                redirect(U('UserCenter/Message/talk', array('talk_id' => $talk['id'])));
            }


            $memeber = $message['from_uid'];


            //TODO 调用模型创建会话
            D('Common/Talk')->createTalk($memeber, $message);
            $messageModel = $this->getMessageModel($message);


            //关联会话到当前消息
            $message['talk_id'] = $talk['id'];
            D('Message')->save($message);

            //插入第一条消息
            $talkMessage['uid'] = $message['from_uid'];
            $talkMessage['talk_id'] = $talk['id'];
            $talkMessage['content'] = $messageModel->getFindContent($message);
            $talkMessageModel = D('TalkMessage');
            $talkMessage = $talkMessageModel->create($talkMessage);
            $talkMessage['id'] = $talkMessageModel->add($talkMessage);


            D('Message')->sendMessage($message['from_uid'], '会话名称：' . $talk['title'], '您有新的主题会话', U('UserCenter/Message/talk', array('talk_id' => $talk['id'])), is_login(), 0);

            return $talk;

        } else {
            $talk = D('Talk')->find($talk_id);
            $uids_array = $this->mTalkModel->getUids($talk['uids']);
            if (!count($uids_array)) {
                $this->error('越权操作。');
                return $talk;
            }
            return $talk;
        }
    }

    /**
     * @param $tab
     * @param $map
     * @return mixed
     */
    private function getMapByTab($tab, $map)
    {
        switch ($tab) {
            case 'system':
                $map['type'] = 0;
                break;
            case 'user':
                $map['type'] = 1;
                break;
            case 'app':
                $map['type'] = 2;
                break;
            case 'all':
                break;
            default:
                $map['is_read'] = 0;
                break;
        }
        return $map;
    }

    /**创建会话，
     * @auth 陈一枭
     */
    public function createTalk($uids='')
    {
        if($uids==''){
            exit;
        }
        $memebers = explode(',', $uids);
        $talk = D('Common/Talk')->createTalk($memebers);
        echo json_encode($talk);
    }

}