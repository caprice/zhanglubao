<?php

namespace Common\Controller;

use Think\Controller;

class BaseController extends Controller{
	protected	$uid = 0;
	/**
	 * 前台控制器初始化
	 */
	protected function _initialize(){
		$this->initUser();
	}
	/**
	 * 用户信息初始化
	 * @access private
	 * @return void
	 */
	private function initUser() {
		if (!D('UserUser')->isLogged())
		{
			return  false;
		}
		$this->uid=is_login();
	
	}
}

?>