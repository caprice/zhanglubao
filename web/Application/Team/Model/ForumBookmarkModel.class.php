<?php
 

namespace Team\Model;
use Think\Model;

class ForumBookmarkModel extends Model {
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    public function exists($uid, $post_id) {
        $result = $this->where(array('uid'=>$uid,'post_id'=>$post_id))->find();
        return $result ? true : false;
    }

    public function addBookmark($uid, $post_id) {
        //如果存在，就不添加了
        if($this->exists($uid, $post_id)) {
            return 0;
        }

        //如果不存在，就添加到数据库
        $data = array('uid'=>$uid,'post_id'=>$post_id);
        $data = $this->create($data);
        if(!$data) return false;
        return $this->add($data);
    }

    public function removeBookmark($uid, $post_id) {
        return $this->where(array('uid'=>$uid,'post_id'=>$post_id))->delete();
    }
}
