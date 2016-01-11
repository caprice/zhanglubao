<?php
namespace User\Controller;

use Common\Controller\BaseController;

class SyncController extends BaseController {

	public function login() {
		$data ['type_uid'] = I ( 'openid' );
		$data ['nickname'] = I ( 'nickname' );
		$data ['avatar'] = I ( 'avatar' );
		$data ['access_token'] = I ( 'access_token' );
		$data ['type'] = I ( 'type' );
		
		$user = D ( 'UserSyncLogin' )->bind ( $data );
		$result ['user'] = $user;
		$result ['status'] = 1;
		if ($result ['user']) {
			$result ['status'] = 1;
		} else {
			$result ['status'] = 0;
		 
		}
		$this->ajaxReturn ( $result );
	}

	public function logout() {
		D ( 'UserUser' )->logout ();
		$data ['status'] = 1;
		$this->ajaxReturn ( $data );
	}
}
?>