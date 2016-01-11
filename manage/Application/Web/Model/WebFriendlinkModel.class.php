<?php

namespace Web\Model;

use Think\Model;
class WebFriendlinkModel extends  Model {
	
	protected $_validate = array(
			array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
			array('displayorder','require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
			array('url','require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
			array('description','require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
			array('type','require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	);
	
	
	
	
	protected $_auto = array(
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
			array('status', '1', self::MODEL_BOTH),
	);
	
 
 
}

?>