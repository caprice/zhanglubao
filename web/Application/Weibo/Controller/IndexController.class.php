<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 14-3-10
 * Time: PM9:14
 */

namespace Weibo\Controller;

use Think\Controller;
use Weibo\Api\WeiboApi;
use Think\Exception;
use Common\Exception\ApiException;

class IndexController extends Controller
{
    /**
     * 业务逻辑都放在 WeiboApi 中
     * @var
     */
    private $weiboApi;

    public function _initialize()
    {
        $this->weiboApi = new WeiboApi();
    }

    public function index($uid = 0, $page = 1, $lastId = 0)
    {
        //载入第一页微博
        if ($uid != 0) {
            $result = $this->weiboApi->listAllWeibo($page, null, array('uid' => $uid), 1, $lastId);
        } else {
            $result = $this->weiboApi->listAllWeibo($page, 0, '', 1, $lastId);
        }
        //显示页面
        $this->assign('list', $result['list']);
        $this->assign('lastId', $result['lastId']);
        $this->assign('page', $page);
        $this->assign('tab', 'all');
        $this->assign('loadMoreUrl', U('loadWeibo', array('uid' => $uid)));
        $total_count = $this->weiboApi->listAllWeiboCount();

        $this->assign('total_count', $total_count['total_count']);

        $this->assign('tox_money_name', getToxMoneyName());
        $this->assign('tox_money', getMyToxMoney());
        $this->setTitle('全站关注——微博');
        $this->assign('filter_tab', '全站动态');
        $this->assignSelf();
        $this->display();
    }

    public function search($uid = 0, $page = 1, $lastId = 0){
        $keywords = op_t($_REQUEST['keywords']);
        if(!isset($keywords)){
            $keywords='';
        }
        //载入第一页微博
        if ($uid != 0) {
            $result = $this->weiboApi->listAllWeibo($page, null, array('uid' => $uid), 1, $lastId,$keywords);
        } else {
            $result = $this->weiboApi->listAllWeibo($page, 0, '', 1, $lastId,$keywords);
        }
        //显示页面
        $this->assign('list', $result['list']);
        $this->assign('lastId', $result['lastId']);
        $this->assign('page', $page);
        $this->assign('tab', 'all');
        $this->assign('loadMoreUrl', U('loadWeibo', array('uid' => $uid,'keywords'=>$keywords)));
        if(isset($keywords)&&$keywords!=''){
            $map['content']=array('like', "%{$keywords}%");
        }
        $total_count = $this->weiboApi->listAllWeiboCount($map);

        $this->assign('key_words',$keywords);
        $this->assign('total_count', $total_count['total_count']);

        $this->assign('tox_money_name', getToxMoneyName());
        $this->assign('tox_money', getMyToxMoney());
        $this->setTitle('全站搜索微博');
        $this->assign('filter_tab', '全站动态');
        $this->assignSelf();
        $this->display();
    }

    public function myconcerned($uid = 0, $page = 1, $lastId = 0)
    {
        if($page == 1){
            $result = $this->weiboApi->listMyFollowingWeibo($page, null, '', 1, $lastId);
            $this->assign('lastId', $result['lastId']);
           $this->assign('list', $result['list']);
        }
        //载入我关注的微博


        $total_count = $this->weiboApi->listMyFollowingWeiboCount($page, 0, '', 1, $lastId);
        $this->assign('total_count', $total_count['total_count']);

        $this->assign('page', $page);

        //显示页面


        $this->assign('tab', 'concerned');
        $this->assign('loadMoreUrl', U('loadConcernedWeibo'));

        $this->assignSelf();
        $this->setTitle('我关注的——微博');
        $this->assign('filter_tab', '我关注的');


        $this->assign('tox_money_name', getToxMoneyName());
        $this->assign('tox_money', getMyToxMoney());
        $this->display('index');
    }

    public function weiboDetail($id)
    {
        //读取微博详情
        $result = $this->weiboApi->getWeiboDetail($id);

        //显示页面
        $this->assign('weibo', $result['weibo']);
        $this->assignSelf();

        $this->display();
    }

    public function sendrepost($sourseId, $weiboId)
    {


        $result = $this->weiboApi->getWeiboDetail($sourseId);
        $this->assign('soueseWeibo', $result['weibo']);

        if ($sourseId != $weiboId) {
            $weibo1 = $this->weiboApi->getWeiboDetail($weiboId);
            $weiboContent = '//@' . $weibo1['weibo']['user']['nickname'] . ' ：' . $weibo1['weibo']['content'];

        }
        $this->assign('weiboId', $weiboId);
        $this->assign('weiboContent', $weiboContent);
        $this->assign('sourseId', $sourseId);

        $this->display();
    }

    public function doSendRepost($content, $type, $sourseId, $weiboId, $becomment)
    {
        $feed_data = '';
        $sourse = $this->weiboApi->getWeiboDetail($sourseId);
        $sourseweibo = $sourse['weibo'];
        $feed_data['sourse'] = $sourseweibo;
        $feed_data['sourseId'] = $sourseId;
        //发送微博
        $result = $this->weiboApi->sendWeibo($content, $type, $feed_data);
        if ($result) {
            D('weibo')->where('id=' . $sourseId)->setInc('repost_count');
            $weiboId != $sourseId && D('weibo')->where('id=' . $weiboId)->setInc('repost_count');
        }

        $user = query_user(array('nickname'), is_login());
        $toUid = D('weibo')->where(array('id' => $weiboId))->getField('uid');
        D('Common/Message')->sendMessage($toUid, $user['nickname'] . '转发了您的微博！', '转发提醒', U('Weibo/Index/weiboDetail', array('id' => $result['weibo_id'])), is_login(), 1);


        if ($becomment == 'true') {
            $this->weiboApi->sendRepostComment($weiboId, $content);
        }
        //返回成功结果
        $this->ajaxReturn(apiToAjax($result));
    }

    public function loadWeibo($page = 1, $uid = 0, $loadCount = 1, $lastId = 0,$keywords='')
    {
        $count = 30;
        //载入全站微博
        if ($uid != 0) {
            $result = $this->weiboApi->listAllWeibo($page, $count, array('uid' => $uid), $loadCount, $lastId,$keywords);
        } else {
            $result = $this->weiboApi->listAllWeibo($page, $count, '', $loadCount, $lastId,$keywords);
        }
        //如果没有微博，则返回错误
        if (!$result['list']) {
            $this->error('没有更多了');
        }

        //返回html代码用于ajax显示
        $this->assign('list', $result['list']);
        $this->assign('lastId', $result['lastId']);
        $this->display();
    }

    public function loadConcernedWeibo($page = 1, $loadCount = 1, $lastId = 0)
    {

        $count = 30;
        //载入我关注的人的微博
        $result = $this->weiboApi->listMyFollowingWeibo($page, $count, '', $loadCount, $lastId);

        //如果没有微博，则返回错误
        if (!$result['list']) {
            $this->error('没有更多了');
        }

        //返回html代码用于ajax显示
        $this->assign('list', $result['list']);
        $this->assign('lastId', $result['lastId']);
        $this->display('loadweibo');
    }

    public function doSend($content, $type = 'feed', $attach_ids = '')
    {
        $feed_data = '';
        $feed_data['attach_ids'] = $attach_ids;

        //发送微博
        $result = $this->weiboApi->sendWeibo($content, $type, $feed_data);

        //返回成功结果
        $this->ajaxReturn(apiToAjax($result));
    }

    public function doComment($weibo_id, $content, $comment_id = 0)
    {
        //发送评论
        $result = $this->weiboApi->sendComment($weibo_id, $content, $comment_id);

        //返回成功结果
        $this->ajaxReturn(apiToAjax($result));
    }

    public function loadComment($weibo_id)
    {
        //读取数据库中全部的评论列表
        $result = $this->weiboApi->listComment($weibo_id, 1, 10000);
        $list = $result['list'];
        $weiboCommentTotalCount = count($list);

        $result1 = $this->weiboApi->listComment($weibo_id, 1, 5);
        $list1 = $result1['list'];
        //返回html代码用于ajax显示
        $this->assign('list', $list1);
        $this->assign('weiboId', $weibo_id);
        $weobo = $this->weiboApi->getWeiboDetail($weibo_id);
        $this->assign('weibo', $weobo['weibo']);
        $this->assign('weiboCommentTotalCount', $weiboCommentTotalCount);
        $this->display();
    }

    public function commentlist($weibo_id, $page = 1)
    {

        $result = $this->weiboApi->listComment($weibo_id, $page, 10000);
        $list = $result['list'];
        $this->assign('list', $list);
        $html = $this->fetch('commentlist');
        $this->ajaxReturn($html);
        dump($html);

    }

    public function doDelWeibo($weibo_id = 0)
    {
        //删除微博
        $result = $this->weiboApi->deleteWeibo($weibo_id);

        //返回成功信息
        $this->ajaxReturn(apiToAjax($result));
    }

    public function doDelComment($comment_id = 0)
    {
        //删除评论
        $result = $this->weiboApi->deleteComment($comment_id);

        //返回成功信息
        $this->ajaxReturn(apiToAjax($result));
    }

    public function atWhoJson()
    {
        exit(json_encode($this->getAtWhoUsersCached()));
    }

    /**
     * 获取表情列表。
     */
    public function getSmile()
    {
        //这段代码不是测试代码，请勿删除
        exit(json_encode(D('Expression')->getAllExpression()));
    }

    private function getAtWhoUsers()
    {
        //获取能AT的人，UID列表
        $uid = get_uid();
        $follows = D('Follow')->where(array('who_follow' => $uid, 'follow_who' => $uid, '_logic' => 'or'))->limit(999)->select();
        $uids = array();
        foreach ($follows as &$e) {
            $uids[] = $e['who_follow'];
            $uids[] = $e['follow_who'];
        }
        unset($e);
        $uids = array_unique($uids);

        //加入拼音检索
        $users = array();
        foreach ($uids as $uid) {
            $user = query_user(array('nickname', 'id', 'avatar32'), $uid);
            $user['search_key'] = $user['nickname'] . D('PinYin')->Pinyin($user['nickname']);
            $users[] = $user;
        }

        //返回at用户列表
        return $users;
    }

    private function getAtWhoUsersCached()
    {
        $cacheKey = 'weibo_at_who_users_' . get_uid();
        $atusers = S($cacheKey);
        if (empty($atusers)) {
            $atusers = $this->getAtWhoUsers();
            S($cacheKey, $atusers, 600);
        }
        return $atusers;
    }

    private function assignSelf()
    {
        $self = query_user(array('avatar128', 'nickname', 'uid', 'space_url', 'icons_html', 'score', 'title', 'fans', 'following', 'weibocount', 'rank_link'));
        $this->assign('self', $self);
    }
}