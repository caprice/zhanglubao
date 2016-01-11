<?php
namespace Home\Model;
use Think\Model;

class TeamModel extends Model{

	protected $_validate = array(
	array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('name', '0,40', '20个字以内', self::EXISTS_VALIDATE, 'length'),
	array('name', 'checkName', '战队已存在', self::MUST_VALIDATE, 'callback', self::MODEL_BOTH),
	array('description', 'require', '描述不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
	);
	protected $_auto = array(
	array('status', 1, self::MODEL_INSERT),
	array('create_time', NOW_TIME, self::MODEL_INSERT),
	array('uid', 'get_uid', self::MODEL_INSERT, 'function', 1),
	);
	/**
	 * 更新分类信息
	 * @return boolean 更新状态
	 * @author Rocks
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
		action_log('update_team', 'team', $data['id'] ? $data['id'] : $res, UID);
		return $res;
	}


	public function  checkName()
	{
		$id=I('post.id');
		$name=I('post.name');
		$gameid=I('post.game_id');
		$map['name']=$name;
		$map['game_id']=$gameid;
		if (!empty($id)) {
			$map['id'] = array('neq', $id);
		}
		$res = $this->where($map)->find();
		return empty($res);
	}


	/**
	 * 获取指定战队的相关信息
	 * @return array 指定战队的相关信息
	 */
	public function getTeamInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		 $team = S('team_info_' . $id );
		if (! $team) {
			$map ['id'] = $id;
			$team = $this->_getTeamInfo ( $map );
		}
		return $team;
	}


	public function  getTeamsInfo($map=array(),$limit=20,$order='id desc')
	{
		$teams=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $teams as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getTeamInfo( $v['id'] );
		}

		return $cacheList;

	}
	/**
	 * 获取指定战队的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定战队的相关信息
	 */
	private function _getTeamInfo($map, $field = "*") {
		$team=$this->where($map)->field($field)->find();
		S('team_info_' . $team['id'], $team, 86400 );
		return $team;
	}


	/**
	 * 清除指定Team数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys =S('team_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('team_info_'.$id,null);
		}

		return true;
	}


}

