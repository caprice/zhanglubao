<?php
namespace Common\Model;

use Think\Model;

class VideoAlbumModel extends Model {

	protected function _after_select(&$resultSet, $options) {
		foreach ( $resultSet as $key => $result ) {
			$picture = M ( 'VideoAlbumPicture' )->where ( 'id=' . $result ['picture_id'] )->getField ( 'url' );
			$result ['album_picture'] = $picture;
			unset ( $result ['picture_id'] );
			if (! empty ( $result ['uid'] )) {
				$result ['user'] = D ( 'UserUser' )->getUserInfo ( $result ['uid'] );
			}
			$resultSet [$key] = $result;
		}
	}

	protected function _after_find(&$result, $options) {
		$picture = M ( 'VideoAlbumPicture' )->where ( 'id=' . $result ['picture_id'] )->getField ( 'url' );
		$result ['album_picture'] = $picture;
		$result ['user'] = D ( 'UserUser' )->getUserInfo ( $result ['uid'] );
		$result ['game_title'] = get_game_title ( $result ['game_id'] );
		$result ['game_name'] = get_game_name ( $result ['game_id'] );
	}
}
?>