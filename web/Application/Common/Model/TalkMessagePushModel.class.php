<?php
 
namespace Common\Model;

use Think\Model;
class TalkMessagePushModel extends Model{

    /**取得全部的推送消息
     * @return mixed
     * @auth 陈一枭
     */
    public function getAllPush(){
        $new_talks=$this->where(array('uid'=>get_uid(),'status'=>0))->select();

        foreach($new_talks as &$v){

            $message=D('TalkMessage')->find($v['source_id']);
            //$talk=D('Talk')->find($message['talk_id']);
            $v['talk_message']=$message;
        }
        unset($v);
        return $new_talks;
    }
}