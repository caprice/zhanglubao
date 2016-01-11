<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 14-3-19
 * Time: 下午2:19
 */
namespace Addons\Support\Controller;

use Home\Controller\AddonsController;

class SupportController extends AddonsController
{


    /*
     *签到
     */

    public function doSupport()
    {
        if (!is_login()) {
            exit(json_encode(array('status' => 0, 'info' => '请登陆后再点赞。')));
        }
        $appname = I('POST.appname');
        $table = I('POST.table');
        $row = I('POST.row');
        $message_uid = I('POST.uid');
        $support['appname'] = $appname;
        $support['table'] = $table;
        $support['row'] = $row;
        $support['uid'] = is_login();

        if (D('Support')->where($support)->count()) {

            exit(json_encode(array('status' => 0, 'info' => '您已经赞过，不能再赞了。')));
        } else {
            $support['create_time'] = time();
            if (D('Support')->where($support)->add($support)) {
                $user = query_user(array('username'));
                if (I('POST.jump') == 'no') {
                    $jump = $_SERVER['HTTP_REFERER']; //如果设置了jump=no，则默认使用引用页
                } else {
                    $jump = U($appname . '/Index/' . $table . 'Detail', array('id' => $row));//否则按照约定规则组合消息跳转页面。
                }
                D('Message')->sendMessage($message_uid, $user['username'] . '给您点了个赞。', $title = '收到一个赞', $jump, is_login());
                exit(json_encode(array('status' => 1, 'info' => '感谢您的支持。')));
            } else {
                exit(json_encode(array('status' => 0, 'info' => '写入数据库失败。')));
            }

        }
    }
}

