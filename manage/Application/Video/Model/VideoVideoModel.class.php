<?php

namespace Video\Model;

use Think\Model;

class VideoVideoModel extends Model{
	
	protected $_validate = array(
			array('video_title','require','视频标题必须写'),
			array('video_tags', 'require','视频标签必须写'),
			array('video_url','require','视频地址必须写'),
			array('flash_url', 'require','flash地址必须写'),
			array('video_info', 'require','视频简介必须写'),
	);
	
	
	protected $_auto = array(
			array('status', 1, self::MODEL_INSERT),
			array('video_level', 1, self::MODEL_INSERT),
			array('last_view', NOW_TIME, self::MODEL_BOTH),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
	);
	
	public function addVideo($data) {
		
		$data = $this->create ( $data );
		
		if ($data) {
			$id = $this->add ( $data );
			$data['id']=$id;
			
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
	
	
	public function info($id)
	{
		return $this->find($id);
	}
}

?>