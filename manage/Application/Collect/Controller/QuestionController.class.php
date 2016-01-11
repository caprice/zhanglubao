<?php
namespace Collect\Controller;

use Exception;
use Common\Controller\BaseController;

import ( 'Org.JAE.QueryList' );
class QuestionController extends BaseController {

	public function qihoo() {
		set_time_limit(0);
		import ( 'Org.JAE.QueryList' );
		header ( "Content-type: text/html; charset=utf-8" );
		$page = 7600;
		$isend = false;
		while ( true ) {
			if ($isend) {
				break;
			}
			ob_end_flush ();
			echo $page . "<br/>";
			flush ();
			$listurl = "http://wenda.haosou.com/chip/entanslist?pn=" . $page . "%0A&qid=1433735543";
			$page ++;
			$pagecontent = \phpQuery::newDocumentFile ( $listurl );
			$results = pq ( 'li a' )->find ();
			if (empty($results))
			{
				continue;
			}
			foreach ( $results as $result ) {
				$url = pq ( $result )->attr ( 'href' );
				$url = "http://wenda.haosou.com" . $url;
				$iscollect = D ( 'ClCollect' )->findUrl ( $url );
				if ($iscollect) {
					continue;
				}
				$content = \phpQuery::newDocumentFile ( $url );
				$title = pq ( '.js-ask-title' )->text ();
				if (empty ( $title )) {
					continue;
				}
				$answer = pq ( '.resolved-cnt' )->text ();
				$data ['question_title'] = $title;
				$data ['question_detail'] = $title;
				$data ['published_uid'] = 0;
				$data ['game_id'] = 7;
				$data ['anonymous'] = 1;
				$data ['is_recommend'] = 1;
				$Question = D ( 'AsQuestion' );
				$question_id = $Question->addQuestion ( $data );
				if ($question_id) {
					$answer = trim ( $answer, "\r\n\t" );
					$adata ['question_id'] = $question_id;
					$adata ['answer_content'] = $answer;
					$adata ['anonymous'] = 1;
					$answer_id = D ( 'AsAnswer' )->addAnswer ( $adata );
					D ( 'AsQuestion' )->saveCollectAnswer ( $question_id, $answer_id );
					$this->sendToBaidu($question_id);
				}
				$cdata ['url'] = $url;
				$cdata ['site'] = "360";
				D ( 'ClCollect' )->addCollect ( $cdata );
			}
		}
		return;
	}
	
	public function sendToBaidu($id) {
// 		$urls = array (
// 				'http://zhidao.quntiao.com/' . $id . '.html'
// 		);
// 		$api = 'http://data.zz.baidu.com/urls?site=zhidao.quntiao.com&token=6i1EerI2SE1d0lHT';
// 		$ch = curl_init ();
// 		$options = array (
// 				CURLOPT_URL => $api,
// 				CURLOPT_POST => true,
// 				CURLOPT_RETURNTRANSFER => true,
// 				CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
// 				CURLOPT_HTTPHEADER => array (
// 						'Content-Type: text/plain'
// 				)
// 		);
// 		curl_setopt_array ( $ch, $options );
// 		$result = curl_exec ( $ch );
// 		return $result;
	}
}
?>