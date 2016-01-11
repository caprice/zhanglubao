<?php

namespace Recommend\Model;

use Think\Model;
class RecommendContentModel extends Model{
	
	
	protected $_validate = array(
			array('rec_title', 'require', '表示不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
				
				
	);
	
	protected $_auto = array(
			array('rec_type', 1, self::MODEL_INSERT),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('click_times', 0, self::MODEL_INSERT),
			array('rec_views', 0, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
			array('status', '1', self::MODEL_BOTH),
	);
	
	
	
}

?>