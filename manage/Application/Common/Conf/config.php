<?php
$config = array (
	 
		'DEFAULT_MODULE' => 'Home',
 
		
        'SHOW_PAGE_TRACE' => false,
		'URL_PATHINFO_DEPR' => '-',
		'URL_MODEL' => 3, 
		'URL_CASE_INSENSITIVE' => true, 
		
        /* 系统数据加密设置 */
       'DATA_AUTH_KEY' => 'VA;MgBW&iKn(3X:m5v=)T@hpE4J{sNL}b,"1|7D[',  
	 
	
		
		/* 用户相关设置 */
		'USER_MAX_CACHE' => 1000, 
		'USER_ADMINISTRATOR' => 1, 
		
		'SECURE_CODE' => 'VA;MgBW&iKn(3X:m5v=)T@hpE4J{sNL}b,"1|7D[',
		
   		 /* 全局过滤配置 */
   		'DEFAULT_FILTER' => '',  
		'CDN_IMG_HOST' => 'http://image.lol.zhanglubao.com/',
		 
 		
		
		/* 数据库配置 */
		'DB_TYPE' => 'mysqli', 
		'DB_HOST' => '',  
		'DB_NAME' => 'lol',  
		'DB_USER' => '',  
		'DB_PWD' => '', 
		'DB_PORT' => '3306',  
		'DB_PREFIX' => 'pq_', 

		'SEARCH_KEY' => '',
		'SEARCH_SECRET' => '',
		'SEARCH_APP' => 'lol',
		'SEARCH_USER_APP' => 'lol_user',
		
		
		/* 数据缓存设置 */
		'DATA_CACHE_PREFIX' => 'api_v1_',
		'DATA_CACHE_TYPE' => 'Aliocs',
		'MEMCACHED_SERVER' => '',
		'MEMCACHED_PORT' => 11211,
		'MEMCACHED_USERNAME' => '',
		'MEMCACHED_PASSWORD' => '',
		
		
		
		/* 图片上传相关配置 */
		'APP_PICTURE_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h'
				),
				'rootPath' => 'app/',
				'savePath' => 'app/',
				'saveName' => array (
						'uniqid',
						''
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false
		),
		
		/* 图片上传相关配置 */
		'HERO_AVATAR_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h'
				),
				'rootPath' => 'lol/hero/',
				'savePath' => 'lol/hero/',
				'saveName' => array (
						'uniqid',
						''
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false
		),
		
		/* 图片上传相关配置 */
		'ARTICLE_COVER_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h'
				),
				'rootPath' => 'article/cover/',
				'savePath' => 'article/cover/',
				'saveName' => array (
						'uniqid',
						''
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false
		),
		

		/* 图片上传相关配置 */
		'ARTICLE_PICTURE_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h'
				),
				'rootPath' => 'article/content/',
				'savePath' => 'article/content/',
				'saveName' => array (
						'uniqid',
						''
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false
		),
		
		
    /* 图片上传相关配置 */
    'VIDEO_PICTURE_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h' 
				),
				'rootPath' => 'video/',
				'savePath' => 'video/',
				'saveName' => array (
						'uniqid',
						'' 
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false 
		),
		'RECOMMEND_PICTURE_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h' 
				),
				'rootPath' => 'recommend/',
				'savePath' => 'recommend/',
				'saveName' => array (
						'uniqid',
						'' 
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false 
		),
		'ALBUM_PICTURE_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h' 
				),
				'rootPath' => 'album/',
				'savePath' => 'album/',
				'saveName' => array (
						'uniqid',
						'' 
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false 
		),
		'AVATAR_PICTURE_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h' 
				),
				'rootPath' => 'avatar/',
				'savePath' => 'avatar/',
				'saveName' => array (
						'uniqid',
						'' 
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false 
		),
		'ADMIN_PICTURE_UPLOAD' => array (
				'mimes' => '',
				'maxSize' => 2 * 1024 * 1024,
				'exts' => 'jpg,gif,png,jpeg',
				'autoSub' => true,
				'subName' => array (
						'date',
						'Y/md/h' 
				),
				'rootPath' => 'admin/avatar/',
				'savePath' => 'admin/avatar/',
				'saveName' => array (
						'uniqid',
						'' 
				),
				'saveExt' => '',
				'replace' => false,
				'hash' => true,
				'callback' => false 
		),
		'PICTURE_UPLOAD_DRIVER' => 'OSS',
		// 本地上传文件驱动配置
		'UPLOAD_LOCAL_CONFIG' => array (),
		'UPLOAD_OSS_CONFIG' => array (
				'AccessId' => '',
				'AccessKey' => '',
				'bucket' => 'zlb-lol',
				'cdn' => 'http://image.lol.zhanglubao.com',
				'rename' => false 
		),
		'SESSION_PREFIX' => 'qt_v1_admin',
		'COOKIE_PREFIX' => 'qt_v1_admin_',
		'VAR_SESSION_ID' => 'session_id',
		'TMPL_ACTION_ERROR' => 'Common/View/Public/error.html',
		'TMPL_ACTION_SUCCESS' => 'Common/View/Public/success.html',
		'TMPL_EXCEPTION_FILE' => 'Common/View/Public/exception.html' 
);
return $config;