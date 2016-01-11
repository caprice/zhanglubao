<?php
 

namespace Collect\Model;
use Think\Model;

/**
 * 文档基础模型
 */
class DcDocumentModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', '1,80', '标题长度不能超过80个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
        array('description', '1,140', '简介长度不能超过140个字符', self::VALUE_VALIDATE, 'length', self::MODEL_BOTH),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('title', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
        array('description', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    public function addDoc($data) {
    	$data = $this->create ( $data );
    	if ($data) {
    		$id = $this->add ( $data );
    		$data['id']=$id;
    		return $id ? $id : 0;
    	} else {
    		return false;
    	}
    }
    
    
    public function updateDoc($data) {
    	$data = $this->create ( $data ,2);
    	if ($data) {
    		$id = $this->save ( $data );
    		return $id ? $id : 0;
    	} else {
    		return false;
    	}
    }

}