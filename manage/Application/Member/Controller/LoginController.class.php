<?php

namespace Member\Controller;

use Think\Controller;
 
class LoginController extends Controller{
	
	
/**
	 * 后台用户登录
	 *
	 * @author Rocks
	 */
	public function login($email = null, $password = null, $verify = null) {
		 
	 
		if (IS_POST) {
			$Admin = D ( 'AdminAdmin' );
			$adminid = $Admin->login ( $email, $password );
			if (0 < $adminid) {
				$this->success ( '登录成功！', U ( 'Home/Index/index' ) );
			} else {
				switch ($adminid) {
					case - 1 :
						$error = '用户不存在或被禁用！';
						break;
					case - 2 :
						$error = '密码错误！';
						break;
					default :
						$error = '未知错误！';
						break;
				}
				$this->error ( $error );
			}
		} else {
			
			if (is_admin_login ()) {
				$this->redirect ( 'Home/Index/index' );
			} else {
			 
				$config = S ( 'DB_CONFIG_DATA' );
				if (! $config) {
					$config =  api('SystemConfig/lists');
					S ( 'DB_CONFIG_DATA', $config );
				}
				C ( $config );
				$this->display ();
			}
		}
	}
	

	public function verify() {
		$verify = new \Think\Verify ();
		$verify->entry ( 1 );
	}
	
	
}

?>