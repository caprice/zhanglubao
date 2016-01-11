<?php
$config= array(

    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' =>QUNTIAO_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common', 'User'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => TRUE,

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => 'VA;MgBW&iKn(3X:m5v=)T@hpE4J{sNL}b,"1|7D[', //默认数据加密KEY

    /* 调试配置 */

	'URL_MODEL'            => 3, //URL模式  默认关闭伪静态
		
    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID
	'URL_HTML_SUFFIX'=>'html',
		
		
  	'SECURE_CODE'=>'VA;MgBW&iKn(3X:m5v=)T@hpE4J{sNL}b,"1|7D[',

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数
    
	'CDN_HOST'=>'http://image.zhanglubao.com/',

    /* 数据库配置 */
    'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'quntiao', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => '', // 数据库表前缀

	 
	 

);
 

return $config;