<?php
namespace Article\Controller;

use Common\Controller\BaseController;

class DcPictureController extends BaseController {

	/**
	 * 上传图片
	 */
	public function uploadCoverPicture() {
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'DcCover' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'ARTICLE_COVER_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		$return ['status'] = 1;
		/* 记录图片信息 */
		if ($info) {
			$return ['status'] = 1;
			$return = array_merge ( $info ['download'], $return );
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
	public function uploadArticlePicture() {
		$return  = array('error' => 0, 'info' => '上传成功', 'data' => '');
		$Picture = D ( 'DcPicture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'ARTICLE_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
	/* 记录附件信息 */
		if($info){
			$return['url'] = $info['imgFile']['url'];
			unset($return['info'], $return['data']);
		} else {
			$return['error'] = 1;
			$return['message']   = session('upload_error');
		}

		/* 返回JSON数据 */
		exit(json_encode($return));
		 
	}
}
?>