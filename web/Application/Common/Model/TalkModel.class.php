<?php
 
namespace Common\Model;

use Think\Model;

class TalkModel extends Model
{
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_INSERT),
    );

    /**自动匹配出用户
     * @param $uids
     * @return mixed
     * @auth 陈一枭
     */
    public function getUids($uids)
    {
        preg_match_all('/\[(.*?)\]/', $uids, $uids_array);
        return $uids_array[1];
    }

    /**获取当前存在的消息
     * @return mixed
     * @auth 陈一枭
     */
    public function getCurrentSessions()
    {
        //每次获取到所有的id，就对这些做delete处理。防止反复提示。
        $new_talks=D('TalkPush')->where(array('uid'=>get_uid(),'status'=>array('NEQ',-1)))->select();
        $new_ids = array();
        foreach ($new_talks as $push) {
            D('TalkPush')->where(array('id' => $push['id']))->setField('status', 1);//全部置为已提示
            $new_ids[] = $push['source_id'];
        }


        //每次获取到所有的id，就对这些做delete处理。防止反复提示。
        $new_talk_messages=D('TalkMessagePush')->where(array('uid'=>get_uid(),'status'=>array('NEQ',-1)))->select();
        foreach ($new_talk_messages as $v) {
            D('TalkMessagePush')->where(array('id' => $v['id']))->setField('status', 1);//全部置为已提示
           $message= D('TalkMessage')->find($v['source_id']);
            if(!in_array($message['talk_id'],$new_ids)){
                $new_ids[]=$message['talk_id'];
            };
        }

        $list = $this->where('uids like' . '"%[' . is_login() . ']%"' . ' and status=1')->order('update_time desc')->select();
        foreach ($list as $key => &$li) {

            $li = $this->getFirstUserAndLastMessage($li);
            if (in_array($li['id'], $new_ids)) {
                $list[$key]['new'] = 1;
            }
        }
        unset($li);
        return $list;
    }

    /**获取最后一条消息
     * @param $talk_id
     * @return mixed
     * @auth 陈一枭
     */
    public function getLastMessage($talk_id)
    {
        $last_message = D('TalkMessage')->where('talk_id=' . $talk_id)->order('create_time desc')->find();
        $last_message['user'] = query_user(array('nickname', 'space_url', 'id'), $last_message['uid']);
        $last_message['content'] = op_t($last_message['content']);
        return $last_message;
    }

    /**创建会话
     * @param        $members
     * @param string $message
     * @return array
     * @auth 陈一枭
     */
    public function createTalk($members, $message = '')
    {


        $orin_member = $members;
        if (is_array($members)) {
            $members[] = is_login();
            $ico_user = $this->getFirstOtherUser($members);
            $members = $this->encodeArrayByRec($members);
            $talk['uids'] = implode(',', $members);
        } else {
            /*创建talk*/
            $talk['uids'] = implode(',', array('[' . is_login() . ']', '[' . $members . ']'));

        }
        if ($message != '') {
            $talk['appname'] = $message['appname'];
            $talk['apptype'] = $message['apptype'];
            $talk['source_id'] = $message['source_id'];
            $talk['message_id'] = $message['id'];
            //通过消息获取到对应应用内的消息模型
            $messageModel = $this->getMessageModel($message);
            //从对应模型内取回对话源资料
            $talk = array_merge($messageModel->getSource($message), $talk);
        } else {
            if (count($orin_member) == 1) {
                $user_one = query_user(array('nickname'), $orin_member[0]);
                $user_two = query_user(array('nickname'));
                $talk['title'] = $user_one['nickname'] . ' 和 ' . $user_two['nickname'] . '的会话';
            }
        }


        //创建会话
        $talk = D('Talk')->create($talk);
        $talk['id'] = D('Talk')->add($talk);

        foreach ($orin_member as $mem) {
            if ($mem != is_login()) {
                //不是自己则建立一个push
                $push['uid'] = $mem;
                $push['source_id'] = $talk['id'];
                $push['create_time'] = time();
                D('TalkPush')->add($push);
            }
        }



        //获取图标用于输出
        $talk['ico'] = $ico_user['avatar64'];
        return $talk;
        /*创建talk end*/

    }

    /**获取来源应用对应的消息模型
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
     * @param $li
     * @return mixed
     * @auth 陈一枭
     */
    private function getFirstUserAndLastMessage($li)
    {
        $uids = $this->getUids($li['uids']);
        foreach ($uids as $uid) {
            if ($uid != is_login()) {
                $li['first_user'] = query_user(array('avatar64', 'nickname'), $uid);
                break;
            }
            $li['last_message'] = $this->getLastMessage($li['id']);
        }
        return $li;
    }

    /**获取第一个非自己的用户
     * @param $members
     * @return array|null
     * @auth 陈一枭
     */
    public function getFirstOtherUser($members)
    {
        $has_got_ico = false;
        foreach ($members as &$mem) {
            if ($mem != is_login() && $has_got_ico == false) {
                $ico_user = query_user(array('avatar64', 'nickname'), $mem);
                $has_got_ico = true;
            }
        }
        unset($mem);
        return $ico_user;
    }

    public function encodeArrayByRec($members)
    {
        foreach ($members as &$mem) {
            $mem = '[' . $mem . ']';
        }
        unset($mem);
        return $members;
    }

    public function decodeArrayByRec($members)
    {
        foreach ($members as &$mem) {
            $mem = str_replace('[', '', $mem);
            $mem = str_replace(']', '', $mem);
        }
        unset($mem);
        return $members;
    }
}