<?php
namespace Video\Controller;

use Common\Controller\BaseController;

class VideoController extends BaseController {

	public function index() {
		$title = I ( 'video_title' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$map ['video_title'] = array (
				'like',
				'%' . ( string ) $title . '%' 
		);
		$list = $this->lists ( 'VideoVideo', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}

	public function add() {
		if (IS_POST) {
			$data ['video_title'] = I ( 'video_title' );
			$data ['video_url'] = I ( 'video_url' );
			$data ['flash_url'] = I ( 'flash_url' );
			$data ['iframe_url'] = I ( 'iframe_url' );
			$data ['video_tags'] = I ( 'video_tags' );
			$data ['video_intro'] = I ( 'video_intro' );
			$data ['picture_id'] = I ( 'picture_id' );
			$data ['category_id'] = I ( 'category_id' );
			$users = I ( 'video_users' );
			if (! empty ( $users )) {
				$users = explode ( ',', $users );
				foreach ( $users as $user ) {
					$group_id = get_usergroup ( $user );
					if ($group_id == 6) {
						$members = get_members ( $user );
						$users = array_merge ( $users, $members );
					}
				}
				foreach ( $users as $user ) {
					$usernames = $usernames . get_nickname ( $user ) . ',';
				}
			}
			$data ['video_users'] = $usernames;
			$data ['video_userids'] = implode ( ',', $users );
			$data ['uid'] = $users [0];
			$Video = D ( 'VideoVideo' );
			$id = $Video->addVideo ( $data );
			if (! empty ( $id )) {
				D ( 'VideoUser' )->addVideos ( $id, $users );
			}
			if (false !== $id) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Video->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$games = $this->getGames ();
			$this->assign ( 'games', $games );
			$categories = $this->getCategories ();
			$this->assign ( 'categories', $categories );
			$countries = $this->getcountries ();
			$this->assign ( 'countries', $countries );
			$this->display ();
		}
	}

 

	public function edit($id = null) {
		if (IS_POST) {
			$data ['id'] = I ( 'id' );
			$data ['video_title'] = I ( 'video_title' );
			$data ['video_url'] = I ( 'video_url' );
			$data ['flash_url'] = I ( 'flash_url' );
			$data ['iframe_url'] = I ( 'iframe_url' );
			$data ['video_tags'] = I ( 'video_tags' );
			$data ['video_intro'] = I ( 'video_intro' );
			$data ['picture_id'] = I ( 'picture_id' );
			$data ['category_id'] = I ( 'category_id' );
			$users = I ( 'video_users' );
			if (! empty ( $users )) {
				$users = explode ( ',', $users );
				foreach ( $users as $user ) {
					$group_id = get_usergroup ( $user );
					if ($group_id == 6) {
						$members = get_members ( $user );
						$users = array_merge ( $users, $members );
					}
				}
				$users = array_unique ( $users );
				foreach ( $users as $user ) {
					$usernames = $usernames . get_nickname ( $user ) . ',';
				}
			}
			$data ['video_users'] = $usernames;
			$data ['uid'] = $users [0];
			$data ['video_userids'] = implode ( ',', $users );
			$Video = D ( 'VideoVideo' );
			$id = $Video->updateVideo ( $data );
			if ((! empty ( $users ) && (! empty ( $data ['id'] )))) {
				D ( 'VideoUser' )->updateVideos ( $data ['id'], $users );
			}
			if (false !== $id) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Video->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			if (! $id) {
				$this->error ( '参数错误' );
			}
			$video = D ( 'VideoVideo' )->find ( $id );
			$this->assign ( 'video', $video );
			$games = $this->getGames ();
			$this->assign ( 'games', $games );
			$countries = $this->getcountries ();
			$this->assign ( 'countries', $countries );
			$categories = $this->getCategories ();
			$this->assign ( 'categories', $categories );
			$userids = explode ( ',', $video ['video_userids'] );
			foreach ( $userids as $key => $uid ) {
				$users [] = get_user ( $uid );
			}
			$this->assign ( 'users', json_encode ( $users ) );
			$this->display ();
		}
	}

	/**
	 * 会员状态修改
	 *
	 * @author rocks
	 */
	public function changeStatus($method = null) {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
		$id = is_array ( $id ) ? implode ( ',', $id ) : $id;
		if (empty ( $id )) {
			$this->error ( '请选择要操作的数据!' );
		}
		$map ['id'] = array (
				'in',
				$id 
		);
		$videouser ['video_id'] = array (
				'in',
				$id 
		);
		switch (strtolower ( $method )) {
			case 'forbid' :
				D ( 'VideoUser' )->editStatus ( 0, $videouser );
				$this->forbid ( 'VideoVideo', $map );
				break;
			case 'resume' :
				D ( 'VideoUser' )->editStatus ( 1, $videouser );
				$this->resume ( 'VideoVideo', $map );
				break;
			case 'delete' :
				D ( 'VideoUser' )->editStatus ( - 1, $videouser );
				$this->delete ( 'VideoVideo', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}
?>