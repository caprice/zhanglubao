<?php
namespace Admin\Model;
use Think\Model;

class TeamMemberModel extends Model{

	protected $_validate = array(
	array('uid', 'require', 'UID不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('tid', 'require', 'TID不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('role', 'require', '角色不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	);
	protected $_auto = array(
	array('create_time', NOW_TIME, self::MODEL_INSERT),
	);


	/**
	 * 更新分类信息
	 * @return boolean 更新状态
	 * @author Rocks
	 */
	public function updateMember($data){


		if(!$data){ //数据对象创建错误
			return false;
		}
		$data = $this->create($data);
		/* 添加或更新数据 */
		if(empty($data['id'])){
			$res = $this->add();
		}else{
			$res = $this->save();
		}
		$this->cleanCache(array($data['id']));
		action_log('update_team_member', 'team_member', $data['id'] ? $data['id'] : $res, UID);
		return $res;
	}

	/**
	 * 更新分类信息
	 * @return boolean 更新状态
	 */
	public function update(){
		$data = $this->create();
		if(!$data){ //数据对象创建错误
			return false;
		}

		/* 添加或更新数据 */
		if(empty($data['id'])){
			$res = $this->add();
		}else{
			$res = $this->save();
		}
		$this->cleanCache(array($data['id']));
		action_log('update_team_member', 'team_member', $data['id'] ? $data['id'] : $res, UID);
		return $res;
	}




	/**
	 * 清除指定Game数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			static_cache ( 'team_member_info_' . $id, false );
			$keys =S('team_member_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('team_member_info_'.$id,null);
		}

		return true;
	}

}

