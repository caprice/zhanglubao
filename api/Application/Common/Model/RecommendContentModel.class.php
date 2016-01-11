<?php

namespace Common\Model;

use Think\Model;

class RecommendContentModel extends Model {
	
	 
	
	
	protected function _after_select(&$resultSet, $options) {
		foreach ( $resultSet as $key => $result ) {
		if (! empty($result ['picture_id'])) {
			$picture = M ( 'RecommendPicture' )->where ( 'id=' . $result ['picture_id'] )->getField ( 'url' );
			$result ['rec_picture'] = $picture;
		}
			$resultSet [$key] = $result;
		}
	}
 
}

?>