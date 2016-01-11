<?php
namespace Admin\Model;
use Think\Model;

class MatchVideoModel extends Model{

	protected $_auto = array(
	array('status', 1, self::MODEL_INSERT),
	);
	
	
}