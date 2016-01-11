<?php

namespace Recommend\Model;

use Think\Model;
class RecommendPlaceModel extends Model{
	
	
	protected $_validate = array(
			array('place_name', 'require', '表示不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
			
			
	);
	
	protected $_auto = array(
			array('place_name', 'strtoupper', self::MODEL_BOTH, 'function'),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
			array('status', '1', self::MODEL_BOTH),
	);
	
	 
	
	
}

?>