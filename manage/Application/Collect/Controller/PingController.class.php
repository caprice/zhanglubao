<?php
namespace Collect\Controller;

use Common\Controller\BaseController;
class PingController   extends BaseController {
	
	
	public function zhidao() {
// 		$questions = M ( 'AsQuestion' )->field ( 'question_id' )->order ( 'question_id asc' )->limit(50,100)->select ();
// 		 foreach ($questions as $question)
// 		 {
// 		 	$result=$this->sendQuestionToBaidu($question['question_id']);
// 		 }
// 		$this->success ( '地图生成成功', "http://www.quntiao.com" );
	}
	
	
	public function sendQuestionToBaidu($id) {
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
// 	}
	
// 	public function video() {
// 		$videos = M ( 'VideoVideo' )->field ( 'id' )->order ( 'id asc' )->limit(50,100)->select ();
// 		foreach ($videos as $video)
// 		{
// 			$result=$this->sendVideoToBaidu($video['id']);
// 		}
// 		$this->success ( '地图生成成功', "http://www.quntiao.com" );
	}
	
	
	public function sendVideoToBaidu($id) {
// 		$urls = array (
// 				'http://v.quntiao.com/' . $id . '.html' 
// 		);
// 		$api = 'http://data.zz.baidu.com/urls?site=v.quntiao.com&token=6i1EerI2SE1d0lHT';
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