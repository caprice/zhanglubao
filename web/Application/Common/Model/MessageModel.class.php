<?php
 
namespace Common\Model;

use Think\Model;

class MessageModel extends Model
{
    /**获取全部没有提示过的消息
     * @param $uid 用户ID
     * @return mixed
     */
    public function getHaventToastMessage($uid)
    {
        $messages = D('message')->where('to_uid=' . $uid . ' and  is_read=0  and last_toast=0')->order('id desc')->limit(99999)->select();
        foreach ($messages as &$v) {
            $v['ctime'] = friendlyDate($v['create_time']);
            $v['content'] = op_t($v['content']);
        }
        unset($v);
        return $messages;
    }

    /**设置全部未提醒过的消息为已提醒
     * @param $uid
     */
    public function setAllToasted($uid)
    {
        $now = time();
        D('message')->where('to_uid=' . $uid . ' and  is_read=0 and last_toast=0')->setField('last_toast', $now);
    }

    public function setAllReaded($uid)
    {
        D('message')->where('to_uid=' . $uid . ' and  is_read=0')->setField('is_read', 1);
    }


    /**取回全部未读信息
     * @param $uid
     * @return mixed
     */
    public function getHaventReadMeassage($uid, $is_toast = 0)
    {
        $messages = D('message')->where('to_uid=' . $uid . ' and  is_read=0 ')->order('id desc')->limit(99999)->select();
        foreach ($messages as &$v) {
            $v['ctime'] = friendlyDate($v['create_time']);
            $v['content'] = op_t($v['content']);
        }
        unset($v);
        return $messages;
    }

    /**取回全部未读,也没有提示过的信息
     * @param $uid
     * @return mixed
     */
    public function getHaventReadMeassageAndToasted($uid)
    {
        $messages = D('message')->where('to_uid=' . $uid . ' and  is_read=0  and last_toast!=0')->order('id desc')->limit(99999)->select();
        foreach ($messages as &$v) {
            $v['ctime'] = friendlyDate($v['create_time']);
            $v['content'] = op_t($v['content']);
        }
        unset($v);
        return $messages;
    }


    /**
     * @param $to_uid 接受消息的用户ID
     * @param string $content 内容
     * @param string $title 标题，默认为  您有新的消息
     * @param $url 链接地址，不提供则默认进入消息中心
     * @param $int $from_uid 发起消息的用户，根据用户自动确定左侧图标，如果为用户，则左侧显示头像
     * @param int $type 消息类型，0系统，1用户，2应用
     */
    public function sendMessage($to_uid, $content = '', $title = '您有新的消息', $url, $from_uid = 0, $type = 0, $appname = '', $apptype = '', $source_id = 0, $find_id = 0)
    {
        if ($to_uid == is_login()) {
            return 0;
        }
        $this->sendMessageWithoutCheckSelf($to_uid, $content, $title, $url, $from_uid, $type, $appname, $apptype, $source_id, $find_id);
    }

    /**
     * @param $to_uid 接受消息的用户ID
     * @param string $content 内容
     * @param string $title 标题，默认为  您有新的消息
     * @param $url 链接地址，不提供则默认进入消息中心
     * @param $int $from_uid 发起消息的用户，根据用户自动确定左侧图标，如果为用户，则左侧显示头像
     * @param int $type 消息类型，0系统，1用户，2应用
     */
    public function sendMessageWithoutCheckSelf($to_uid, $content = '', $title = '您有新的消息', $url, $from_uid = 0, $type = 0, $appname = '', $apptype = '', $source_id = 0, $find_id = 0)
    {
        $message['to_uid'] = $to_uid;
        $message['content'] = op_t($content);
        $message['title'] = $title;
        $message['url'] = $url;
        $message['from_uid'] = $from_uid;
        $message['type'] = $type;
        $message['create_time'] = time();
        $message['appname'] = $appname == '' ? strtolower(MODULE_NAME) : $appname;
        $message['source_id'] = $source_id;
        $message['apptype'] = $apptype;
        $message['find_id'] = $find_id;

        $rs = $this->add($message);
        return $rs;
    }

    public function readMessage($message_id)
    {
        return $this->where(array('id' => $message_id))->setField('is_read', 1);
    }
} 