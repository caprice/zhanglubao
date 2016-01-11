<?php
namespace Common\Model;

use Think\Model;

class UserSyncLoginModel extends Model {
	
 
	
	public function bind($info) {
		$map ['type_uid'] = $info ['type_uid'];
		$map ['type'] = $info ['type'];
		$snyc = $this->where ( $map )->find ();
		if (! empty ( $snyc )) {
			$user = D ( 'UserUser' )->where ( 'uid=' . $snyc ['uid'] )->field ( 'uid,nickname,avatar_id' )->find ();
		} else {
			$user ['nickname'] = $info ['nickname'];
			$user ['country_id'] = 1;
			$user ['user_verify'] = 0;
			$user ['avatar_id'] = D ( 'UserAvatar' )->saveSync ( $info ['avatar'] );
			$user ['group_id'] = 1;
			$user ['user_weight'] = 1;
			$UserModel = D ( 'UserUser' );
			$uid = $UserModel->addUser ( $user );
			$data ['uid'] = $uid;
			$data ['type_uid'] = $info ['type_uid'];
			$data ['oauth_token'] = $info ['access_token'];
			$data ['type'] = $info ['type'];
			$data ['oauth_token_secret'] = '';
			$res = $this->add ( $data );
			$user = D ( 'UserUser' )->where ( 'uid=' . $uid )->field ( 'uid,nickname,avatar_id' )->find ();
		}
		if (! empty ( $user ['uid'] )) {
			D ( 'UserUser' )->autoLogin ( $user );
			return $user;
		} else {
			return;
		}
	}
}
?>