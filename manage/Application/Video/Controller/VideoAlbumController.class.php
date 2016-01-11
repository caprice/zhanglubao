<?php
namespace Video\Controller;

use Common\Controller\BaseController;

class VideoAlbumController extends BaseController {

	public function index() {
		$title = I ( 'album_name' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$map ['album_name'] = array (
				'like',
				'%' . ( string ) $title . '%' 
		);
		$list = $this->lists ( 'VideoAlbum', $map ,'album_weight  desc');
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}

	public function add() {
		if (IS_POST) {
			$data ['album_name'] = I ( 'album_name' );
			$data ['album_weight'] = I ( 'album_weight' );
			$data ['album_tags'] = I ( 'album_tags' );
			$data ['album_intro'] = I ( 'album_intro' );
			$data ['picture_id'] = I ( 'picture_id' );
			$data ['album_tags'] = I ( 'album_tags' );
			$data ['uid'] = I ( 'uid' );
			$VideoAlbum = D ( 'VideoAlbum' );
			$id = $VideoAlbum->addVideoAlbum ( $data );
		 
			if (false !== $id) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $VideoAlbum->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$games = $this->getGames ();
			$this->assign ( 'games', $games );
			$this->display ();
		}
	}
	
 

	public function edit($id = null) {
		if (IS_POST) {
			$data ['id'] = I ( 'id' );
			$data ['album_name'] = I ( 'album_name' );
			$data ['album_weight'] = I ( 'album_weight' );
			$data ['game_id'] = I ( 'game_id' );
			$data ['album_tags'] = I ( 'album_tags' );
			$data ['album_intro'] = I ( 'album_intro' );
			$data ['picture_id'] = I ( 'picture_id' );
			$data ['album_tags'] = I ( 'album_tags' );
			$VideoAlbum = D ( 'VideoAlbum' );
			$id = $VideoAlbum->updateVideoAlbum ( $data );
			if (false !== $id) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $VideoAlbum->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			if (! $id) {
				$this->error ( '参数错误' );
			}
			$album = D ( 'VideoAlbum' )->find ( $id );
			$this->assign ( 'album', $album );
			$user = get_user ( $album ['uid'] );
			$this->assign ( 'user', json_encode ( $user ) );
			$games = $this->getGames ();
			$this->assign ( 'games', $games );
			$this->display ();
		}
	}

	public function videos($id) {
		$map ['album_id'] = $id;
		$videos = $this->lists ( 'VideoAlbumVideo', $map );
		$Video = D ( 'VideoVideo' );
		foreach ( $videos as $album_video ) {
			$list [] = $Video->info ( $album_video ['video_id'] );
		}
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->assign ( 'id', $id );
		$this->display ();
	}

	public function deleteVideo($id = null, $videoid = null) {
		if (! empty ( $id ) && ! empty ( $videoid )) {
			$map ['album_id'] = $id;
			$map ['video_id'] = $videoid;
			$result = D ( 'VideoAlbumVideo' )->where ( $map )->delete ();
			if (false !== $result) {
				$this->success ( '删除成功！', U ( 'Video/VideoAlbum/videos/id/' . $id ) );
			} else {
				$error = D ( 'VideoAlbumVideo' )->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		}
	}

	public function addVideoId($id = null) {
		if (IS_POST) {
			$ids = I ( "videoids" );
			$ids=explode(',',$ids);
			$album_id = I ( "album_id" );
			foreach ( $ids as $id ) {
				$data ['video_id'] = $id;
				$data ['album_id'] = $album_id;
				$VideoAlbumVideo = D ( 'VideoAlbumVideo' );
				$VideoAlbumVideo->addVideo ( $data );
			}
			 $this->success ( '新增成功！', U ( 'Video/VideoAlbum/videos/id/' . I ( 'album_id' ) ) );
			
		} else {
			$this->assign ( 'album_id', $id );
			$this->display ();
		}
	}

	public function addVideo($id = null) {
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
			$vmid = $Video->addVideo ( $data );
			$album ['album_id'] = I ( 'album_id' );
			$album ['video_id'] = $vmid;
			$VideoAlbumVideo = D ( 'VideoAlbumVideo' );
			$vavid = $VideoAlbumVideo->addVideo ( $album );
			if (false !== $vmid) {
				D ( 'VideoUser' )->addVideos ( $vmid, $users );
			}
			if (false !== $vmid) {
				$this->success ( '新增成功！', U ( 'Video/VideoAlbum/videos/id/' . I ( 'album_id' ) ) );
			} else {
				$error = $VideoAlbumVideo->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$games = $this->getGames ();
			$this->assign ( 'games', $games );
			$categories = $this->getCategories ();
			$this->assign ( 'categories', $categories );
			$this->assign ( 'album_id', $id );
			$countries = $this->getcountries ();
			$this->assign ( 'countries', $countries );
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
				$this->forbid ( 'VideAlbum', $map );
				break;
			case 'resume' :
				$this->resume ( 'VideAlbum', $map );
				break;
			case 'delete' :
				$this->delete ( 'VideAlbum', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}
?>