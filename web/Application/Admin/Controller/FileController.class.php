<?php
// +----------------------------------------------------------------------
// | all for fight
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.quntiao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Rocks
// +----------------------------------------------------------------------
namespace Admin\Controller;

/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */
class FileController extends AdminController {
	
	/* 文件上传 */
	public function upload() {
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		/* 调用文件上传组件上传文件 */
		$File = D ( 'File' );
		$file_driver = C ( 'DOWNLOAD_UPLOAD_DRIVER' );
		$info = $File->upload ( $_FILES, C ( 'DOWNLOAD_UPLOAD' ), C ( 'DOWNLOAD_UPLOAD_DRIVER' ), C ( "UPLOAD_{$file_driver}_CONFIG" ) );
		
		/* 记录附件信息 */
		if ($info) {
			$return ['data'] = think_encrypt ( json_encode ( $info ['download'] ) );
			$return ['info'] = $info ['download'] ['name'];
		} else {
			$return ['status'] = 0;
			$return ['info'] = $File->getError ();
		}
		
		/* 返回JSON数据 */
		$this->ajaxReturn ( $return );
	}
	
	/* 下载文件 */
	public function download($id = null) {
		if (empty ( $id ) || ! is_numeric ( $id )) {
			$this->error ( '参数错误！' );
		}
		
		$logic = D ( 'Download', 'Logic' );
		if (! $logic->download ( $id )) {
			$this->error ( $logic->getError () );
		}
	}
	
	
 
	
	
	/**
	 * 上传图片
	 */
	public function uploadMasterPic() {
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'MASTER_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	public function uploadCommentatorPic() {
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'COMMENTATOR_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	public function uploadAdPic() {
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'AD_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	 * 
	 * @author Rocks
	 */
	public function uploadSeriesPic() {
		// TODO: 用户登录检测
		
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'SERIES_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	 * 
	 * @author Rocks
	 */
	public function uploadMatchPic() {
		// TODO: 用户登录检测
		
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'MATCH_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	public function uploadAblumPic() {
		// TODO: 用户登录检测
		
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'ALBUM_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	 * 
	 * @author Rocks
	 */
	public function uploadGamePic() {
		// TODO: 用户登录检测
		
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'GAME_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	 * 
	 * @author Rocks
	 */
	public function uploadLivePic() {
		// TODO: 用户登录检测
		
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'LIVE_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	 * 
	 * @author Rocks
	 */
	public function uploadLiveRecommendPic() {
		// TODO: 用户登录检测
		
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'LIVE_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	 * 
	 * @author Rocks
	 */
	public function uploadTeamPic() {
		// TODO: 用户登录检测
		
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'TEAM_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
	 * 
	 * @author Rocks
	 */
	public function uploadPicture() {
		// TODO: 用户登录检测
		
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'Picture' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		
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
}
