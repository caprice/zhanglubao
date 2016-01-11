<?php

namespace Video\Widget;

use Think\Action;

class SideAlbumWidget extends Action {
	
	
	public function albums() {
		 $albums = S ( 'v_i_sal' );
		if (empty ( $albums )) {
			$map ['status'] = 1;
			$albums = D ( 'VideoAlbum' )->getAlbumsInfo ( $map, 18 ,'id desc');
			S ( 'v_i_sal', $albums, 8600 );
		}
		$this->assign('albums',$albums);
		
		$this->display('Widget/Side/sidealbums');
	}
}

?>