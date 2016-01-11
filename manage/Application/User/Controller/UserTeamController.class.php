<?php

namespace User\Controller;

use Common\Controller\BaseController;

class UserTeamController extends BaseController {
	public function index() {
		$nickname = I ( 'nickname' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$map ['user_verify'] = 1;
		$map ['group_id'] = 6;
		if (is_numeric ( $nickname )) {
			$map ['uid|nickname'] = array (
					intval ( $nickname ),
					array (
							'like',
							'%' . $nickname . '%' 
					),
					'_multi' => true 
			);
		} else {
			$map ['nickname'] = array (
					'like',
					'%' . ( string ) $nickname . '%' 
			);
		}
		
		$list = $this->lists ( 'UserUser', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	public function edit($id = null) {
		if (IS_POST) {
			$users = explode ( ',', I ( 'team_users' ) );
			M ( 'UserTeam' )->where ( 'team_id=' . $id )->delete ();
			$Team = D ( 'UserTeam' );
			foreach ( $users as $user ) {
				$data   ['uid'] = $user;
				$data  ['team_id'] = $id;
				$Team->addMember($data);
			}
			$error = $Team->getError ();
			 
			if (empty($error)) {
				$this->success ( '更新成功！', U ( 'index' ) );
			} else {
				$error = $Team->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$userids = M ( 'UserTeam' )->where ( 'team_id=' . $id )->select ();
			foreach ( $userids as $userid ) {
				$users [] = get_user ( $userid ['uid'] );
				$ids[]= $userid ['uid'];
			}
			
			$this->assign ( 'team', get_user ( $id ) );
			$this->assign("userids",implode(',', $ids));
			$this->assign ( 'users', json_encode ( $users ) );
			
			$this->display ();
		}
	}
}

?>