<?php
// +----------------------------------------------------------------------
// | all for fight
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.quntiao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Rocks <http://www.thinkphp.cn>
// +----------------------------------------------------------------------

/**
 * 前台配置文件
 * 所有除开系统级别的前台配置
 */
return array(
    /* 数据缓存设置 */
    'DATA_CACHE_PREFIX'    => 'quntiao_', // 缓存前缀
    'DATA_CACHE_TYPE'      => 'File', // 数据缓存类型

  /* URL配置 */
    'URL_CASE_INSENSITIVE' => false, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 3, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符
	'URL_HTML_SUFFIX'=>'html',
 	'TEMP_PATH'=>'./Upload/Temp/',
    

    /* 图片上传相关配置 */
    'AVATAR_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'rootPath' => 'avatar/', //保存根路径
		'savePath' => 'avatar/',//保存路径
		'saveName' => 'big', //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => 'jpg', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    

     /* 图片上传相关配置 */
    'COMMENTATOR_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'commentator/picture/', //保存根路径
		'savePath' => 'commentator/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
         /* 图片上传相关配置 */
    'MASTER_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'master/picture/', //保存根路径
		'savePath' => 'master/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
 

     /* 图片上传相关配置 */
    'SERIES_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'series/picture/', //保存根路径
		'savePath' => 'series/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）

    
            /* 图片上传相关配置 */
    'AD_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'ad/picture/', //保存根路径
		'savePath' => 'ad/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
    
        /* 图片上传相关配置 */
    'MATCH_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'match/picture/', //保存根路径
		'savePath' => 'match/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
    

        /* 图片上传相关配置 */
    'LIVE_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'live/picture/', //保存根路径
		'savePath' => 'live/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
    

    /* 图片上传相关配置 */
    'LIVERECOMMEND_PICTURE_UPLOAD' => array(
    		'mimes'    => '', //允许上传的文件MiMe类型
    		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
    		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
    		'autoSub'  => true, //自动子目录保存文件
    		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
    		'rootPath' => 'live/recommend/', //保存根路径
    		'savePath' => 'live/recommend/',//保存路径
    		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
    		'saveExt'  => '', //文件保存后缀，空则使用原后缀
    		'replace'  => false, //存在同名是否覆盖
    		'hash'     => true, //是否生成hash编码
    		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
    
    
    
        /* 图片上传相关配置 */
    'ALBUM_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'album/picture/', //保存根路径
		'savePath' => 'album/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
    
    
    
        /* 图片上传相关配置 */
    'GAME_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'game/picture/', //保存根路径
		'savePath' => 'game/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
       /* 图片上传相关配置 */
    'TEAM_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'team/picture/', //保存根路径
		'savePath' => 'team/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => 'jpg', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
    
            /* 图片上传相关配置 */
    'VIDEO_PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => 'video/picture/', //保存根路径
		'savePath' => 'video/picture/',//保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
    
    /* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
    		'mimes'    => '', //允许上传的文件MiMe类型
    		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
    		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
    		'autoSub'  => true, //自动子目录保存文件
    		'subName'  => array('date', 'Y/md/h'),  //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
    		'rootPath' => 'other/picture/', //保存根路径
    		'savePath' => 'other/picture/',//保存路径
    		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
    		'saveExt'  => '', //文件保存后缀，空则使用原后缀
    		'replace'  => false, //存在同名是否覆盖
    		'hash'     => true, //是否生成hash编码
    		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）

    'PICTURE_UPLOAD_DRIVER'=>'OSS',
    //本地上传文件驱动配置
    'UPLOAD_LOCAL_CONFIG'=>array(),
    'UPLOAD_OSS_CONFIG'=>array(
        'AccessId'=>'d84uO5P0nEFasg6v',
        'AccessKey'=>'wfEMKekzXWTkhry1HsOdA84AchJiYv',
        'bucket'=>'quntiao',
    	'cdn'=>'http://image.quntiao.com',
        'rename'=>false
    ),
 
   

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
    ),

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'quntiao_admin', //session前缀
    'COOKIE_PREFIX'  => 'quntiao_admin_', // Cookie前缀 避免冲突
    'VAR_SESSION_ID' => 'session_id',	//修复uploadify插件无法传递session_id的bug

    /* 后台错误页面模板 */
    'TMPL_ACTION_ERROR'     =>  MODULE_PATH.'View/Public/error.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/Public/success.html', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE'   =>  MODULE_PATH.'View/Public/exception.html',// 异常页面的模板文件

);
