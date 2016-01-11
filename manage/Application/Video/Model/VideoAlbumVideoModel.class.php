<?php

namespace Video\Model;

use Think\Model;
class VideoAlbumVideoModel extends Model{
	
	protected $_validate = array(
			array('video_id','require','视频标题必须写'),
			array('album_id','require','视频标题必须写'),
	);
	
	
	protected $_auto = array(
			array('status', 1, self::MODEL_INSERT),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
	);
	
	
	
	public function addVideo($data) {
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
	public function updateVideo($data) {
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