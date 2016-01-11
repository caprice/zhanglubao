<?php
namespace Collect\Model;

use Think\Model;

class ClCollectModel extends Model {
	protected $_auto = array (
			array (
					'status',
					1,
					self::MODEL_INSERT 
			),
			array (
					'create_time',
					NOW_TIME,
					self::MODEL_INSERT 
			),
			array (
					'update_time',
					NOW_TIME,
					self::MODEL_BOTH 
			) 
	);

	public function findUrl($url) {
		$map ['url'] = $url;
		$result = $this->where ( $map )->find ();
		
		if (! empty ( $result )) {
			
			return true;
		} else {
			return false;
		}
	}

	public function addCollect($data) {
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
}
?>