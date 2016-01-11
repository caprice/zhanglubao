<?php
namespace App\Controller;

use Common\Controller\BaseController;

class SlideController extends BaseController {

	public function index() {
		$list = $this->lists ( M ( 'AppSlide' ) );
		$this->assign ( '_list', $list );
		$this->display ();
	}

	public function add() {
		if (IS_POST) {
			$Slide=D('AppSlide');
			if(false !== $Slide->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Slide->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		} else {
			$this->display ('edit');
		}
	}

	public function edit($id=null) {
		if (IS_POST) {
			$Slide=D('AppSlide');
			if(false !== $Slide->update()){
				$this->success('新增成功！', U('index'));
			} else {
				$error = $Slide->getError();
				$this->error(empty($error) ? '未知错误！' : $error);
			}
		} else {
			$info=D('AppSlide')->find($id);
			$this->assign('info',$info);
			$this->display ();
		}
	}
}
?>