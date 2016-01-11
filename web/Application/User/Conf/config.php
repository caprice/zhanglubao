<?php
// +----------------------------------------------------------------------
// | all for fight
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.quntiao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Rocks 
// +----------------------------------------------------------------------

/**
 * UCenter客户端配置文件
 * 注意：该配置文件请使用常量方式定义
 */

define('UC_APP_ID', 1); //应用ID
define('UC_API_TYPE', 'Model'); //可选值 Model / Service
define('UC_AUTH_KEY', 'Y:QzkUGm[v*bj.eP9?yn^F0Iaq$|TN{@E)S=4J"7'); //加密KEY
define('UC_DB_DSN', 'mysqli://root:@127.0.0.1:3306/quntiao'); // 数据库连接，使用Model方式调用API必须配置此项
define('UC_TABLE_PREFIX', 'quntiao_'); // 数据表前缀，使用Model方式调用API必须配置此项
