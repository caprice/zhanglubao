<?php
namespace Collect\Model;

use Think\Model;
class AsAnswerModel extends Model{
	
	protected $_auto = array (
			array (
					'status',
					1,
					self::MODEL_INSERT
			),
			array (
					'game_id',
					7,
					self::MODEL_BOTH
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
			),
			array (
					'last_ip',
					'get_client_ip',
					self::MODEL_INSERT,
					'function',
					1
			)
	);
	
	public function addAnswer($data) {
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
	public function editAnswer($data) {
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