<?php
namespace Common\Model;

use Think\Model;

class AppSlideModel extends Model {

 
	protected function _after_select(&$resultSet, $options) {
		foreach ( $resultSet as $key =>$result  ) {
		
			$picture = get_slide_cover ( $result ['cover_id'] ,'url' );
			if (empty ( $picture )) {
				$result ['slide_picture'] = "http://image.lol.zhanglubao.com/default/default-video.jpg";
			} else {
				$result ['slide_picture'] = $picture;
				unset($result ['cover_id']);
			}
			$resultSet [$key] = $result;
		}
	}

	protected function _after_find(&$result, $options) {
		$picture = get_slide_cover ( $result ['cover_id'],'url' );
		if (empty ( $picture )) {
			$result ['slide_picture'] = "http://image.lol.zhanglubao.com/default/default-video.jpg";
		} else {
			$result ['slide_picture'] = $picture;
		}
	}
}
?>