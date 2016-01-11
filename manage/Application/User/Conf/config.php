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
		

		
		'TMPL_ACTION_ERROR' => MODULE_PATH . 'View/Public/error.html',
		'TMPL_ACTION_SUCCESS' => MODULE_PATH . 'View/Public/success.html',
		'TMPL_EXCEPTION_FILE' => MODULE_PATH . 'View/Public/exception.html' 
)
;
