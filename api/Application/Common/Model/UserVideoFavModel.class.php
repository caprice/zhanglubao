<?php
namespace Common\Model;

use Think\Model;

class UserVideoFavModel extends Model {
	protected $_auto = array (
			array (
					'create_time',
					NOW_TIME,
					self::MODEL_INSERT 
			) 
	);

	public function fav($id) {
		$fav ['uid'] = is_login ();
		$fav ['video_id'] = $id;
		if ($this->where ( $fav )->count () > 0) {
			return 0;
		}
		$fav = $this->create ( $fav );
		return $this->add ( $fav );
	}

	public function unfav($ids) {
		$fav ['uid'] = is_login ();
		$fav ['video_id'] = array('in',$ids);
		return $this->where($fav)->delete();
	}
	
	public function  getFavList($page=0)
	{
		$start = $page * 16;
		$map['uid']=is_login();
		$ids = $this->field ( 'video_id' )->order ( 'id desc' )->where ( $map )->limit ( $start . ",16" )->select ();
		$videos=array();
		foreach ($ids as $id)
		{
			$videos[]=D('VideoVideo')->field ( 'id,picture_id,video_title' )->order('id desc')->limit($start.",16")->find($id['video_id']);
		}
		return  $videos;
		
	}
	
}
?>