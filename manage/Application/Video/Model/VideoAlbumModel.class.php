<?php

namespace Video\Model;

use Think\Model;
class VideoAlbumModel extends Model{
	protected $_validate = array(
			array('album_name','require','视频标题必须写'),
			array('album_tags', 'require','视频标签必须写'),
			array('album_intro','require','视频描述必须写'),
	);
	
	
	protected $_auto = array(
			array('video_counts',0, self::MODEL_INSERT),
			array('status', 1, self::MODEL_INSERT),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
	);
	
	public function addVideoAlbum($data) {
	
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
	public function updateVideoAlbum($data) {
		$data = $this->create ( $data ,2);
		if ($data) {
			$id = $this->save ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
}

?>