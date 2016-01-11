<?php
namespace Common\Model;

use Think\Model;

class VideoVideoModel extends Model {

	public function updateHit($id) {
		 
		$this->where ( 'id=' . $id )->setInc ( "total_views", 1 );
		$lasttime = $this->where ( 'id=' . $id )->getField ( 'last_view' );
		$now = time ();
		if (date ( "Ymd", $lasttime ) == date ( "Ymd", $now )) {
			$this->where ( 'id=' . $id )->setInc ( "day_views", 1 );
		} else {
			$this->where ( 'id=' . $id )->setField ( "day_views", 1 );
		}
		if (date ( "YW", $lasttime ) == date ( "YW", $now )) {
			$this->where ( 'id=' . $id )->setInc ( "week_views", 1 );
		} else {
			$this->where ( 'id=' . $id )->setField ( "week_views", 1 );
		}
		if (date ( "Ym", $lasttime ) == date ( "Ym", $now )) {
			$this->where ( 'id=' . $id )->setInc ( "month_views", 1 );
		} else {
			$this->where ( 'id=' . $id )->setField ( "month_views", 1 );
		}
		$this->where ( 'id=' . $id )->setField ( 'last_view', $now );
	}

	public function getRelate($video_id, $uid) {
		$map ['uid'] = $uid;
		$map ['id'] = array (
				'lt',
				$video_id 
		);
		$uservideos = $this->where ( $map )->field ( 'id,picture_id,video_title' )->order ( 'id desc' )->limit ( 4 )->select ();
		if (empty($uservideos))
		{
			$uservideos=array();
		}
		$lastvideos = array ();
		if (count ( $uservideos ) < 4) {
			$lastvideos = $this->field ( 'id,picture_id,video_title' )->order ( 'id desc' )->limit ( 4 - count ( $uservideos ) )->select();
		}
		$videos = array_merge ( $uservideos, $lastvideos );
		return $videos;
	}

	protected function _after_select(&$resultSet, $options) {
		foreach ( $resultSet as $key => $result ) {
			$picture = M ( 'VideoPicture' )->where ( 'id=' . $result ['picture_id'] )->getField ( 'url' );
			if (empty ( $picture )) {
				$result ['video_picture'] = "http://img.quntiao.net/default/default-video.jpg";
			} else {
				$result ['video_picture'] = $picture;
				unset ( $result ['picture_id'] );
			}
			if (! empty ( $result ['uid'] )) {
				$result ['user'] =D ( 'UserUser' )->field ( 'uid,nickname,avatar_id' )->find($result['uid']);
			}
			if (! empty ( $result ['video_tags_detail'] )) {
				$result ['video_tags_detail'] = explode ( ',', $result ['video_tags'] );
			}
			$resultSet [$key] = $result;
		}
	}

	protected function _after_find(&$result, $options) {
		$picture = M ( 'VideoPicture' )->where ( 'id=' . $result ['picture_id'] )->getField ( 'url' );
		if (empty ( $picture )) {
			$result ['video_picture'] = "http://img.quntiao.net/default/default-video.jpg";
		} else {
			$result ['video_picture'] = $picture;
			unset ( $result ['picture_id'] );
		}
		if (! empty ( $result ['uid'] )) {
			$result ['user'] =D ( 'UserUser' )->field ( 'uid,nickname,avatar_id' )->find($result['uid']);
		}
	 
	}
}
?>