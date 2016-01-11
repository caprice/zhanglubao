<?php

namespace Admin\Controller;

/**
 * 后台分类管理控制器
 */
class FightController extends AdminController {
	public function index() {
		$list = $this->lists ( 'Fight' );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		
		$this->meta_title = '约战信息';
		$this->display ();
	}
	public function add() {
		if (IS_POST) {
			$Fight = D ( 'Fight' );
			if (false !== $Fight->update ()) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Fight->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$games = $this->getGames ();
			$this->assign ( 'games', $games );
			$this->assign ( 'seriesid', $seriesid );
			$this->meta_title = '添加约战';
			$this->display ( 'edit' );
		}
	}
	public function edit($id = null) {
		if (IS_POST) {
			$Fight = D ( 'Fight' );
			if (false !== $Fight->update ()) {
				$this->success ( '新增成功！', U ( 'index' ) );
			} else {
				$error = $Fight->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			empty ( $id ) && $this->error ( '参数不能为空！' );
			$this->meta_title = '编辑战队';
			$fight = D ( 'Fight' )->field ( true )->find ( $id );
			empty ( $fight ) && $this->error ( '参数错误！' );
			$games = $this->getGames ();
			$this->assign ( 'games', $games );
			$this->assign ( 'fight', $fight );
			$this->display ( 'edit' );
		}
	}
}