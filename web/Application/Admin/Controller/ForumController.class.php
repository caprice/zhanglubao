<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 14-3-11
 * Time: PM5:41
 */

namespace Admin\Controller;
use Admin\Builder\AdminListBuilder;
use Admin\Builder\AdminConfigBuilder;
use Admin\Builder\AdminSortBuilder;

class ForumController extends AdminController {

    public function index() {
        redirect(U('forum'));
    }

    public function forum($page=1,$r=20) {
        //读取数据
        $map = array('status'=>array('GT',-1));
        $model = M('Forum');
        $list = $model->where($map)->page($page, $r)->order('sort asc')->select();
        $totalCount = $model->where($map)->count();

        //显示页面
        $builder = new AdminListBuilder();
        $builder
            ->title('板块管理')
            ->buttonNew(U('Forum/editForum'))
            ->setStatusUrl(U('Forum/setForumStatus'))->buttonEnable()->buttonDisable()->buttonDelete()
            ->buttonSort(U('Forum/sortForum'))
            ->keyId()->keyLink('title', '标题', 'Forum/post?forum_id=###')
            ->keyCreateTime()->keyText('post_count', '帖子数量')->keyStatus()->keyDoActionEdit('editForum?id=###')
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function forumTrash($page=1,$r=20) {
        //读取回收站中的数据
        $map = array('status'=>'-1');
        $model = M('Forum');
        $list = $model->where($map)->page($page, $r)->order('sort asc')->select();
        $totalCount = $model->where($map)->count();

        //显示页面
        $builder = new AdminListBuilder();
        $builder
            ->title('板块回收站')
            ->setStatusUrl(U('Forum/setForumStatus'))->buttonRestore()
            ->keyId()->keyLink('title', '标题', 'Forum/post?forum_id=###')
            ->keyCreateTime()->keyText('post_count', '帖子数量')
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function sortForum() {
        //读取贴吧列表
        $list = M('Forum')->where(array('status'=>array('EGT',0)))->order('sort asc')->select();

        //显示页面
        $builder = new AdminSortBuilder();
        $builder->title('贴吧排序')
            ->data($list)
            ->buttonSubmit(U('doSortForum'))->buttonBack()
            ->display();
    }

    public function setForumStatus($ids, $status) {
        $builder = new AdminListBuilder();
        $builder->doSetStatus('Forum', $ids, $status);
    }

    public function doSortForum($ids) {
        $builder = new AdminSortBuilder();
        $builder->doSort('Forum', $ids);
    }

    public function editForum($id=null) {
        //判断是否为编辑模式
        $isEdit = $id ? true : false;

        //如果是编辑模式，读取贴吧的属性
        if($isEdit) {
            $forum = M('Forum')->where(array('id'=>$id))->find();
        } else {
            $forum = array('create_time'=>time(), 'post_count'=>0, 'status'=>1);
        }

        //显示页面
        $builder = new AdminConfigBuilder();
        $builder
            ->title($isEdit ? '编辑贴吧' : '新增贴吧')
            ->keyId()->keyTitle()->keyCreateTime()->keyStatus()
            ->data($forum)
            ->buttonSubmit(U('doEditForum'))->buttonBack()
            ->display();
    }

    public function doEditForum($id=null, $title, $create_time, $status, $allow_user_group,$logo) {
        //判断是否为编辑模式
        $isEdit = $id ? true : false;

        //生成数据
        $data = array('title'=>$title, 'create_time'=>$create_time, 'status'=>$status, 'allow_user_group'=>$allow_user_group,'logo'=>$logo);

        //写入数据库
        $model = M('Forum');
        if($isEdit) {
            $data['id'] = $id;
            $data = $model->create($data);
            $result = $model->where(array('id'=>$id))->save($data);
            if(!$result) {
                $this->error('编辑失败');
            }
        } else {
            $data = $model->create($data);
            $result = $model->add($data);
            if(!$result) {
                $this->error('创建失败');
            }
        }

        //返回成功信息
        $this->success($isEdit ? '编辑成功' : '保存成功');
    }

    public function post($page=1, $forum_id=null, $r=20) {
        //读取帖子数据
        $map = array('status'=>array('EGT', 0));
        if($forum_id) $map['forum_id'] = $forum_id;
        $model = M('ForumPost');
        $list = $model->where($map)->order('last_reply_time desc')->page($page,$r)->select();
        $totalCount = $model->where($map)->count();

        //读取板块基本信息
        if($forum_id) {
            $forum = M('Forum')->where(array('id'=>$forum_id))->find();
            $forumTitle = ' - ' . $forum['title'];
        } else {
            $forumTitle = '';
        }

        //显示页面
        $builder = new AdminListBuilder();
        $builder->title('帖子管理' . $forumTitle)
            ->setStatusUrl(U('Forum/setPostStatus'))->buttonEnable()->buttonDisable()->buttonDelete()
            ->keyId()->keyLink('title','标题','Forum/reply?post_id=###')
            ->keyCreateTime()->keyUpdateTime()->keyTime('last_reply_time','最后回复时间')->keyBool('is_top','是否置顶')->keyStatus()->keyDoActionEdit('editPost?id=###')
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function postTrash($page=1, $r=20) {
        //读取帖子数据
        $map = array('status'=>-1);
        $model = M('ForumPost');
        $list = $model->where($map)->order('last_reply_time desc')->page($page, $r)->select();
        $totalCount = $model->where($map)->count();

        //显示页面
        $builder = new AdminListBuilder();
        $builder->title('帖子回收站')
            ->setStatusUrl(U('Forum/setPostStatus'))->buttonRestore()
            ->keyId()->keyLink('title','标题','Forum/reply?post_id=###')
            ->keyCreateTime()->keyUpdateTime()->keyTime('last_reply_time','最后回复时间')->keyBool('is_top','是否置顶')
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function editPost($id=null) {
        //判断是否在编辑模式
        $isEdit = $id ? true : false;

        //读取帖子内容
        if($isEdit) {
            $post = M('ForumPost')->where(array('id'=>$id))->find();
        } else {
            $post = array();
        }

        //显示页面
        $builder = new AdminConfigBuilder();
        $builder->title($isEdit ? '编辑帖子' : '新建帖子')
            ->keyId()->keyTitle()->keyEditor('content','内容')->keyRadio('is_top','置顶','选择置顶形式',array(0=>'不指定',1=>'本版置顶',2=>'全局置顶'))->keyCreateTime()->keyUpdateTime()
            ->keyTime('last_reply_time','最后回复时间')
            ->buttonSubmit(U('doEditPost'))->buttonBack()
            ->data($post)
            ->display();
    }

    public function setPostStatus($ids, $status) {
        $builder = new AdminListBuilder();
        $builder->doSetStatus('ForumPost', $ids, $status);
    }

    public function doEditPost($id=null,$title,$content,$create_time,$update_time,$last_reply_time,$is_top) {
        //判断是否为编辑模式
        $isEdit = $id ? true : false;

        //写入数据库
        $model = M('ForumPost');
        $data = array('title'=>$title,'content'=>$content,'create_time'=>$create_time,'update_time'=>$update_time,'last_reply_time'=>$last_reply_time,'is_top'=>$is_top);
        if($isEdit) {
            $result = $model->where(array('id'=>$id))->save($data);
        } else {
            $result = $model->keyDoActionEdit($data);
        }

        //如果写入不成功，则报错
        if(!$result) {
            $this->error($isEdit ? '编辑失败' : '创建成功');
        }

        //返回成功信息
        $this->success($isEdit ? '编辑成功' : '创建成功');
    }

    public function reply($page=1, $post_id=null, $r=20) {
        //读取回复列表
        $map = array('status'=>array('EGT',0));
        if($post_id) $map['post_id'] = $post_id;
        $model = M('ForumPostReply');
        $list = $model->where($map)->order('create_time asc')->page($page,$r)->select();
        $totalCount = $model->where($map)->count();

        //显示页面
        $builder = new AdminListBuilder();
        $builder->title('回复管理')
            ->setStatusUrl(U('setReplyStatus'))->buttonEnable()->buttonDisable()->buttonDelete()
            ->keyId()->keyTruncText('content', '内容', 50)->keyCreateTime()->keyUpdateTime()->keyStatus()->keyDoActionEdit('editReply?id=###')
            ->data($list)
            ->pagination($totalCount,$r)
            ->display();
    }

    public function replyTrash($page=1, $r=20) {
        //读取回复列表
        $map = array('status'=>-1);
        $model = M('ForumPostReply');
        $list = $model->where($map)->order('create_time asc')->page($page,$r)->select();
        $totalCount = $model->where($map)->count();

        //显示页面
        $builder = new AdminListBuilder();
        $builder->title('回复回收站')
            ->setStatusUrl(U('setReplyStatus'))->buttonRestore()
            ->keyId()->keyTruncText('content', '内容', 50)->keyCreateTime()->keyUpdateTime()->keyStatus()
            ->data($list)
            ->pagination($totalCount,$r)
            ->display();
    }

    public function setReplyStatus($ids, $status) {
        $builder = new AdminListBuilder();
        $builder->doSetStatus('ForumPostReply', $ids, $status);
    }

    public function editReply($id=null) {
        //判断是否为编辑模式
        $isEdit = $id ? true : false;

        //读取回复内容
        if($isEdit) {
            $model = M('ForumPostReply');
            $reply = $model->where(array('id'=>$id))->find();
        } else {
            $reply = array('status'=>1);
        }

        //显示页面
        $builder = new AdminConfigBuilder();
        $builder->title($isEdit ? '编辑回复' : '创建回复')
            ->keyId()->keyEditor('content','内容')->keyCreateTime()->keyUpdateTime()->keyStatus()
            ->data($reply)
            ->buttonSubmit(U('doEditReply'))->buttonBack()
            ->display();
    }

    public function doEditReply($id=null, $content, $create_time, $update_time, $status) {
        //判断是否为编辑模式
        $isEdit = $id ? true : false;

        //写入数据库
        $data = array('content'=>$content,'create_time'=>$create_time,'update_time'=>$update_time,'status'=>$status);
        $model = M('ForumPostReply');
        if($isEdit) {
            $result = $model->where(array('id'=>$id))->save($data);
        } else {
            $result = $model->add($data);
        }

        //如果写入出错，则显示错误消息
        if(!$result) {
            $this->error($isEdit ? '编辑失败' : '创建失败');
        }

        //返回成功消息
        $this->success($isEdit ? '编辑成功' : '创建成功', U('reply'));
    }
}
