<?php
$config = array (
		
		'APP_GROUP_LIST' => 'Home,Video,Space,User,Search,Sniffer,Category',
		'DEFAULT_GROUP' => 'Home',
		'APP_SUB_DOMAIN_DEPLOY' => 1,
		
	 
		
        'SHOW_PAGE_TRACE' => false,
		'URL_PATHINFO_DEPR' => '-',
		'URL_MODEL' => 2, 
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
		'DB_HOST' => 'localhost',  
		'DB_NAME' => 'lol',  
		'DB_USER' => 'root',  
		'DB_PWD' => '', 
		'DB_PORT' => '3306',  
		'DB_PREFIX' => 'pq_', 

		'SEARCH_KEY' => '',
		'SEARCH_SECRET' => '',
		'SEARCH_APP' => '',
		'SEARCH_USER_APP' => '',
		
		
		/* 数据缓存设置 */
		'DATA_CACHE_PREFIX' => 'api_v1_',
		'DATA_CACHE_TYPE' => 'Aliocs',
		'MEMCACHED_SERVER' => '',
		'MEMCACHED_PORT' => 11211,
		'MEMCACHED_USERNAME' => '',
		'MEMCACHED_PASSWORD' => '',
		
		
 
		'SESSION_AUTO_START'    =>  false,
		'SESSION_PREFIX' => 'api_v1_',
		'COOKIE_PREFIX' => 'api_v1_',
		'VAR_SESSION_ID' => 'session_id' 
)
;

return $config;