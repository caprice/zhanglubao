<?php
 

namespace Usercenter\Controller;


use Think\Controller;

class PublicController extends Controller
{
    /**获取个人资料，用以支持小名片
     * @auth 陈一枭
     */
    public function getProfile()
    {
        $uid = intval($_REQUEST['uid']);
        $userProfile = query_user(array('uid', 'username', 'avatar', 'space_url', 'following', 'fans', 'weibocount', 'signature', 'rank_link'), $uid);
        $follow['follow_who'] = $userProfile['uid'];
        $follow['who_follow'] = is_login();
        $userProfile['followed'] = D('Follow')->where($follow)->count();
        $userProfile['following_url'] = U('Usercenter/Index/following', array('uid' => $uid));
        $userProfile['fans_url'] = U('Usercenter/Index/fans', array('uid' => $uid));
        $userProfile['weibo_url'] = U('Usercenter/Index/appList', array('uid' => $uid, 'type' => "weibo"));
        $html = '';
        if (count($userProfile['rank_link'])) {
            foreach ($userProfile['rank_link'] as $val) {
                if ($val['is_show']) {
                    $html = $html . '<img class="img-responsive" src="' . $val['logo_url'] . '" title="' . $val['title'] . '" alt="' . $val['title'] . '" style="width: 18px;height: 18px;vertical-align: middle;margin-left: 3px;display: inline;"/>';
                }
            }
            unset($val);
        }
        $userProfile['rank_link']=$html;
        echo json_encode($userProfile);
    }

    /**关注某人
     * @param int $uid
     * @auth 陈一枭
     */
    public function follow($uid = 0)
    {

        if (D('Follow')->follow($uid)) {
            $this->ajaxReturn(array('status' => 1));
        } else {
            $this->ajaxReturn(array('status' => 0));
        }
    }

    /**取消对某人的关注
     * @param int $uid
     * @auth 陈一枭
     */
    public function unfollow($uid = 0)
    {
        if (D('Follow')->unfollow($uid)) {
            $this->ajaxReturn(array('status' => 1));
        } else {
            $this->ajaxReturn(array('status' => 0));
        }
    }


    /**检测消息
     * 返回新会话状态和系统的消息
     * @auth 陈一枭
     */
    public function getInformation()
    {

        $message = D('Common/Message');
        //取到所有没有提示过的信息
        $haventToastMessages = $message->getHaventToastMessage(is_login());

        $message->setAllToasted(is_login()); //消息中心推送

        $new_talks = D('TalkPush')->getAllPush(); //会话推送
        D('TalkPush')->where(array('uid' => get_uid(), 'status' => 0))->setField('status', 1); //读取到推送之后，自动删除此推送来防止反复推送。

        $new_talk_messages = D('TalkMessagePush')->getAllPush(); //会话消息推送
        D('TalkMessagePush')->where(array('uid' => get_uid(), 'status' => 0))->setField('status', 1); //读取到推送之后，自动删除此推送来防止反复推送。

        foreach($new_talk_messages as &$message){
            $message=D('TalkMessage')->find($message['source_id']);
            $message['user'] = query_user(array('avatar64', 'uid', 'username'), $message['uid']);
            $message['ctime'] = date('m-d h:i', $message['create_time']);
            $message['avatar64'] = $message['user']['avatar64'];
        }
        exit(json_encode(array('messages' => $haventToastMessages, 'new_talk_messages' => $new_talk_messages, 'new_talks' => $new_talks)));
    }

    /**设置全部的系统消息为已读
     * @auth 陈一枭
     */
    public function setAllMessageReaded()
    {
        D('Message')->setAllReaded(is_login());
    }

    /**设置某条系统消息为已读
     * @param $message_id
     * @auth 陈一枭
     */
    public function readMessage($message_id)
    {
        exit(json_encode(array('status' => D('Common/Message')->readMessage($message_id))));

    }
}