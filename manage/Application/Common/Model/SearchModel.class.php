<?php

namespace Common\Model;

use Think\Search\CloudsearchDoc;
use Think\Search\CloudsearchClient;

class SearchModel {
	public function addUsers($results) {
		foreach ( $results as $key => $result ) {
			$user ['uid'] = $result ['uid'];
			$user ['username'] = $result ['username'];
			$user ['nickname'] = $result ['nickname'];
			$user ['group_id'] = $result ['group_id'];
			$user ['avatar_id'] = $result ['avatar_id'];
			$data [$key] ['cmd'] = CloudsearchDoc::DOC_ADD;
			$data [$key] ['fields'] = $user;
		}
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( $data ), 'user_user' );
		return $msg;
	}
	
	public function updateUsers($results) {
		foreach ( $results as $key => $result ) {
			$user ['uid'] = $result ['uid'];
			$user ['username'] = $result ['username'];
			$user ['nickname'] = $result ['nickname'];
			$user ['group_id'] = $result ['group_id'];
			$user ['avatar_id'] = $result ['avatar_id'];
			$data [$key] ['cmd'] = CloudsearchDoc::DOC_UPDATE;
			$data [$key] ['fields'] = $user;
		}
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->update(json_encode ( $data ), 'user_user' );
		return $msg;
	}
	public function addUser($result) {
		$user ['uid'] = $result ['uid'];
		$user ['username'] = $result ['username'];
		$user ['nickname'] = $result ['nickname'];
		$user ['group_id'] = $result ['group_id'];
			$user ['avatar_id'] = $result ['avatar_id'];
		$data ['cmd'] = CloudsearchDoc::DOC_ADD;
		$data ['fields'] = $user;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( array (
				$data 
		) ), 'user_user' );
		return $msg;
	}
	public function editUser($result) {
		$user ['uid'] = $result ['uid'];
		$user ['username'] = $result ['username'];
		$user ['nickname'] = $result ['nickname'];
		$user ['group_id'] = $result ['group_id'];
			$user ['avatar_id'] = $result ['avatar_id'];
		$data ['cmd'] = CloudsearchDoc::DOC_UPDATE;
		$data ['fields'] = $user;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->update ( json_encode ( array (
				$data 
		) ), 'user_user' );
		return $msg;
	}
	public function addCountrys($results) {
		foreach ( $results as $key => $result ) {
			$country ['id'] = $result ['id'];
			$country ['country_name'] = $result ['country_name'];
			$data [$key] ['cmd'] = CloudsearchDoc::DOC_ADD;
			$data [$key] ['fields'] = $country;
		}
		
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( $data ), 'system_country' );
		return $msg;
	}
	public function addCountry($result) {
		$country ['id'] = $result ['id'];
		$country ['country_name'] = $result ['country_name'];
		
		$data ['cmd'] = CloudsearchDoc::DOC_ADD;
		$data ['fields'] = $country;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( array (
				$data 
		) ), 'system_country' );
		return $msg;
	}
	public function editCountry($result) {
		$country ['id'] = $result ['id'];
		$country ['country_name'] = $result ['country_name'];
		$data ['cmd'] = CloudsearchDoc::DOC_UPDATE;
		$data ['fields'] = $country;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->update ( json_encode ( array (
				$data 
		) ), 'system_country' );
		return $msg;
	}
	public function addUserGroups($results) {
		foreach ( $results as $key => $result ) {
			$group ['id'] = $result ['id'];
			$group ['group_name'] = $result ['group_name'];
			$data [$key] ['cmd'] = CloudsearchDoc::DOC_ADD;
			$data [$key] ['fields'] = $group;
		}
		
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( $data ), 'user_group' );
		return $msg;
	}
	public function addUserGroup($result) {
		$group ['id'] = $result ['id'];
		$group ['group_name'] = $result ['group_name'];
		
		$data ['cmd'] = CloudsearchDoc::DOC_ADD;
		$data ['fields'] = $group;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( array (
				$data 
		) ), 'user_group' );
		return $msg;
	}
	public function editUserGroup($result) {
		$group ['id'] = $result ['id'];
		$group ['group_name'] = $result ['group_name'];
		$data ['cmd'] = CloudsearchDoc::DOC_UPDATE;
		$data ['fields'] = $group;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->update ( json_encode ( array (
				$data 
		) ), 'user_group' );
		return $msg;
	}
	public function addSystemGames($results) {
		foreach ( $results as $key => $result ) {
			$game ['id'] = $result ['id'];
			$game ['name'] = $result ['name'];
			$game ['title'] = $result ['title'];
			$data [$key] ['cmd'] = CloudsearchDoc::DOC_ADD;
			$data [$key] ['fields'] = $game;
		}
		
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( $data ), 'system_game' );
		return $msg;
	}
	public function addSystemGame($result) {
		$game ['id'] = $result ['id'];
		$game ['name'] = $result ['name'];
		$game ['title'] = $result ['title'];
		$data ['cmd'] = CloudsearchDoc::DOC_ADD;
		$data ['fields'] = $game;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( array (
				$data 
		) ), 'system_game' );
		return $msg;
	}
	public function editSystemGame($result) {
		$game ['id'] = $result ['id'];
		$game ['name'] = $result ['name'];
		$game ['title'] = $result ['title'];
		$data ['cmd'] = CloudsearchDoc::DOC_UPDATE;
		$data ['fields'] = $game;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->update ( json_encode ( array (
				$data 
		) ), 'system_game' );
		return $msg;
	}
	
	
	public function addVideoCategorys($results) {
		foreach ( $results as $key => $result ) {
			$category ['id'] = $result ['id'];
			$category ['category_name'] = $result ['category_name'];
			$data [$key] ['cmd'] = CloudsearchDoc::DOC_ADD;
			$data [$key] ['fields'] = $category;
		}
		
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( $data ), 'video_category' );
		return $msg;
	}
	
	
	public function addVideoCategory($result) {
		$category ['id'] = $result ['id'];
		$category ['category_name'] = $result ['category_name'];
		$data ['cmd'] = CloudsearchDoc::DOC_ADD;
		$data ['fields'] = $category;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( array (
				$data 
		) ), 'video_category' );
		return $msg;
	}
	
	
	public function editVideoCategory($result) {
		$category ['id'] = $result ['id'];
		$category ['category_name'] = $result ['category_name'];
		$data ['cmd'] = CloudsearchDoc::DOC_UPDATE;
		$data ['fields'] = $category;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->update ( json_encode ( array (
				$data 
		) ), 'video_category' );
		return $msg;
	}
	public function addVideos($results) {
		foreach ( $results as $key => $result ) {
			
			
			$video ['id'] = $result ['id'];
			$video ['uid'] = $result ['uid'];
				$video ['category_id'] = $result ['category_id'];
			$video ['game_id'] = $result ['game_id'];
			$video ['video_title'] = $result ['video_title'];
			$video ['video_intro'] = $result ['video_intro'];
			$video ['video_tags'] = $result ['video_tags'];
			$video ['video_users'] = $result ['video_users'];
			$video ['country_id'] = $result ['country_id'];
			$video ['picture_id'] = $result ['picture_id'];
			$video ['status'] = $result ['status'];
			
			$data [$key] ['cmd'] = CloudsearchDoc::DOC_ADD;
			$data [$key] ['fields'] = $video;
		}
		
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( $data ), 'video_video' );
		return $msg;
	}
	
	
	public function updateVideos($results) {
		foreach ( $results as $key => $result ) {
			$video ['id'] = $result ['id'];
			$video ['uid'] = $result ['uid'];
			$video ['category_id'] = $result ['category_id'];
			$video ['game_id'] = $result ['game_id'];
			$video ['video_title'] = $result ['video_title'];
			$video ['video_intro'] = $result ['video_intro'];
			$video ['video_tags'] = $result ['video_tags'];
			$video ['video_users'] = $result ['video_users'];
			$video ['country_id'] = $result ['country_id'];
			$video ['picture_id'] = $result ['picture_id'];
			$video ['status'] = $result ['status'];
				
			$data [$key] ['cmd'] = CloudsearchDoc::DOC_UPDATE;
			$data [$key] ['fields'] = $video;
		}
	
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( $data ), 'video_video' );
		return $msg;
	}
	
	
	public function addVideo($result) {
		$video ['id'] = $result ['id'];
		$video ['uid'] = $result ['uid'];
			$video ['category_id'] = $result ['category_id'];
		$video ['game_id'] = $result ['game_id'];
		$video ['video_title'] = $result ['video_title'];
		$video ['video_intro'] = $result ['video_intro'];
		$video ['video_tags'] = $result ['video_tags'];
		$video ['video_users'] = $result ['video_users'];
		$video ['country_id'] = $result ['country_id'];
		$video ['picture_id'] = $result ['picture_id'];
		$video ['status'] = $result ['status'];
		$data ['cmd'] = CloudsearchDoc::DOC_ADD;
		$data ['fields'] = $video;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->add ( json_encode ( array (
				$data 
		) ), 'video_video' );
		return $msg;
	}
	public function editVideo($result) {
		$video ['id'] = $result ['id'];
		$video ['uid'] = $result ['uid'];
			$video ['category_id'] = $result ['category_id'];
		$video ['game_id'] = $result ['game_id'];
		$video ['video_title'] = $result ['video_title'];
		$video ['video_intro'] = $result ['video_intro'];
		$video ['video_tags'] = $result ['video_tags'];
		$video ['video_users'] = $result ['video_users'];
		$video ['country_id'] = $result ['country_id'];
		$video ['picture_id'] = $result ['picture_id'];
		$video ['status'] = $result ['status'];
		$data ['cmd'] = CloudsearchDoc::DOC_UPDATE;
		$data ['fields'] = $video;
		$client = new CloudsearchClient ();
		$doc = new CloudsearchDoc ( C ( 'SEARCH_APP' ), $client );
		$msg = $doc->update ( json_encode ( array (
				$data 
		) ), 'video_video' );
		return $msg;
	}
}

?>