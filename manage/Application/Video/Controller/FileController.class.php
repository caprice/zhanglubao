<?php
 
namespace Video\Controller;

use Common\Controller\BaseController;
/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */
class FileController extends BaseController {
  	
	/**
	 * 上传图片
	 */
	public function uploadVideoPicture() {
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'VideoPicture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'VIDEO_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		$return ['status'] = 1;
 		/* 记录图片信息 */
		if ($info) {
			$return ['status'] = 1;
			$return = array_merge ( $info ['picture'], $return );
		} else {
			$return ['status'] = 0;
			$return ['info'] = $Picture->getError ();
		}
		 
		/* 返回JSON数据 */
		$this->ajaxReturn ( $return );
	}
	
	
	/**
	 * 上传图片
	 */
	public function uploadVideoAlbumPicture() {
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => ''
		);
		$Picture = D ( 'VideoAlbumPicture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'ALBUM_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		$return ['status'] = 1;
		if ($info) {
			$return ['status'] = 1;
			$return = array_merge ( $info ['picture'], $return );
		} else {
			$return ['status'] = 0;
			$return ['info'] = $Picture->getError ();
		}
			
		$this->ajaxReturn ( $return );
	}
	
 
}
