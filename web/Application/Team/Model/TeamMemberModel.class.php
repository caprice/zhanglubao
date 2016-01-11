<?php
namespace Team\Model;
use Think\Model;

class TeamMemberModel extends Model{

	 
 
	public function getMemberInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		//$member = S('team_member_info_' . $id );
		if (! $member) {
			$map ['id'] = $id;
			$member = $this->_getMemberInfo ( $map );
		}
		return $member;
	}
	
	
	public function  getTeamMember($teamid)
	{
		$map['team_id']=$teamid;
		$map['verify']=1;
		return $this->getMembersInfo($map);
	}
	
	public function  getMembersInfo($map,$limit=20,$order='id asc')
	{
		$members=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();
		foreach ( $members as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getMemberInfo( $v['id'] );
		}
	
		return $cacheList;
	
	}
	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定游戏的相关信息
	 */
	private function _getMemberInfo($map, $field = "*") {
		$member=$this->where($map)->field($field)->find();
		$memberinfo=query_user(array('avatar','username','real_name'),$member['uid']);
		$member=array_merge($member,$memberinfo);
		S('team_member_info_' . $member['id'], $member, 86400 );
		return $member;
	}
	
	
	/**
	 * 清除指定Member数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys =S('team_member_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('team_member_info_'.$id,null);
		}
	
		return true;
	}
	 
}