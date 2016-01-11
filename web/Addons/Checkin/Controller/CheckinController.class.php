<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 14-3-19
 * Time: 下午2:19
 */
namespace Addons\Checkin\Controller;
use Home\Controller\AddonsController;

class CheckinController extends AddonsController{

   public function render($data)
    {
      /*  $uid = is_login();

        $data = model('Cache')->get('check_info_' . $uid . '_' . date('Ymd'));  //s('check_info');
       //dump($data);exit;
        if (!$data) {
            $map['uid'] = $uid;
            $map['ctime'] = array('gt', strtotime(date('Ymd')));
            $res = D('Check_info')->where($map)->find();
            //是否签到
            $data['ischeck'] = $res ? true : false;



            $checkinfo = D('Check_info')->where('uid=' . $uid)->order('ctime desc')->limit(1)->find();

            if ($checkinfo) {
                if ($checkinfo['ctime'] > (strtotime(date('Ymd')) - 86400)) {
                    $data['con_num'] = $checkinfo['con_num'];
                } else {
                    $data['con_num'] = 0;
                }
                $data['total_num'] = $checkinfo['total_num'];
            } else {
                $data['con_num'] = 0;
                $data['total_num'] = 0;
            }
            $data['day'] = date('m.d');
           model('Cache')->set('check_info_' . $uid . '_' . date('Ymd'), $data);
        }

        $data['tpl'] = 'index';
        $week = date('w');
        switch ($week) {
            case '0':
                $week = '周日';
                break;
            case '1':
                $week = '周一';
                break;
            case '2':
                $week = '周二';
                break;
            case '3':
                $week = '周三';
                break;
            case '4':
                $week = '周四';
                break;
            case '5':
                $week = '周五';
                break;
            case '6':
                $week = '周六';
                break;
        }
        $data['week'] = $week;
        //$content = $this->renderFile(dirname(__FILE__) . "/" . $data['tpl'] . '.html', $data);
       // return $content;
            $this->assign("check",$data);
            $this-display('View/checkin');*/


    }

    /*
     *签到
     */
    public function check_in()
    {


        $uid =is_login();


        $map['ctime'] = array('gt', strtotime(date('Ymd')));
        $map['uid'] = $uid;
        $ischeck = D('Check_info')->where($map)->find();

        //是否重复签到
       // dump($ischeck);exit;

        if (!$ischeck) {
            $map['ctime'] = array('lt', strtotime(date('Ymd')));
            $last = D('Check_info')->where($map)->order('ctime desc')->find();
            $data['uid'] = $uid;
            $data['ctime'] = $_SERVER['REQUEST_TIME'];
           //是否有签到记录
            if ($last) {
                //是否是连续签到
                if ($last['ctime'] > (strtotime(date('Ymd')) -86400)) {
                    $data['con_num'] = $last['con_num'] + 1;
                } else {
                    $data['con_num'] = 1;
                }
                $data['total_num'] = $last['total_num'] + 1;
            } else {
                $data['con_num'] = 1;
                $data['total_num'] = 1;
            }
            if (D('Check_info')->add($data)) {
                //更新连续签到和累计签到的数据
                $connum = D('User_cdata')->where('uid=' . $uid . " and `key`='check_connum'")->find();
                if ($connum) {
                    $connum = D('Check_info')->where('uid=' . $uid)->getField('max(con_num)');
                    D('User_cdata')->setField('value', $connum, "`key`='check_connum' and uid=" . $uid);
                    D('User_cdata')->setField('value', $data['total_num'], "`key`='check_totalnum' and uid=" . $uid);

                } else {
                    $connumdata['uid'] = $uid;
                    $connumdata['value'] = $data['con_num'];
                    $connumdata['key'] = 'check_connum';
                    D('User_cdata')->add($connumdata);

                    $totalnumdata['uid'] = $uid;
                    $totalnumdata['value'] = $data['total_num'];
                    $totalnumdata['key'] = 'check_totalnum';
                    D('User_cdata')->add($totalnumdata);
                }
                echo $data['con_num'];
            }
        }

      /*  $list = D('Check_info')->group('uid')->findAll();
        foreach ( $list as $v ){
            $con = D('User_cdata')->where('uid='.$v['uid']." and `key`='check_connum'")->find();

            $connum = D('Check_info')->where('uid='.$v['uid'])->getField('max(con_num)');
            $totalnum = D('Check_info')->where('uid='.$v['uid'])->getField('max(total_num)');
            if ( !$con ){

                $connumdata['uid'] = $v['uid'];
                $connumdata['value'] = $connum;
                $connumdata['key'] = 'check_connum';
                D('User_cdata')->add($connumdata);

                $totalnumdata['uid'] = $v['uid'];
                $totalnumdata['value'] = $totalnum;
                $totalnumdata['key'] = 'check_totalnum';
                D('User_cdata')->add($totalnumdata);
            } else {
                D('User_cdata')->setField('value' , $connum , "`key`='check_connum' and uid=".$v['uid']);

                D('User_cdata')->setField('value' , $totalnum , "`key`='check_totalnum' and uid=".$v['uid']);
            }
        }*/

    }

    }




      /*  public function update_user_data(){
    $list = D('Check_info')->group('uid')->findAll();
        foreach ( $list as $v ){
            $con = D('User_cdata')->where('uid='.$v['uid']." and `key`='check_connum'")->find();

            $connum = D('Check_info')->where('uid='.$v['uid'])->getField('max(con_num)');
            $totalnum = D('Check_info')->where('uid='.$v['uid'])->getField('max(total_num)');
            if ( !$con ){

                $connumdata['uid'] = $v['uid'];
                $connumdata['value'] = $connum;
                $connumdata['key'] = 'check_connum';
                D('User_cdata')->add($connumdata);

                $totalnumdata['uid'] = $v['uid'];
                $totalnumdata['value'] = $totalnum;
                $totalnumdata['key'] = 'check_totalnum';
                D('User_cdata')->add($totalnumdata);
            } else {
                D('User_cdata')->setField('value' , $connum , "`key`='check_connum' and uid=".$v['uid']);

                D('User_cdata')->setField('value' , $totalnum , "`key`='check_totalnum' and uid=".$v['uid']);
            }
        }
    }
}*/

