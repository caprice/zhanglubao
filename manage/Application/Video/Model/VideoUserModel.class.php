<?php

namespace Video\Model;

use Think\Model;
class VideoUserModel extends Model{
	
	protected $_auto = array(
			array('status', 1, self::MODEL_INSERT),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
	);
	
	public function  addVideos($video_id,$users)
	{
		foreach ($users as $user)
		{
			$data['video_id']=$video_id;
			$data['uid']=$user;
			$data=$this->create($data);
			if (!empty($data)) {
				$this->add($data);
			}
		}
		
		
	}
	public function  updateVideos($video_id,$users)
	{
		$this->where('video_id='.$video_id)->delete();
		foreach ($users as $user)
		{
			$data['video_id']=$video_id;
			$data['uid']=$user;
			$data=$this->create($data);
			if (!empty($data)) {
				$this->add($data);
			}
		}
	
	}
	public function  editStatus($status,$map)
	{
		$data['status']=$status;
		$this->where($map)->save($data);
	}
}

?>