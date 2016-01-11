<?php
namespace Common\Model;

use Think\Model;

class VideoAlbumVideoModel extends Model {

	public function getVideos($id, $limit) {
		$albumvideos = $this->field ( 'video_id' )->where ( 'album_id=' . $id )->order('video_id desc')->limit ( $limit )->select ();
		$videos = array ();
		foreach ( $albumvideos as $albumvideo ) {
			$videos [] = D ( 'VideoVideo' )->field ( "id,picture_id,video_title" )->find ( $albumvideo ['video_id'] );
		}
		return $videos;
	}
}
?>