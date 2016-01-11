<?php

namespace System\Model;

use Think\Model;

class SystemCountryModel extends Model{
	
	
	protected $_validate = array(
			array('country_name','require','国家名称必须填写'),
	);
	/**
	 * 自动完成
	 * @author rocks
	 */
	protected $_auto = array(
			array('status', 1, self::MODEL_INSERT),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
	);
	
	public function addCountry($data) {
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			$data['id']=$id;
 
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
	public function editCountry($data) {
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