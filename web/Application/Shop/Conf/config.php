<?php

/**
 * 前台配置文件
 * 所有除开系统级别的前台配置
 */

return array(
        
    /* 主题设置 */
    'DEFAULT_THEME' =>  'default',  // 默认模板主题名称
   

    'DATA_CACHE_PREFIX' => 'quntiao_',  
    'DATA_CACHE_TYPE'   => 'File',  

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'qutiao_', //session前缀
    'COOKIE_PREFIX'  => 'qutiao_', // Cookie前缀 避免冲突


  /* URL配置 */
    'URL_CASE_INSENSITIVE' => false, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            =>2, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符
   

    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/Static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
	),
	
    


    'NEED_VERIFY'=>true,//此处控制默认是否需要审核，该配置项为了便于部署起见，暂时通过在此修改来设定。

);

