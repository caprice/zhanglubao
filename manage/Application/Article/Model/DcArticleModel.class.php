<?php
namespace Article\Model;

use Think\Model;
class DcArticleModel extends Model{
	
	/**
	 * 自动完成
	 * @author rocks
	 */
	protected $_auto = array(
			array('parse', 0, self::MODEL_BOTH),
			array('bookmark', 0, self::MODEL_BOTH),
	);
	
	
 
	
	public function update() {
		$data = $this->create ();
		if (! $data) {
			return false;
		}
		/* 添加或更新数据 */
		if (empty ( $data ['id'] )) {
			$res = $this->add ();
		} else {
			$res = $this->save ();
		}
		return $res;
	}
	
 
}
?>