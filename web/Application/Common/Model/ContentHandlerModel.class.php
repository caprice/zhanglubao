<?php

namespace Common\Model;


/**内容处理模型，专门用于预处理各类文本
 * Class ContentHandlerModel
 * @package Common\Model
 * @auth 陈一枭
 */
class ContentHandlerModel {

    /**处理@
     * @auth 陈一枭
     */
    public function handleAtWho($content,$url='',$app_name=''){
        $uids = get_at_uids($content);

        $uids = array_unique($uids);
        $sender=query_user(array('username'));
        foreach ($uids as $uid) {
            //$user = D('User/UcenterMember')->find($uid);
            $title = $sender['username'] . '@了您';
            $message = '评论内容：' . mb_substr(op_t( $content),0,50,'utf-8');
            if($url==''){//如果未设置来源的url，则自动跳转到来源页面
                $url = $_SERVER['HTTP_REFERER'];
            }

            D('Common/Message')->sendMessage($uid, $message, $title, $url, get_uid(), 0, $app_name);
        }
    }
} 