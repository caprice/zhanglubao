<?php

namespace System\Model;
use Think\Model;
define ( 'ADMIN_AUTH_KEY', 'a8TYW#p=GU!/cjncI[ht_XVZzv`{o,104dxl.9P<' );


class AdminAdminModel extends Model {
	protected $_validate = array (
			array (
					'email',
					'require',
					'email不能为空',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_INSERT 
			),
			array (
					'username',
					'require',
					'用户名不能为空',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_INSERT 
			),
			array (
					'password',
					'require',
					'密码不能为空',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_INSERT 
			),
			array (
					'username',
					'1,30',
					'用户名长度不够',
					self::EXISTS_VALIDATE,
					'length' 
			),
			array (
					'username',
					'checkDenyMember',
					'用户名禁止',
					self::EXISTS_VALIDATE,
					'callback' 
			),
			array (
					'username',
					'checkUsername',
					'用户名只能是英文或者数字',
					self::EXISTS_VALIDATE,
					'callback' 
			),
			array (
					'username',
					'',
					'用户名已经存在',
					self::EXISTS_VALIDATE,
					'unique' 
			),
			array (
					'password',
					'6,30',
					'密码长度6-30',
					self::EXISTS_VALIDATE,
					'length',
					self::MODEL_INSERT
			) 
	);
	protected $_auto = array (
			
			array (
					'password',
					'think_ucenter_md5',
					self::MODEL_BOTH,
					'function',
					ADMIN_AUTH_KEY 
			),
			
			array (
					'update_time',
					NOW_TIME,
					self::MODEL_BOTH, 
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
	public function addAdmin($data) {
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
	public function editAdmin($data) {
	
		$reset=true;
		if (empty ( $data ['password'] )) {
			$reset=false;
		} 
		$data = $this->create ( $data,2);
		if (!$reset) {
			unset($data['password']);
		}
		if ($data) {
			$id = $this->save ( $data );
			return $id ? $id : 0;
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