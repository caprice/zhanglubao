<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 14-3-10
 * Time: PM9:01
 */

namespace Weibo\Model;

use Think\Model;

class WeiboCommentModel extends Model
{
    protected $_validate = array(
        array('content', '1,99999', '内容不能为空', self::EXISTS_VALIDATE, 'length'),
        array('content', '0,500', '内容太长', self::EXISTS_VALIDATE, 'length'),
    );

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );

    public function addComment($uid, $weibo_id, $content, $comment_id = 0)
    {
        //写入数据库
        $data = array('uid' => $uid, 'content' => $content, 'weibo_id' => $weibo_id, 'comment_id' => $comment_id);
        $data = $this->create($data);
        if (!$data) return false;
        $comment_id = $this->add($data);

        //增加微博评论数量
        D('Weibo/Weibo')->where(array('id' => $weibo_id))->setInc('comment_count');

        //返回评论编号
        return $comment_id;
    }

    public function deleteComment($comment_id)
    {
        //获取微博编号
        $comment = D('Weibo/WeiboComment')->find($comment_id);
        $weibo_id = $comment['weibo_id'];

        //将评论标记为已经删除
        D('Weibo/WeiboComment')->where(array('id' => $comment_id))->setField('status', -1);

        //减少微博的评论数量
        D('Weibo/Weibo')->where(array('id' => $weibo_id))->setDec('comment_count');

        //返回成功结果
        return true;
//
//
//        $content = htmlspecialchars($content);
//        $self = query_user(array('username')); //超找自己
//        $user_math = match_users($content);
//
//
//        //将评论内容写入数据库
//        $data = array('uid' => $uid, 'weibo_id' => $weibo_id, 'content' => $content, 'comment_id' => $comment_id);
//
//        $data = $this->create($data);
//
//        if (!$data) return false;
//        $result = $this->add($data);
//
//        action_log('add_weibo_comment', 'WeiboComment', $result, is_login());
//
//        if ($result) {
//            $data['id'] = $result;
//            $data['content']= $this->sendAllAtMessages($content, $user_math, $self, $weibo_id);
//            $this->save($data);
//        }
//
//
//        $this->sendCommentMessage($uid, $weibo_id, $content);
//        if ($comment_id != 0) {
//            $this->sendCommentReplyMessage($uid, $comment_id, $content);
//        }
//
//        //增加微博的评论数量
//        D('Weibo')->where(array('id' => $weibo_id))->setInc('comment_count');
//
//        //返回评论编号
//        return $result;
    }
//
//    /**
//     * @param $uid
//     * @param $weibo_id
//     * @param $content
//     */
//    private function sendCommentMessage($uid, $weibo_id, $content)
//    {
////
////        $user = query_user(array('username', 'space_url'), $uid);
////
////        $title = $user['username'] . '评论了您的微博。';
////        $content = '评论内容：' . $content;
////
////        $weibo = D('Weibo')->find($weibo_id);
////        $url = U('Weibo/Index/weiboDetail', array('id' => $weibo_id));
////        $from_uid = $uid;
////        $type = 2;
////        D('Message')->sendMessage($weibo['uid'], $content, $title, $url, $from_uid, $type);
//    }
//
//    /**
//     * @param $uid
//     * @param $weibo_id
//     * @param $content
//     */
//    private function sendCommentReplyMessage($uid, $comment_id, $content)
//    {
////
////        $user = query_user(array('username', 'space_url'), $uid);
////
////        $title = $user['username'] . '回复了您的微博评论。';
////        $content = '回复内容：' . $content;
////
////
////        $comment = $this->find($comment_id);
////        $url = U('Weibo/Index/weiboDetail', array('id' => $comment['weibo_id']));
////        $from_uid = $uid;
////        $type = 2;
////        D('Message')->sendMessage($comment['uid'], $content, $title, $url, $from_uid, $type);
//    }
//
//
//    /**
//     * @param $content
//     * @param $user_math
//     * @param $self
//     * @return mixed
//     */
//    private function sendAllAtMessages($content, $user_math, $self, $weibo_id)
//    {
//        foreach ($user_math[1] as $match) {
//            $map['username'] = $match;
//            $user = D('ucenter_member')->where($map)->find();
//            if ($user) {
//                $query_user = query_user(array('username', 'space_url'), $user['id']);
//                $content = str_replace('@' . $match . ' ', '<a ucard="' . $user['id'] . '" href="' . $query_user['space_url'] . '">@' . $match . ' </a>', $content);
//            }
//            /**
//             * @param $to_uid 接受消息的用户ID
//             * @param string $content 内容
//             * @param string $title 标题，默认为  您有新的消息
//             * @param $url 链接地址，不提供则默认进入消息中心
//             * @param $int $from_uid 发起消息的用户，根据用户自动确定左侧图标，如果为用户，则左侧显示头像
//             * @param int $type 消息类型，0系统，1用户，2应用
//             */
//            D('Message')->sendMessage($user['id'], '微博内容：' . $content, $title = $self['username'] . '在微博的评论中@了您', U('Weibo/Index/weiboDetail', array('id' => $weibo_id)), is_login(), 1);
//        }
//        return $content;
//    }
}