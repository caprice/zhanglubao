<?php
namespace Fight\Model;
use Think\Model;

/**
 * 文档基础模型
 */
class MemberModel extends Model
{
	/**
	 * 根据UID批量获取多个视频的相关信息
	 *
	 * @param array $uids
	 *        	视频UID数组
	 * @return array 指定视频的相关信息
	 */
	public function getMemberInfoByuids($uids) {
		! is_array ( $uids ) && $uids = explode ( ',', $uids );
		foreach ( $uids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getMemberInfo( $v );
		}
	
		return $cacheList;
	}
	
	
	/**
	 * 获取指定视频的相关信息
	 *
	 * @param integer $uid
	 *        	视频UID
	 * @return array 指定视频的相关信息
	 */
	public function getMemberInfo($uid) {
		$uid = intval ( $uid );
		if ($uid <= 0) {
			return false;
		}
		// 查询缓存数据
		 $member = S('member_info_' . $uid );
		if (! $member) {
			$map ['uid'] = $uid;
			$member = $this->_getMemberInfo ( $map );
		}
		return $member;
	}
	
	
	public function  getMembersInfo($map,$limit=20,$order='uid desc')
	{
		$members=$this->where($map)->field(array('uid'))->order($order)->limit($limit)->select();
		foreach ( $members as $v ) {
			! $cacheList [$v['uid']] && $cacheList [$v['uid']] = $this->getMemberInfo( $v['uid'] );
		}
		return $cacheList;
	
	}
	/**
	 * 获取指定视频的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定视频的相关信息
	 */
	private function _getMemberInfo($map, $field = "*") {
		$member=$this->where($map)->field($field)->find();
		$avatarModel=D('Avatar');
		$avatar=$avatarModel->getAvatar($member['uid']);
		if ($avatar)
		{
			$member['avatar']=$avatar;
		}else
		{
			$member['avatar']=cdn('default/avatar.jpg');
		}
		
		S('member_info_' . $member['uid'], $member, 86400 );
		return $member;
	}
	
	
	/**
	 * 清除指定视频缓存
	 *
	 */
	public function cleanCache($uids) {
		if (empty ( $uids )) {
			return false;
		}
		! is_array ( $uids ) && $uids = explode ( ',', $uids );
		foreach ( $uids as $uid ) {
			$keys =S('member_info_'.$uid);
			foreach ($keys as $k){
				S($k,null);
			}
			S('member_info_'.$uid,null);
		}
	
		return true;
	}

}
