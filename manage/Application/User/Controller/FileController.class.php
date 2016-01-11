<?php
 
namespace User\Controller;

use Common\Controller\BaseController;
/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */
class FileController extends BaseController {
 
 
	
	
 
	
	
	/**
	 * 上传图片
	 */
	public function uploadAvatar() {
		 
		 
		/* 返回标准数据 */
		$return = array (
				'status' => 1,
				'info' => '上传成功',
				'data' => '' 
		);
		
		/* 调用文件上传组件上传文件 */
		$Picture = D ( 'UserAvatar' );
		$pic_driver = C ( 'PICTURE_UPLOAD_DRIVER' );
		$info = $Picture->upload ( $_FILES, C ( 'AVATAR_PICTURE_UPLOAD' ), C ( 'PICTURE_UPLOAD_DRIVER' ), C ( "UPLOAD_{$pic_driver}_CONFIG" ) ); // TODO:上传到远程服务器
		$return ['status'] = 1;
 		/* 记录图片信息 */
		if ($info) {
			$return ['status'] = 1;
			$return = array_merge ( $info ['avatar'], $return );
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
