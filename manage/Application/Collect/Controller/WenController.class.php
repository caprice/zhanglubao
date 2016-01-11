<?php
namespace Collect\Controller;

use Exception;
use Common\Controller\BaseController;

import ( 'Org.JAE.QueryList' );
class WenController extends BaseController {

	public function index() {
		set_time_limit ( 0 );
		import ( 'Org.JAE.QueryList' );
		header ( "Content-type: text/html; charset=utf-8" );
		 
			$page = 0;
		 
		$isend = false;
		while ( true ) {
			if ($isend) {
				break;
			}
			if (page > 1000) {
				break;
			}
			$offset = $page * 200;
			$listurl = "http://app.wenwen.sogou.com/front/catquestions?category=18060544&limit=200&offset=" . $offset . "";
			$page ++;
			$pagecontent = \phpQuery::newDocumentFileXML ( $listurl );
			$results = pq ( 'question' )->find ();
			if (empty ( $results )) {
				continue;
			}
			foreach ( $results as $result ) {
				$id = pq ( $result )->attr ( 'id' );
				$url = "http://app.wenwen.sogou.com/front/q?id=" . $id;
				$iscollect = D ( 'ClCollect' )->findUrl ( $url );
				if ($iscollect) {
					continue;
				}
				$answercount = pq ( $result )->find ( "numOfAnswers" )->text ();
				if (empty ( $answercount ) || $answercount == 0) {
					continue;
				}
				$content = \phpQuery::newDocumentFileXML ( $url );
				$title = pq ( 'title' )->text ();
				if (empty ( $title )) {
					continue;
				}
				$answers = pq ( 'answer' )->find ();
				if (empty ( $answers )) {
					continue;
				}
				$data ['question_title'] = $title;
				$data ['question_detail'] = $title;
				$data ['published_uid'] = 0;
				$data ['game_id'] = 7;
				$data ['anonymous'] = 1;
				$data ['is_recommend'] = 1;
				$Question = D ( 'AsQuestion' );
				$question_id = $Question->addQuestion ( $data );
				if ($question_id) {
					$best_answer = 0;
					foreach ( $answers as $answer ) {
						$content = pq ( $answer )->find ( 'content' )->text ();
						$adata ['question_id'] = $question_id;
						$adata ['answer_content'] = $content;
						$adata ['anonymous'] = 1;
						$answer_id = D ( 'AsAnswer' )->addAnswer ( $adata );
						if ($best_answer == 0) {
							$best_answer = $answer_id;
						}
					}
					D ( 'AsQuestion' )->saveCollectAnswer ( $question_id, $best_answer );
				}
				$cdata ['url'] = $url;
				$cdata ['site'] = "wenwen";
				$cdata ['page'] = $page;
				D ( 'ClCollect' )->addCollect ( $cdata );
			}
		}
		return;
	}
}
?>