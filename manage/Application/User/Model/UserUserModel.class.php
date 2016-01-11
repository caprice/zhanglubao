<?php

namespace User\Model;

use Think\Model;

define ( 'USER_AUTH_KEY', 'a8BDW#p=GU!/mjncI[ht_XVZzv`{o,104dxl.9P<' );
class UserUserModel extends Model {
	protected $_validate = array (
   
			array (
					'nickname',
					'require',
					'昵称不能为空',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			),
 
 
	);
	protected $_auto = array (
			 
			
			array (
					'update_time',
					NOW_TIME,
					self::MODEL_INSERT 
			),
 
			array (
					'create_time',
					NOW_TIME 
			),
			array (
					'last_login_ip',
					'get_client_ip',
					self::MODEL_BOTH,
					'function',
					1 
			),
			array (
					'last_login_time',
					NOW_TIME,
					self::MODEL_BOTH 
			),
			
			array (
					'status',
					1,
					self::MODEL_INSERT 
			) 
	);
	
	
	
	public function addUser($data) {
		 
		$data = $this->create ( $data );
		if ($data) {
			$uid = $this->add ( $data );
			$data['uid']=$uid;
			return $uid ? $uid : 0;
		} else {
			return false;
		}
	}
	
	
	public function editUser($data) {
 
		if ($data) {
			$uid = $this->save ( $data );
			return $uid ? $uid : 0;
		} else {
			return false;
		}
	}
	
	/**
	 * 检测用户名是不是被禁止注册
	 *
	 * @param string $username
	 *        	用户名
	 * @return boolean ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMember($username) {
		return true; // TODO: 暂不限制，下一个版本完善
	}
	
	/**
	 * 检测邮箱是不是被禁止注册
	 *
	 * @param string $email
	 *        	邮箱
	 * @return boolean ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyEmail($email) {
		return true; // TODO: 暂不限制，下一个版本完善
	}
	protected function checkUsername($username) {
		
		// 如果用户名中有空格，不允许注册
		if (strpos ( $username, ' ' ) !== false) {
			return false;
		}
		preg_match ( "/^[a-zA-Z0-9_]{1,30}$/", $username, $result );
		
		if (! $result) {
			return false;
		}
		return true;
	}
	
	/**
	 * 检测手机是不是被禁止注册
	 *
	 * @param string $mobile
	 *        	手机
	 * @return boolean ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMobile($mobile) {
		return true; // TODO: 暂不限制，下一个版本完善
	}
	
	/**
	 * 根据配置指定用户状态
	 *
	 * @return integer 用户状态
	 */
	protected function getStatus() {
		return true; // TODO: 暂不限制，下一个版本完善
	}
}

?>