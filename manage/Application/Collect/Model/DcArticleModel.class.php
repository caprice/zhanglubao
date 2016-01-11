<?php
namespace Collect\Model;

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
	
	
	public function addArticle($data) {
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			$data['id']=$id;
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
	public function editArticle($data) {
		$data = $this->create ( $data);
	 
		if ($data) {
			$id = $this->save ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
}
?>