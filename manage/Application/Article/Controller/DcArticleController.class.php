<?php
namespace Article\Controller;

use Common\Controller\BaseController;

class DcArticleController extends BaseController {

	public function index() {
		$list = $this->lists ( M ( 'DcDocument' ) );
		$this->assign ( '_list', $list );
		$this->display ();
	}

	public function add() {
		if (IS_POST) {
			$data ['title'] = strip_tags ( I ( 'title' ) );
			$data ['tags'] = I ( 'tags' );
			$data ['description'] = strip_tags ( I ( 'description' ) );
			$data ['cover_id'] = I ( 'cover_id' );
			$Document = D ( 'DcDocument' );
			$docid = $Document->addDoc ( $data );
			if (! empty ( $docid )) {
				$Article = D ( 'DcArticle' );
				$article ['content'] = I ( 'content' );
				$article ['id'] = $docid;
				$article_id = $Article->addArticle ( $article );
				if (! empty ( $article_id )) {
					$this->success ( '新增成功！', U ( 'index' ) );
				} else {
					$error = $Article->getError ();
					$this->error ( empty ( $error ) ? '未知错误！' : $error );
				}
				return;
			} else {
				$error = $Document->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$this->display ();
		}
	}

	public function edit($id = null) {
		if (IS_POST) {
			 
			$Document = D ( 'DcDocument' );
			$docid = $Document->update ();
			$AcModel = D ( 'DcArticle' );
			$article_id = $AcModel->update (  );
			 
			if (! empty ( $article_id )) {
				$this->success ( '编辑成功！', U ( 'index' ) );
			} else {
				$error = $AcModel->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			if (! $id) {
				$this->error ( '参数错误' );
			}
			$doc = D ( 'DcDocument' )->find ( $id );
			$article = D ( 'DcArticle' )->find ( $id );
			$this->assign ( 'doc', $doc );
			$this->assign ( 'article', $article );
			$this->display ();
		}
	}
}