<?php
/**
 * 前台配置文件
 * 所有除开系统级别的前台配置
 */
return array (
		'TMPL_PARSE_STRING' => array (
				'__STATIC__' => __ROOT__ . '/Public/Static',
				'__IMG__' => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
				'__CSS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
				'__JS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/js' 
		),
		
		/* 编辑器图片上传相关配置 */
		'EDITOR_UPLOAD' => array (
				'mimes' => '', // 允许上传的文件MiMe类型
				'maxSize' => 2 * 1024 * 1024, // 上传的文件大小限制 (0-不做限制)
				'exts' => 'jpg,gif,png,jpeg', // 允许上传的文件后缀
				'autoSub' => true, // 自动子目录保存文件
				'subName' => array (
						'date',
						'Y-m-d' 
				), // 子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
				'rootPath' => './Uploads/Editor/', // 保存根路径
				'savePath' => '', // 保存路径
				'saveName' => array (
						'uniqid',
						'' 
				), // 上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
				'saveExt' => '', // 文件保存后缀，空则使用原后缀
				'replace' => false, // 存在同名是否覆盖
				'hash' => true, // 是否生成hash编码
				'callback' => false  // 检测文件是否存在回调函数，如果存在返回文件信息数组
				),
		
		
		'TMPL_ACTION_ERROR' => MODULE_PATH . 'View/Public/error.html',
		'TMPL_ACTION_SUCCESS' => MODULE_PATH . 'View/Public/success.html',
		'TMPL_EXCEPTION_FILE' => MODULE_PATH . 'View/Public/exception.html' 
);
