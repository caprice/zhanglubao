<?php
namespace Common\Model;
use Think\Model;
 
define ( 'ADMIN_AUTH_KEY', 'a8TYW#p=GU!/cjncI[ht_XVZzv`{o,104dxl.9P<' );


class AdminAdminModel extends Model {
	
	protected $_validate = array (
			
			array (
					'username',
					'1,30',
					- 1,
					self::EXISTS_VALIDATE,
					'length' 
			),  
			array (
					'username',
					'checkDenyMember',
					- 2,
					self::EXISTS_VALIDATE,
					'callback' 
			),  
			array (
					'username',
					'checkUsername',
					- 2,
					self::EXISTS_VALIDATE,
					'callback' 
			),
			array (
					'username',
					'',
					- 3,
					self::EXISTS_VALIDATE,
					'unique' 
			),  
			array (
					'password',
					'6,30',
					- 4,
					self::EXISTS_VALIDATE,
					'length' 
			)  
		)

	;
	
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
	
	
	/**
	 * 注册一个新用户
	 * @param  string $username 用户名
	 * @param  string $password 用户密码
	 * @param  string $email    用户邮箱
	 * @param  string $mobile   用户手机号码
	 * @return integer          注册成功-用户信息，注册失败-错误编号
	 */
	public function register($username, $password, $email){
		$data = array(
				'username' => $username,
				'password' => $password,
				'email'    => $email,
		);
	
	 
		/* 添加用户 */
		if($this->create($data)){
			$uid = $this->add();
			return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
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
		return true;  
	}
	
	/**
	 * 检测邮箱是不是被禁止注册
	 * 
	 * @param string $email
	 *        	邮箱
	 * @return boolean ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyEmail($email) {
		return true;  
	}
	
	protected function checkUsername($username) {
		
		if (strpos ( $username, ' ' ) !== false) {
			return false;
		}
		preg_match ( "/^[a-zA-Z0-9_]{1,30}$/", $username, $result );
		
		if (! $result) {
			return false;
		}
		return true;
	}
	
	
	public function login($email, $password) {
		$map = array ();
		$map ['email'] = $email;
		
		$user = $this->where ( $map )->find ();
		if (is_array ( $user ) && $user ['status']) {
			if (think_ucenter_md5 ( $password, ADMIN_AUTH_KEY ) === $user ['password']) {
				
				$this->autoLogin ($user); 
				return $user ['id'];  
				
				return - 2;  
			}
		} else {
			return - 1; 
		}
	}
	
	/**
	 * 自动登录用户
	 * 
	 * @param integer $user
	 *        	用户信息数组
	 */
	private function autoLogin($user) {
		/* 更新登录信息 */
		$data = array (
				'id' => $user ['id'],
				'last_login_time' => NOW_TIME,
				'last_login_ip' => get_client_ip ( 1 ) 
		);
		$this->save ( $data );
		
		/* 记录登录SESSION和COOKIES */
		$auth = array (
				'id' => $user ['id'],
				'username' => $user ['username'],
				'avatar_id'=>$user['avatar_id'],
				'last_login_time' => $user ['last_login_time'] 
		);
		
		session ( 'admin_user_auth', $auth );
		session ( 'admin_user_auth_sign', data_auth_sign ( $auth ) );
	}
	
	
	
	public function getUserName($uid){
		return $this->where(array('id'=>(int)$uid))->getField('username');
	}
	
	
	/**
	 * 注销当前用户
	 * 
	 * @return void
	 */
	public function logout() {
		session ( 'admin_user_auth', null );
		session ( 'admin_user_auth_sign', null );
	}
}

?>