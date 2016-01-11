<?php
namespace Common\Model;

use Think\Model;
class UserUserModel extends Model{
	 
	
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
			,
			array (
					'is_sync',
					1,
					self::MODEL_INSERT
			)
	);
	
	public function addUser($data) {
		$data = $this->create ( $data );
		if ($data) {
			$uid = $this->add ( $data );
			return $uid ? $uid : 0;
		} else {
			return false;
		}
	}
	
	protected function _after_select(&$resultSet, $options) {
		foreach ( $resultSet as $key => $result ) {
			$picture = M ( 'UserAvatar' )->where ( 'id=' . $result ['avatar_id'] )->getField ( 'url' );
			if (empty ( $picture )) {
				$result ['avatar'] =C("CDN_IMG_HOST")."default/default-avatar_120.jpg";
			} else {
				$result ['avatar'] = $picture;
				unset ( $result ['avatar_id'] );
			}
			$resultSet [$key] = $result;
		}
	}
	
	protected function _after_find(&$result, $options) {
		$picture = M ( 'UserAvatar' )->where ( 'id=' . $result ['avatar_id'] )->getField ( 'url' );
		if (empty ( $picture )) {
			$result ['avatar'] = C("CDN_IMG_HOST")."default/default-avatar_120.jpg";
		} else {
			$result ['avatar'] = $picture;
			unset ( $result ['avatar_id'] );
		}
	}
	
	
	
	/**
	 * 自动登录用户
	 *
	 * @param integer $user
	 *        	用户信息数组
	 */
	public  function autoLogin($user, $remember = false) {
		/* 更新登录信息 */
		$data = array (
				'uid' => $user ['uid'],
				'last_login_time' => NOW_TIME,
				'last_login_ip' => get_client_ip ( 1 )
		);
		$this->save ( $data );
		/* 记录登录SESSION和COOKIES */
		$auth = array (
				'uid' => $user ['uid'],
				'nickname' => get_nickname ( $user ['uid'] ),
				'last_login_time' => $user ['last_login_time']
		);
		session ( 'user_auth', $auth );
		session ( 'user_auth_sign', data_auth_sign ( $auth ) );
		if (! $this->getCookieUid ()) {
			cookie ( 'QT_LOGGED_USER', $this->jiami ( $this->change () . ".{$user['uid']}" ) );
		}
	}
	
	/**
	 * 设置登录状态、记录登录日志
	 *
	 * @param integer $uid
	 *        	用户ID
	 * @param boolean $is_remember_me
	 *        	是否记录登录状态，默认为false
	 * @return boolean 操作是否成功
	 */
	private function _recordLogin($uid) {
		if (! $this->getCookieUid ()) {
			cookie ( 'QT_LOGGED_USER', $this->jiami ( $this->change () . ".$uid." ) );
				
		}
		$this->setField ( 'last_login_time', NOW_TIME, 'uid=' . $uid );
		$auth = array (
				'uid' => $uid,
				'nickname' => get_nickname ( $uid ),
				'last_login_time' => NOW_TIME
		);
		session ( 'user_auth', $auth );
		session ( 'user_auth_sign', data_auth_sign ( $auth ) );
		return true;
	}
	
	/**
	 * 验证用户是否已登录
	 * 按照session -> cookie的顺序检查是否登陆
	 *
	 * @return boolean 登陆成功是返回true, 否则返回false
	 */
	public function isLogged() {
		// 验证本地系统登录
		if (is_login()) {
			return true;
		} else if ($uid = $this->getCookieUid ()) {
			return $this->_recordLogin ( $uid );
		} else {
			$this->logout ();
			return false;
		}
	}
	
	public function getCookieUid() {
		static $cookie_uid = null;
		if (isset ( $cookie_uid ) && $cookie_uid !== null) {
			return $cookie_uid;
		}
		$cookie = cookie ( 'QT_LOGGED_USER' );
		$cookie = explode ( ".", $this->jiemi ( $cookie ) );
		$cookie_uid = ($cookie [0] != $this->change ()) ? false : $cookie [1];
		return $cookie_uid;
	}
	
	/**
	 * 加密函数
	 *
	 * @param string $txt
	 *        	需加密的字符串
	 * @param string $key
	 *        	加密密钥，默认读取SECURE_CODE配置
	 * @return string 加密后的字符串
	 */
	private function jiami($txt, $key = null) {
		empty ( $key ) && $key = $this->change ();
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
		$nh = rand ( 0, 64 );
		$ch = $chars [$nh];
		$mdKey = md5 ( $key . $ch );
		$mdKey = substr ( $mdKey, $nh % 8, $nh % 8 + 7 );
		$txt = base64_encode ( $txt );
		$tmp = '';
		$i = 0;
		$j = 0;
		$k = 0;
		for($i = 0; $i < strlen ( $txt ); $i ++) {
			$k = $k == strlen ( $mdKey ) ? 0 : $k;
			$j = ($nh + strpos ( $chars, $txt [$i] ) + ord ( $mdKey [$k ++] )) % 64;
			$tmp .= $chars [$j];
		}
		return $ch . $tmp;
	}
	
	/**
	 * 解密函数
	 *
	 * @param string $txt
	 *        	待解密的字符串
	 * @param string $key
	 *        	解密密钥，默认读取SECURE_CODE配置
	 * @return string 解密后的字符串
	 */
	private function jiemi($txt, $key = null) {
		empty ( $key ) && $key = $this->change ();
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
		$ch = $txt [0];
		$nh = strpos ( $chars, $ch );
		$mdKey = md5 ( $key . $ch );
		$mdKey = substr ( $mdKey, $nh % 8, $nh % 8 + 7 );
		$txt = substr ( $txt, 1 );
		$tmp = '';
		$i = 0;
		$j = 0;
		$k = 0;
		for($i = 0; $i < strlen ( $txt ); $i ++) {
			$k = $k == strlen ( $mdKey ) ? 0 : $k;
			$j = strpos ( $chars, $txt [$i] ) - $nh - ord ( $mdKey [$k ++] );
			while ( $j < 0 ) {
				$j += 64;
			}
			$tmp .= $chars [$j];
		}
		return base64_decode ( $tmp );
	}
	
	private function change() {
		preg_match_all ( '/\w/', C ( 'DATA_AUTH_KEY' ), $sss );
		$str1 = '';
		foreach ( $sss [0] as $v ) {
			$str1 .= $v;
		}
		return $str1;
	}
	
	/**
	 * 注销当前用户
	 *
	 * @return void
	 */
	public function logout() {
		session ( 'user_auth', null );
		session ( 'user_auth_sign', null );
		cookie ( 'QT_LOGGED_USER', NULL );
	}
}
?>