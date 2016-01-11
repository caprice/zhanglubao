<?php
namespace Team\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class ForumHotPostWidget extends Action
{

    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($forum_id)
    {
        $forum_id=intval($forum_id);
        $posts = S('forum_hot_posts_' . $forum_id);

        $map['status']=1;
        $time=time()-604800;//一周以内
        $map['create_time']=array('gt',$time);
        if (empty($posts)) {
            if ($forum_id == 0) {
                $posts = D('ForumPost')->where($map)->order('reply_count desc')->limit(9)->select();
            } else {
                $map['forum_id']=$forum_id;

                $posts = D('ForumPost')->where($map)->order('reply_count desc')->limit(9)->select();
            }
            S('forum_hot_posts_' . $forum_id, $posts, 300);
        }

        $this->assign('posts', $posts);
        $this->display('Widget/Forum/hot');

    }

}
