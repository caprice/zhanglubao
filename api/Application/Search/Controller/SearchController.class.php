<?php
namespace Search\Controller;

use Common\Controller\BaseController;
use Think\Search\CloudsearchClient;
use Think\Search\CloudsearchSearch;
use Think\Search\SoftwareSearch;

class SearchController extends BaseController {

	public function user($keyword="",$page=0) {
		
		$client = new CloudsearchClient ();
		$search = new CloudsearchSearch ( $client );
		$search->addIndex ( C ( 'SEARCH_USER_APP' ) );
		$param['page']=$page;
		$param['q']=$keyword;
		SoftwareSearch::buildSearchParam ( $param, $search );
		$field = array (
				'uid',
		);
		$opts = array (
				'fetch_fetches' => $field,
		);
		
		$search_result = json_decode ( $search->search ( $opts ), true );
		$result = $search_result ["result"];
		$items = $result ['items'];
		$users=array();
		foreach ( $items as $key => $item ) {
			$users []= D ( 'UserUser' )->field ( 'uid,nickname,avatar_id' )->find($item['uid']);
		}
		if (empty($users)) {
			$data['users']=array();
		}
		$data['users']=$users;
		$data['status']=1;
		$this->ajaxReturn($data);
	}
	public function video($keyword="",$page=0) {
		$client = new CloudsearchClient ();
		$search = new CloudsearchSearch ( $client );
		
		$search->addIndex ( C ( 'SEARCH_APP' ) );
		$param['page']=$page;
		$param['q']=$keyword;
		SoftwareSearch::buildSearchParam ( $param, $search );
		$field = array (
				'id',
				'uid',
			
		);
		$opts = array (
				'fetch_fetches' => $field,
		);
		
		$search->addSort('id');
		$search_result = json_decode ( $search->search ( $opts ), true );
		$result = $search_result ["result"];
		$items = $result ['items'];
		$videos=array();
		foreach ( $items as $key => $item ) {
			$videos []= D ( 'VideoVideo' )->field ( 'id,picture_id,video_title' )->find($item['id']);
		}
		if (empty($videos)) {
			$data['videos']=array();
		}
		$data['videos']=$videos;
		$data['status']=1;
		$this->ajaxReturn($data);
	}
}