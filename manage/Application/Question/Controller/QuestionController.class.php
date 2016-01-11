<?php
namespace Question\Controller;

use System\Controller\AdminController;

class QuestionController extends AdminController {

	public function index() {
		$questions = $this->lists ( 'AsQuestion',array(),'question_id desc' );
		$this->assign ( '_list', $questions );
		$this->display ();
	}

	public function add() {
		if (IS_POST) {
			$data ['question_title'] = I ( 'question_title' );
			$data ['question_detail'] = I ( 'question_detail' );
			$data ['published_uid'] = 0;
			$data ['game_id'] = 7;
			$data ['anonymous'] = 1;
			$data ['is_recommend'] = I ( 'is_recommend' );
			$Question = D ( 'AsQuestion' );
			$id=$Question->addQuestion ( $data );
			if ($id ) {
			 
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Question->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$this->display ();
		}
	}
	
	 

	public function edit($id=0) {
		if (IS_POST) {
			$data ['question_id'] = I ( 'question_id' );
			$data ['question_title'] = I ( 'question_title' );
			$data ['question_detail'] = I ( 'question_detail' );
			$data ['published_uid'] = 0;
			$data ['game_id'] = 7;
			$data ['anonymous'] = 1;
			$data ['is_recommend'] = I ( 'is_recommend' );
			$Question = D ( 'AsQuestion' );
			if (false !== $Question->editQuestion ( $data )) {
				$this->success ( '编辑成功！', U ( 'index' ) );
			} else {
				$error = $Question->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$question = D ( 'AsQuestion' )->find ( $id );
			$this->assign ( 'question', $question );
			$this->display ();
		}
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
		$map ['question_id'] = array (
				'in',
				$id 
		);
		switch (strtolower ( $method )) {
			case 'forbid' :
				$this->forbid ( 'AsQuestion', $map );
				break;
			case 'resume' :
				$this->resume ( 'AsQuestion', $map );
				break;
			case 'delete' :
				$this->delete ( 'AsQuestion', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}
?>