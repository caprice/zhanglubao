<?php

namespace Video\Controller;

class AlbumController extends BaseController {
	public function index($gameid=null) {
		$map=array();
		if ($gameid) {
			 $map['game_id']=$gameid;
		}
		$albums = $this->lists ( 'VideoAlbum', 4,$map);
		$games = D ( 'Game' )->getAllChildren ();
		$this->assign('gameid',$gameid);
		$this->assign ( 'games', $games );
		$this->assign ( '_list', $albums );
		$this->display ();
		
		
	}
	public function view($id) {
		$map ['album_id'] = $id;
		$album = D ( 'VideoAlbum' )->getAlbumInfo ( $id );
		
		$videoids = $this->lists ( 'VideoAlbumVideo', 32, $map );
		
		foreach ( $videoids as $videoid ) {
			$list [$videoid ['video_id']] = D ( 'Video' )->getVideoInfo ( $videoid ['video_id'] );
		}
		$this->assign ( '_list', $list );
		$this->assign ( 'album', $album );
		$this->display ();
	}
}

?>