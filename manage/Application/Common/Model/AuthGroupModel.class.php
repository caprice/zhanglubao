<?php

namespace Common\Model;

use Think\Model;

/**
 * 用户组模型类
 * Class AuthGroupModel 
 * @author Rocks
 */
class AuthGroupModel extends Model {
    const TYPE_ADMIN                = 1;                   // 管理员用户组类型标识
    const ADMIN                    = 'admin_admin';
    const AUTH_GROUP_ACCESS         = 'auth_group_access'; // 关系表表名
    const AUTH_EXTEND               = 'auth_extend';       // 动态权限扩展信息表
    const AUTH_GROUP                = 'auth_group';        // 用户组表名
    const AUTH_EXTEND_CATEGORY_TYPE = 1;              // 分类权限标识
    const AUTH_EXTEND_MODEL_TYPE    = 2; //分类权限标识

    protected $_validate = array(
        array('title','require', '必须设置用户组标题', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
        //array('title','require', '必须设置用户组标题', Model::EXISTS_VALIDATE  ,'regex',Model::MODEL_INSERT),
        array('description','0,80', '描述最多80字符', Model::VALUE_VALIDATE , 'length'  ,Model::MODEL_BOTH ),
       // array('rules','/^(\d,?)+(?<!,)$/', '规则数据不合法', Model::VALUE_VALIDATE , 'regex'  ,Model::MODEL_BOTH ),
    );

    /**
     * 返回用户组列表
     * 默认返回正常状态的管理员用户组列表
     * @param array $where   查询条件,供where()方法使用
     *
     * @author Rocks
     */
    public function getGroups($where=array()){
        $map = array('status'=>1,'type'=>self::TYPE_ADMIN,'module'=>'admin');
        $map = array_merge($map,$where);
        return $this->where($map)->select();
    }

    /**
     * 把用户添加到用户组,支持批量添加用户到用户组
     * @author Rocks
     * 
     * 示例: 把admin_id=1的用户添加到group_id为1,2的组 `AuthGroupModel->addToGroup(1,'1,2');`
     */
    public function addToGroup($admin_id,$gid){
        $admin_id = is_array($admin_id)?implode(',',$admin_id):trim($admin_id,',');
        $gid = is_array($gid)?$gid:explode( ',',trim($gid,',') );

        $Access = M(self::AUTH_GROUP_ACCESS);
        if( isset($_REQUEST['batch']) ){
            //为单个用户批量添加用户组时,先删除旧数据
            $del = $Access->where( array('admin_id'=>array('in',$admin_id)) )->delete();
        }

        $admin_id_arr = explode(',',$admin_id);
		$admin_id_arr = array_diff($admin_id_arr,array(C('USER_ADMINISTRATOR')));
        $add = array();
        if( $del!==false ){
            foreach ($admin_id_arr as $u){
                foreach ($gid as $g){
                    if( is_numeric($u) && is_numeric($g) ){
                        $add[] = array('group_id'=>$g,'admin_id'=>$u);
                    }
                }
            }
            $Access->addAll($add);
        }
        if ($Access->getDbError()) {
            if( count($admin_id_arr)==1 && count($gid)==1 ){
                //单个添加时定制错误提示
                $this->error = "不能重复添加";
            }
            return false;
        }else{
            return true;
        }
    }

    /**
     * 返回用户所属用户组信息
     * @param  int    $admin_id 用户id
     * @return array  用户所属的用户组 array(
     *                                         array('admin_id'=>'用户id','group_id'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
     *                                         ...)   
     */
    static public function getUserGroup($admin_id){
        static $groups = array();
        if (isset($groups[$admin_id]))
            return $groups[$admin_id];
        $prefix = C('DB_PREFIX');
        $user_groups = M()
            ->field('admin_id,group_id,title,description,rules')
            ->table($prefix.self::AUTH_GROUP_ACCESS.' a')
            ->join ($prefix.self::AUTH_GROUP." g on a.group_id=g.id")
            ->where("a.admin_id='$admin_id' and g.status='1'")
            ->select();
        $groups[$admin_id]=$user_groups?$user_groups:array();
        return $groups[$admin_id];
    }
    
    /**
     * 返回用户拥有管理权限的扩展数据id列表
     * 
     * @param int     $admin_id  用户id
     * @param int     $type 扩展数据标识
     * @param int     $session  结果缓存标识
     * @return array
     *  
     *  array(2,4,8,13) 
     *
     * @author rocks
     */
    static public function getAuthExtend($admin_id,$type,$session){
        if ( !$type ) {
            return false;
        }
        if ( $session ) {
            $result = session($session);
        }
        if ( $admin_id == UID && !empty($result) ) {
            return $result;
        }
        $prefix = C('DB_PREFIX');
        $result = M()
            ->table($prefix.self::AUTH_GROUP_ACCESS.' g')
            ->join($prefix.self::AUTH_EXTEND.' c on g.group_id=c.group_id')
            ->where("g.admin_id='$admin_id' and c.type='$type' and !isnull(extend_id)")
            ->getfield('extend_id',true);
        if ( $admin_id == UID && $session ) {
            session($session,$result);
        }
        return $result;
    }

    /**
     * 返回用户拥有管理权限的分类id列表
     * 
     * @param int     $admin_id  用户id
     * @return array
     *  
     *  array(2,4,8,13) 
     *
     * @author Rocks
     */
    static public function getAuthCategories($admin_id){
        return self::getAuthExtend($admin_id,self::AUTH_EXTEND_CATEGORY_TYPE,'AUTH_CATEGORY');
    }



    /**
     * 获取用户组授权的扩展信息数据
     * 
     * @param int     $gid  用户组id
     * @return array
     *  
     *  array(2,4,8,13) 
     *
     * @author rocks
     */
    static public function getExtendOfGroup($gid,$type){
        if ( !is_numeric($type) ) {
            return false;
        }
        return M(self::AUTH_EXTEND)->where( array('group_id'=>$gid,'type'=>$type) )->getfield('extend_id',true);
    }

    /**
     * 获取用户组授权的分类id列表
     * 
     * @param int     $gid  用户组id
     * @return array
     *  
     *  array(2,4,8,13) 
     *
     * @author Rocks
     */
    static public function getCategoryOfGroup($gid){
        return self::getExtendOfGroup($gid,self::AUTH_EXTEND_CATEGORY_TYPE);
    }
    

    /**
     * 批量设置用户组可管理的扩展权限数据
     *
     * @param int|string|array $gid   用户组id
     * @param int|string|array $cid   分类id
     * 
     * @author rocks
     */
    static public function addToExtend($gid,$cid,$type){
        $gid = is_array($gid)?implode(',',$gid):trim($gid,',');
        $cid = is_array($cid)?$cid:explode( ',',trim($cid,',') );

        $Access = M(self::AUTH_EXTEND);
        $del = $Access->where( array('group_id'=>array('in',$gid),'type'=>$type) )->delete();

        $gid = explode(',',$gid);
        $add = array();
        if( $del!==false ){
            foreach ($gid as $g){
                foreach ($cid as $c){
                    if( is_numeric($g) && is_numeric($c) ){
                        $add[] = array('group_id'=>$g,'extend_id'=>$c,'type'=>$type);
                    }
                }
            }
            $Access->addAll($add);
        }
        if ($Access->getDbError()) {
            return false;
        }else{
            return true;
        }
    }

    /**
     * 批量设置用户组可管理的分类
     *
     * @param int|string|array $gid   用户组id
     * @param int|string|array $cid   分类id
     * 
     * @author Rocks
     */
    static public function addToCategory($gid,$cid){
        return self::addToExtend($gid,$cid,self::AUTH_EXTEND_CATEGORY_TYPE);
    }


    /**
     * 将用户从用户组中移除
     * @param int|string|array $gid   用户组id
     * @param int|string|array $cid   分类id
     * @author rocks
     */
    public function removeFromGroup($admin_id,$gid){
        return M(self::AUTH_GROUP_ACCESS)->where( array( 'admin_id'=>$admin_id,'group_id'=>$gid) )->delete();
    }

    /**
     * 获取某个用户组的用户列表
     *
     * @param int $group_id   用户组id
     * 
     * @author Rocks
     */
    static public function memberInGroup($group_id){
        $prefix   = C('DB_PREFIX');
        $l_table  = $prefix.self::ADMIN;
        $r_table  = $prefix.self::AUTH_GROUP_ACCESS;
        $list     = M() ->field('m.id,u.username,m.last_login_time,m.last_login_ip,m.status')
                       ->table($l_table.' m')
                       ->join($r_table.' a ON m.id=a.admin_id')
                       ->where(array('a.group_id'=>$group_id))
                       ->select();
        return $list;
    }

    /**
     * 检查id是否全部存在
     * @param array|string $gid  用户组id列表
     * @author Rocks
     */
    public function checkId($modelname,$mid,$msg = '以下id不存在:'){
        if(is_array($mid)){
            $count = count($mid);
            $ids   = implode(',',$mid);
        }else{
            $mid   = explode(',',$mid);
            $count = count($mid);
            $ids   = $mid;
        }

        $s = M($modelname)->where(array('id'=>array('IN',$ids)))->getField('id',true);
        if(count($s)===$count){
            return true;
        }else{
            $diff = implode(',',array_diff($mid,$s));
            $this->error = $msg.$diff;
            return false;
        }
    }

    /**
     * 检查用户组是否全部存在
     * @param array|string $gid  用户组id列表
     * @author Rocks
     */
    public function checkGroupId($gid){
        return $this->checkId('AuthGroup',$gid, '以下用户组id不存在:');
    }
    
    /**
     * 检查分类是否全部存在
     * @param array|string $cid  栏目分类id列表
     * @author Rocks
     */
    public function checkCategoryId($cid){
        return $this->checkId('BookCategory',$cid, '以下分类id不存在:');
    }


}

