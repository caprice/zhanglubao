<?php
namespace LOL\Controller;

use Common\Controller\BaseController;

class LolHeroController extends BaseController {

	public function index() {
		$list = $this->lists ( M ( 'LolHero' ) );
		$this->assign ( '_list', $list );
		$this->display ();
	}

	public function add() {
		if (IS_POST) {
			$Hero = D ( 'LolHero' );
			if (false !== $Hero->update ()) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Hero->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$this->display ( 'edit' );
		}
	}

	public function edit($id = null) {
		if (IS_POST) {
			$Hero = D ( 'Hero' );
			if (false !== $Hero->update ()) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Hero->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$hero = D ( 'LolHero' )->find ( $id );
			$this->assign ( 'hero', $hero );
			$this->display ();
		}
	}
}
?>