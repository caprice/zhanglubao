<?php
namespace Competition\Model;
use Think\Model;

class TeamMemberModel extends Model{

	protected $_auto = array(
	array('status', 1, self::MODEL_INSERT),
	);

	public function  getMembersInfo($map,$limit=20,$order='id desc')
	{
		$members=$this->where($map)->order($order)->limit($limit)->select();
 
		return $members;

	}
	
	 
}