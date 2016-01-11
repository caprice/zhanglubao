<?php
namespace User\Controller;

use Common\Controller\BaseController;

class FavController extends BaseController {

	public function favs($page = 0) {
		if (is_login) {
			$data ['videos'] = D ( 'UserVideoFav' )->getFavList ($page,12);
			if (empty ( $data ['videos'] )) {
				$data ['videos'] = array ();
			}
			$data ['status'] = 1;
			$this->ajaxReturn ( $data );
		} else {
			$data ['status'] = 0;
			$this->ajaxReturn ( $data );
		}
	}
	
	
	public function fav($videoid) {
		if (is_login && ! empty ( $videoid )) {
			D ( 'UserVideoFav' )->fav ( $videoid );
			$data ['status'] = 1;
			$this->ajaxReturn ( $data );
		} else {
			$data ['status'] = 0;
			$this->ajaxReturn ( $data );
		}
	}

	public function unfav($videoids) {
		if (is_login && ! empty ( $videoids )) {
			D ( 'UserVideoFav' )->unfav ( $videoids );
			$data ['status'] = 1;
			$this->ajaxReturn ( $data );
		} else {
			$data ['status'] = 0;
			$this->ajaxReturn ( $data );
		}
	}
}
?>