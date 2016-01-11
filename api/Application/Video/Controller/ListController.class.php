<?php
namespace Video\Controller;

use Common\Controller\BaseController;
use Think\Search\CloudsearchClient;
use Think\Search\CloudsearchSearch;
use Think\Search\SoftwareSearch;

class ListController extends BaseController{
	public function user($id=null,$page=0)
	{
		if (empty($id)) {
			$this->ajax(array());
		}
		$start=$page*16;
		$map['uid']=$id;
		$data['videos']=D('VideoUser')->getVideosInfo($map,$start.",16");
		if (empty($data['videos'])) {
			$data['videos']=array();
		}
		$data ['status'] = 1;
		$this->ajaxReturn($data);
	}
	
	public function album($id=null,$page=0)
	{
		if (empty($id)) {
			$this->ajax(array());
		}
		$start=$page*16;
		$data['videos']=D('VideoAlbumVideo')->getVideos($id,$start.",16");
		if (empty($data['videos'])) {
			$data['videos']=array();
		}
		$data ['status'] = 1;
		$this->ajaxReturn($data);
	}
	
	public function  hero($id=null,$page=0)
	{
		 
		$client = new CloudsearchClient ();
		$search = new CloudsearchSearch ( $client );
		$search->addIndex ( C ( 'SEARCH_APP' ) );
		$param['page']=$page;
		$param['q']=D('LolHero')->getFieldById($id,'name');
		SoftwareSearch::buildSearchParam ( $param, $search );
		$field = array (
				'uid',
				'id' 
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
?>