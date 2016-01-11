<?php
namespace Common\Model;

use Think\Model;
class UserAvatarModel extends Model{
	
 
	/**
	 * 自动完成
	 * @var array
	 */
	protected $_auto = array(
			array('status', 1, self::MODEL_INSERT),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
	);
	
	public function saveSync($url)
	{
		$data['url']=$url;
		$data['md5']=md5($url);
		$data['sha1']=sha1($url);
		$data['status']=1;
		$data['width']=180;
		$data['height']=180;
	
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			$data['id']=$id;
			return $id ? $id : 0;
		} else {
			return false;
		}
	
	}
	
}
?>