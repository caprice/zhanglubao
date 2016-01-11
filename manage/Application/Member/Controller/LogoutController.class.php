<?php

namespace Member\Controller;

use Common\Controller\BaseController;
class LogoutController extends BaseController{
	
	public function logout() {
		if (is_admin_login ()) {
			D ( 'AdminAdmin' )->logout ();
			session ( '[destroy]' );
			$this->success ( '退出成功！', U ( 'login' ) );
		} else {
			$this->redirect ( 'login' );
		}
	}
}

?>