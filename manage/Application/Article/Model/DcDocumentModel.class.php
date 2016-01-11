<?php
 

namespace Article\Model;
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
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
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