<?php
namespace Video\Controller;

use Common\Controller\BaseController;

class VideoCommentController extends BaseController {

	public function index() {
		$title = I ( 'content' );
		$map ['status'] = array (
				'egt',
				0 
		);
		$map ['content'] = array (
				'like',
				'%' . ( string ) $title . '%' 
		);
		$list = $this->lists ( 'VideoComment', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	/**
	 * 会员状态修改
	 *
	 * @author rocks
	 */
	public function changeStatus($method = null) {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
		$id = is_array ( $id ) ? implode ( ',', $id ) : $id;
		if (empty ( $id )) {
			$this->error ( '请选择要操作的数据!' );
		}
		$map ['id'] = array (
				'in',
				$id
		);
		 
		switch (strtolower ( $method )) {
			case 'forbid' :
				$this->forbid ( 'VideoComment', $map );
				break;
			case 'resume' :
				$this->resume ( 'VideoComment', $map );
				break;
			case 'delete' :
				$this->delete ( 'VideoComment', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}
?>