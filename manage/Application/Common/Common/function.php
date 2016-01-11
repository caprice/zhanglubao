<?php
const QUNTIAO_VERSION = '1.0';
const QUNTIAO_ADDON_PATH = './Addons/';
/**
 * 检测当前用户是否为管理员
 *
 * @return boolean true-管理员，false-非管理员
 * @author Rocks
 */
function is_administrator($uid = null) {
	$uid = is_null ( $uid ) ? is_admin_login () : $uid;
	return $uid && (intval ( $uid ) === C ( 'USER_ADMINISTRATOR' ));
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 *
 * @param string $str
 *        	要分割的字符串
 * @param string $glue
 *        	分割符
 * @return array
 * @author Rocks
 */
function str2arr($str, $glue = ',') {
	return explode ( $glue, $str );
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 *
 * @param array $arr
 *        	要连接的数组
 * @param string $glue
 *        	分割符
 * @return string
 * @author Rocks
 */
function arr2str($arr, $glue = ',') {
	return implode ( $glue, $arr );
}

/**
 * 字符串截取，支持中文和其他编码
 *
 * @static
 *
 *
 *
 *
 *
 * @access public
 * @param string $str
 *        	需要转换的字符串
 * @param string $start
 *        	开始位置
 * @param string $length
 *        	截取长度
 * @param string $charset
 *        	编码格式
 * @param string $suffix
 *        	截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
	if (function_exists ( "mb_substr" ))
		$slice = mb_substr ( $str, $start, $length, $charset );
	elseif (function_exists ( 'iconv_substr' )) {
		$slice = iconv_substr ( $str, $start, $length, $charset );
		if (false === $slice) {
			$slice = '';
		}
	} else {
		$re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all ( $re [$charset], $str, $match );
		$slice = join ( "", array_slice ( $match [0], $start, $length ) );
	}
	return $suffix ? $slice . '...' : $slice;
}

/**
 * 系统加密方法
 *
 * @param string $data
 *        	要加密的字符串
 * @param string $key
 *        	加密密钥
 * @param int $expire
 *        	过期时间 单位 秒
 * @return string
 * @author Rocks
 */
function think_encrypt($data, $key = '', $expire = 0) {
	$key = md5 ( empty ( $key ) ? C ( 'DATA_AUTH_KEY' ) : $key );
	$data = base64_encode ( $data );
	$x = 0;
	$len = strlen ( $data );
	$l = strlen ( $key );
	$char = '';
	
	for($i = 0; $i < $len; $i ++) {
		if ($x == $l)
			$x = 0;
		$char .= substr ( $key, $x, 1 );
		$x ++;
	}
	
	$str = sprintf ( '%010d', $expire ? $expire + time () : 0 );
	
	for($i = 0; $i < $len; $i ++) {
		$str .= chr ( ord ( substr ( $data, $i, 1 ) ) + (ord ( substr ( $char, $i, 1 ) )) % 256 );
	}
	return str_replace ( array (
			'+',
			'/',
			'=' 
	), array (
			'-',
			'_',
			'' 
	), base64_encode ( $str ) );
}

/**
 * 系统解密方法
 *
 * @param string $data
 *        	要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key
 *        	加密密钥
 * @return string
 * @author Rocks
 */
function think_decrypt($data, $key = '') {
	$key = md5 ( empty ( $key ) ? C ( 'DATA_AUTH_KEY' ) : $key );
	$data = str_replace ( array (
			'-',
			'_' 
	), array (
			'+',
			'/' 
	), $data );
	$mod4 = strlen ( $data ) % 4;
	if ($mod4) {
		$data .= substr ( '====', $mod4 );
	}
	$data = base64_decode ( $data );
	$expire = substr ( $data, 0, 10 );
	$data = substr ( $data, 10 );
	
	if ($expire > 0 && $expire < time ()) {
		return '';
	}
	$x = 0;
	$len = strlen ( $data );
	$l = strlen ( $key );
	$char = $str = '';
	
	for($i = 0; $i < $len; $i ++) {
		if ($x == $l)
			$x = 0;
		$char .= substr ( $key, $x, 1 );
		$x ++;
	}
	
	for($i = 0; $i < $len; $i ++) {
		if (ord ( substr ( $data, $i, 1 ) ) < ord ( substr ( $char, $i, 1 ) )) {
			$str .= chr ( (ord ( substr ( $data, $i, 1 ) ) + 256) - ord ( substr ( $char, $i, 1 ) ) );
		} else {
			$str .= chr ( ord ( substr ( $data, $i, 1 ) ) - ord ( substr ( $char, $i, 1 ) ) );
		}
	}
	return base64_decode ( $str );
}

/**
 * 数据签名认证
 *
 * @param array $data
 *        	被认证的数据
 * @return string 签名
 * @author Rocks
 */
function data_auth_sign($data) {
	// 数据类型检测
	if (! is_array ( $data )) {
		$data = ( array ) $data;
	}
	ksort ( $data ); // 排序
	$code = http_build_query ( $data ); // url编码并生成query字符串
	$sign = sha1 ( $code ); // 生成签名
	return $sign;
}

/**
 * 对查询结果集进行排序
 *
 * @access public
 * @param array $list
 *        	查询结果
 * @param string $field
 *        	排序的字段名
 * @param array $sortby
 *        	排序类型
 *        	asc正向排序 desc逆向排序 nat自然排序
 * @return array
 *
 */
function list_sort_by($list, $field, $sortby = 'asc') {
	if (is_array ( $list )) {
		$refer = $resultSet = array ();
		foreach ( $list as $i => $data )
			$refer [$i] = &$data [$field];
		switch ($sortby) {
			case 'asc' : // 正向排序
				asort ( $refer );
				break;
			case 'desc' : // 逆向排序
				arsort ( $refer );
				break;
			case 'nat' : // 自然排序
				natcasesort ( $refer );
				break;
		}
		foreach ( $refer as $key => $val )
			$resultSet [] = &$list [$key];
		return $resultSet;
	}
	return false;
}

/**
 * 把返回的数据集转换成Tree
 *
 * @param array $list
 *        	要转换的数据集
 * @param string $pid
 *        	parent标记字段
 * @param string $level
 *        	level标记字段
 * @return array
 * @author Rocks
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
	// 创建Tree
	$tree = array ();
	if (is_array ( $list )) {
		// 创建基于主键的数组引用
		$refer = array ();
		foreach ( $list as $key => $data ) {
			$refer [$data [$pk]] = & $list [$key];
		}
		foreach ( $list as $key => $data ) {
			// 判断是否存在parent
			$parentId = $data [$pid];
			if ($root == $parentId) {
				$tree [] = & $list [$key];
			} else {
				if (isset ( $refer [$parentId] )) {
					$parent = & $refer [$parentId];
					$parent [$child] [] = & $list [$key];
				}
			}
		}
	}
	return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 *
 * @param array $tree
 *        	原来的树
 * @param string $child
 *        	孩子节点的键
 * @param string $order
 *        	排序显示的键，一般是主键 升序排列
 * @param array $list
 *        	过渡用的中间数组，
 * @return array 返回排过序的列表数组
 * @author Rocks
 */
function tree_to_list($tree, $child = '_child', $order = 'id', &$list = array()) {
	if (is_array ( $tree )) {
		$refer = array ();
		foreach ( $tree as $key => $value ) {
			$reffer = $value;
			if (isset ( $reffer [$child] )) {
				unset ( $reffer [$child] );
				tree_to_list ( $value [$child], $child, $order, $list );
			}
			$list [] = $reffer;
		}
		$list = list_sort_by ( $list, $order, $sortby = 'asc' );
	}
	return $list;
}

/**
 * 格式化字节大小
 *
 * @param number $size
 *        	字节数
 * @param string $delimiter
 *        	数字和单位分隔符
 * @return string 格式化后的带单位的大小
 * @author Rocks
 */
function format_bytes($size, $delimiter = '') {
	$units = array (
			'B',
			'KB',
			'MB',
			'GB',
			'TB',
			'PB' 
	);
	for($i = 0; $size >= 1024 && $i < 5; $i ++)
		$size /= 1024;
	return round ( $size, 2 ) . $delimiter . $units [$i];
}

/**
 * 设置跳转页面URL
 * 使用函数再次封装，方便以后选择不同的存储方式（目前使用cookie存储）
 *
 * @author Rocks
 */
function set_redirect_url($url) {
	cookie ( 'redirect_url', $url );
}

/**
 * 获取跳转页面URL
 *
 * @return string 跳转页URL
 * @author Rocks
 */
function get_redirect_url() {
	$url = cookie ( 'redirect_url' );
	return empty ( $url ) ? __APP__ : $url;
}

/**
 * 处理插件钩子
 *
 * @param string $hook
 *        	钩子名称
 * @param mixed $params
 *        	传入参数
 * @return void
 */
function hook($hook, $params = array()) {
 
	\Think\Hook::listen ( $hook, $params );
}

/**
 * 获取插件类的类名
 *
 * @param strng $name
 *        	插件名
 */
function get_addon_class($name) {
	$class = "Addons\\{$name}\\{$name}Addon";
	return $class;
}

/**
 * 获取插件类的配置文件数组
 *
 * @param string $name
 *        	插件名
 */
function get_addon_config($name) {
	$class = get_addon_class ( $name );
	if (class_exists ( $class )) {
		$addon = new $class ();
		return $addon->getConfig ();
	} else {
		return array ();
	}
}

/**
 * 插件显示内容里生成访问插件的url
 *
 * @param string $url
 *        	url
 * @param array $param
 *        	参数
 * @author Rocks
 */
function addons_url($url, $param = array()) {
	$url = parse_url ( $url );
	$case = C ( 'URL_CASE_INSENSITIVE' );
	$addons = $case ? parse_name ( $url ['scheme'] ) : $url ['scheme'];
	$controller = $case ? parse_name ( $url ['host'] ) : $url ['host'];
	$action = trim ( $case ? strtolower ( $url ['path'] ) : $url ['path'], '/' );
	
	/* 解析URL带的参数 */
	if (isset ( $url ['query'] )) {
		parse_str ( $url ['query'], $query );
		$param = array_merge ( $query, $param );
	}
	
	/* 基础参数 */
	$params = array (
			'_addons' => $addons,
			'_controller' => $controller,
			'_action' => $action 
	);
	$params = array_merge ( $params, $param ); // 添加额外参数
	
	return U ( 'Addons/execute', $params );
}

/**
 * 时间戳格式化
 *
 * @param int $time        	
 * @return string 完整的时间显示
 * @author Rocks
 */
function time_format($time = NULL, $format = 'Y-m-d H:i') {
	$time = $time === NULL ? NOW_TIME : intval ( $time );
	return date ( $format, $time );
}

/**
 * 获取分类信息并缓存分类
 *
 * @param integer $id
 *        	分类ID
 * @param string $field
 *        	要获取的字段名
 * @return string 分类信息
 */
function get_category($id, $field = null) {
	static $list;
	
	/* 非法分类ID */
	if (empty ( $id ) || ! is_numeric ( $id )) {
		return '';
	}
	
	/* 读取缓存数据 */
	if (empty ( $list )) {
		$list = S ( 'sys_category_list' );
	}
	
	/* 获取分类名称 */
	if (! isset ( $list [$id] )) {
		$cate = M ( 'BookCategory' )->find ( $id );
		if (! $cate || 1 != $cate ['status']) { // 不存在分类，或分类被禁用
			return '';
		}
		$list [$id] = $cate;
		S ( 'sys_category_list', $list ); // 更新缓存
	}
	return is_null ( $field ) ? $list [$id] : $list [$id] [$field];
}

/* 根据ID获取分类标识 */
function get_category_name($id) {
	return get_category ( $id, 'name' );
}

/* 根据ID获取分类名称 */
function get_category_title($id) {
	return get_category ( $id, 'title' );
}

/**
 * 解析UBB数据
 *
 * @param string $data
 *        	UBB字符串
 * @return string 解析为HTML的数据
 * @author Rocks
 */
function ubb($data) {
	// TODO: 待完善，目前返回原始数据
	return $data;
}

/**
 * 解析行为规则
 * 规则定义 table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
 * 规则字段解释：table->要操作的数据表，不需要加表前缀；
 * field->要操作的字段；
 * condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户
 * rule->对字段进行的具体操作，目前支持四则混合运算，如：1+score*2/2-3
 * cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次
 * max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）
 * 单个行为后可加 ； 连接其他规则
 *
 * @param string $action
 *        	行为id或者name
 * @param int $self
 *        	替换规则里的变量为执行用户的id
 * @return boolean array: ， 成功返回规则数组
 * @author Rocks
 */
function parse_action($action = null, $self) {
	if (empty ( $action )) {
		return false;
	}
	
	// 参数支持id或者name
	if (is_numeric ( $action )) {
		$map = array (
				'id' => $action 
		);
	} else {
		$map = array (
				'name' => $action 
		);
	}
	
	// 查询行为信息
	$info = M ( 'Action' )->where ( $map )->find ();
	if (! $info || $info ['status'] != 1) {
		return false;
	}
	
	// 解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
	$rules = $info ['rule'];
	$rules = str_replace ( '{$self}', $self, $rules );
	$rules = explode ( ';', $rules );
	$return = array ();
	foreach ( $rules as $key => &$rule ) {
		$rule = explode ( '|', $rule );
		foreach ( $rule as $k => $fields ) {
			$field = empty ( $fields ) ? array () : explode ( ':', $fields );
			if (! empty ( $field )) {
				$return [$key] [$field [0]] = $field [1];
			}
		}
		// cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件
		if (! array_key_exists ( 'cycle', $return [$key] ) || ! array_key_exists ( 'max', $return [$key] )) {
			unset ( $return [$key] ['cycle'], $return [$key] ['max'] );
		}
	}
	
	return $return;
}

/**
 * 执行行为
 *
 * @param array $rules
 *        	解析后的规则数组
 * @param int $action_id
 *        	行为id
 * @param array $user_id
 *        	执行的用户id
 * @return boolean false 失败 ， true 成功
 * @author Rocks
 */
function execute_action($rules = false, $action_id = null, $user_id = null) {
	if (! $rules || empty ( $action_id ) || empty ( $user_id )) {
		return false;
	}
	
	$return = true;
	foreach ( $rules as $rule ) {
		
		// 检查执行周期
		$map = array (
				'action_id' => $action_id,
				'user_id' => $user_id 
		);
		$map ['create_time'] = array (
				'gt',
				NOW_TIME - intval ( $rule ['cycle'] ) * 3600 
		);
		$exec_count = M ( 'ActionLog' )->where ( $map )->count ();
		if ($exec_count > $rule ['max']) {
			continue;
		}
		
		// 执行数据库操作
		$Model = M ( ucfirst ( $rule ['table'] ) );
		$field = $rule ['field'];
		$res = $Model->where ( $rule ['condition'] )->setField ( $field, array (
				'exp',
				$rule ['rule'] 
		) );
		
		if (! $res) {
			$return = false;
		}
	}
	return $return;
}

// 基于数组创建目录和文件
function create_dir_or_files($files) {
	foreach ( $files as $key => $value ) {
		if (substr ( $value, - 1 ) == '/') {
			mkdir ( $value );
		} else {
			@file_put_contents ( $value, '' );
		}
	}
}

if (! function_exists ( 'array_column' )) {
	function array_column(array $input, $columnKey, $indexKey = null) {
		$result = array ();
		if (null === $indexKey) {
			if (null === $columnKey) {
				$result = array_values ( $input );
			} else {
				foreach ( $input as $row ) {
					$result [] = $row [$columnKey];
				}
			}
		} else {
			if (null === $columnKey) {
				foreach ( $input as $row ) {
					$result [$row [$indexKey]] = $row;
				}
			} else {
				foreach ( $input as $row ) {
					$result [$row [$indexKey]] = $row [$columnKey];
				}
			}
		}
		return $result;
	}
}

/**
 * 获取表名（不含表前缀）
 *
 * @param string $model_id        	
 * @return string 表名
 * @author Rocks
 */
function get_table_name($model_id = null) {
	if (empty ( $model_id )) {
		return false;
	}
	$Model = M ( 'Model' );
	$name = '';
	$info = $Model->getById ( $model_id );
	if ($info ['extend'] != 0) {
		$name = $Model->getFieldById ( $info ['extend'], 'name' ) . '_';
	}
	$name .= $info ['name'];
	return $name;
}

/**
 * 获取属性信息并缓存
 *
 * @param integer $id
 *        	属性ID
 * @param string $field
 *        	要获取的字段名
 * @return string 属性信息
 */
function get_model_attribute($model_id, $group = true) {
	static $list;
	
	/* 非法ID */
	if (empty ( $model_id ) || ! is_numeric ( $model_id )) {
		return '';
	}
	
	/* 读取缓存数据 */
	if (empty ( $list )) {
		$list = S ( 'attribute_list' );
	}
	
	/* 获取属性 */
	if (! isset ( $list [$model_id] )) {
		$map = array (
				'model_id' => $model_id 
		);
		$extend = M ( 'Model' )->getFieldById ( $model_id, 'extend' );
		
		if ($extend) {
			$map = array (
					'model_id' => array (
							"in",
							array (
									$model_id,
									$extend 
							) 
					) 
			);
		}
		$info = M ( 'Attribute' )->where ( $map )->select ();
		$list [$model_id] = $info;
		// S('attribute_list', $list); //更新缓存
	}
	
	$attr = array ();
	foreach ( $list [$model_id] as $value ) {
		$attr [$value ['id']] = $value;
	}
	
	if ($group) {
		$sort = M ( 'Model' )->getFieldById ( $model_id, 'field_sort' );
		
		if (empty ( $sort )) { // 未排序
			$group = array (
					1 => array_merge ( $attr ) 
			);
		} else {
			$group = json_decode ( $sort, true );
			
			$keys = array_keys ( $group );
			foreach ( $group as &$value ) {
				foreach ( $value as $key => $val ) {
					$value [$key] = $attr [$val];
					unset ( $attr [$val] );
				}
			}
			
			if (! empty ( $attr )) {
				$group [$keys [0]] = array_merge ( $group [$keys [0]], $attr );
			}
		}
		$attr = $group;
	}
	return $attr;
}

/**
 * 调用系统的API接口方法（静态方法）
 * api('User/getName','id=5'); 调用公共模块的User接口的getName方法
 * api('Admin/User/getName','id=5'); 调用Admin模块的User接口
 *
 * @param string $name
 *        	格式 [模块名]/接口名/方法名
 * @param array|string $vars
 *        	参数
 */
function api($name, $vars = array()) {
	$array = explode ( '/', $name );
	$method = array_pop ( $array );
	$classname = array_pop ( $array );
	$module = $array ? array_pop ( $array ) : 'Common';
	$callback = $module . '\\Api\\' . $classname . 'Api::' . $method;
	if (is_string ( $vars )) {
		parse_str ( $vars, $vars );
	}
	return call_user_func_array ( $callback, $vars );
}

/**
 * 根据条件字段获取指定表的数据
 *
 * @param mixed $value
 *        	条件，可用常量或者数组
 * @param string $condition
 *        	条件字段
 * @param string $field
 *        	需要返回的字段，不传则返回整个数据
 * @param string $table
 *        	需要查询的表
 * @author Rocks
 */
function get_table_field($value = null, $condition = 'id', $field = null, $table = null) {
	if (empty ( $value ) || empty ( $table )) {
		return false;
	}
	
	// 拼接参数
	$map [$condition] = $value;
	$info = M ( ucfirst ( $table ) )->where ( $map );
	if (empty ( $field )) {
		$info = $info->field ( true )->find ();
	} else {
		$info = $info->getField ( $field );
	}
	return $info;
}

/**
 * 获取链接信息
 *
 * @param int $link_id        	
 * @param string $field        	
 * @return 完整的链接信息或者某一字段
 * @author Rocks
 */
function get_link($link_id = null, $field = 'url') {
	$link = '';
	if (empty ( $link_id )) {
		return $link;
	}
	$link = M ( 'Url' )->getById ( $link_id );
	if (empty ( $field )) {
		return $link;
	} else {
		return $link [$field];
	}
}

/**
 * 获取文档封面图片
 *
 * @param int $cover_id        	
 * @param string $field        	
 * @return 完整的数据 或者 指定的$field字段值
 * @author Rocks
 */
function get_cover($cover_id, $field = null) {
	if (empty ( $cover_id )) {
		return false;
	}
	$picture = M ( 'Picture' )->where ( array (
			'status' => 1 
	) )->getById ( $cover_id );
	return empty ( $field ) ? $picture : $picture [$field];
}

/**
 * @param int $cover_id
 * @param string $field
 * @return 完整的数据 或者 指定的$field字段值
 * @author Rocks
 */
function get_slide_cover($cover_id, $field = null) {
	if (empty ( $cover_id )) {
		return false;
	}
	$picture = M ( 'AppPicture' )->where ( array (
			'status' => 1
	) )->getById ( $cover_id );
	return empty ( $field ) ? $picture : $picture [$field];
}

/**
 * @param int $cover_id
 * @param string $field
 * @return 完整的数据 或者 指定的$field字段值
 * @author Rocks
 */
function get_hero_avatar($picture_id, $field = null) {
	if (empty ( $picture_id )) {
		return false;
	}
	$picture = M ( 'LolAvatar' )->where ( array (
			'status' => 1
	) )->getById ( $picture_id );
	return empty ( $field ) ? $picture : $picture [$field];
}

/**
 * 获取文档封面图片
 *
 * @param int $cover_id        	
 * @param string $field        	
 * @return 完整的数据 或者 指定的$field字段值
 * @author Rocks
 */
function get_album_cover($cover_id, $field = null) {
	if (empty ( $cover_id )) {
		return false;
	}
	$picture = M ( 'AlbumPicture' )->where ( array (
			'status' => 1 
	) )->getById ( $cover_id );
	return empty ( $field ) ? $picture : $picture [$field];
}

/**
 * 检查$pos(推荐位的值)是否包含指定推荐位$contain
 *
 * @param number $pos
 *        	推荐位的值
 * @param number $contain
 *        	指定推荐位
 * @return boolean true 包含 ， false 不包含
 * @author Rocks
 */
function check_document_position($pos = 0, $contain = 0) {
	if (empty ( $pos ) || empty ( $contain )) {
		return false;
	}
	
	// 将两个参数进行按位与运算，不为0则表示$contain属于$pos
	$res = $pos & $contain;
	if ($res !== 0) {
		return true;
	} else {
		return false;
	}
}

/**
 * 获取数据的所有子孙数据的id值
 *
 * @author Rocks
 */
function get_stemma($pids, Model &$model, $field = 'id') {
	$collection = array ();
	
	// 非空判断
	if (empty ( $pids )) {
		return $collection;
	}
	
	if (is_array ( $pids )) {
		$pids = trim ( implode ( ',', $pids ), ',' );
	}
	$result = $model->field ( $field )->where ( array (
			'pid' => array (
					'IN',
					( string ) $pids 
			) 
	) )->select ();
	$child_ids = array_column ( ( array ) $result, 'id' );
	
	while ( ! empty ( $child_ids ) ) {
		$collection = array_merge ( $collection, $result );
		$result = $model->field ( $field )->where ( array (
				'pid' => array (
						'IN',
						$child_ids 
				) 
		) )->select ();
		$child_ids = array_column ( ( array ) $result, 'id' );
	}
	return $collection;
}

/**
 * h函数用于过滤不安全的html标签，输出安全的html
 *
 * @param string $text
 *        	待过滤的字符串
 * @param string $type
 *        	保留的标签格式
 * @return string 处理后内容
 */
function op_h($text, $type = 'html') {
	// 无标签格式
	$text_tags = '';
	// 只保留链接
	$link_tags = '<a>';
	// 只保留图片
	$image_tags = '<img>';
	// 只存在字体样式
	$font_tags = '<i><b><u><s><em><strong><font><big><small><sup><sub><bdo><h1><h2><h3><h4><h5><h6>';
	// 标题摘要基本格式
	$base_tags = $font_tags . '<p><br><hr><a><img><map><area><pre><code><q><blockquote><acronym><cite><ins><del><center><strike>';
	// 兼容Form格式
	$form_tags = $base_tags . '<form><input><textarea><button><select><optgroup><option><label><fieldset><legend>';
	// 内容等允许HTML的格式
	$html_tags = $base_tags . '<ul><ol><li><dl><dd><dt><table><caption><td><th><tr><thead><tbody><tfoot><col><colgroup><div><span><object><embed><param>';
	// 专题等全HTML格式
	$all_tags = $form_tags . $html_tags . '<!DOCTYPE><meta><html><head><title><body><base><basefont><script><noscript><applet><object><param><style><frame><frameset><noframes><iframe>';
	// 过滤标签
	$text = real_strip_tags ( $text, ${$type . '_tags'} );
	// 过滤攻击代码
	if ($type != 'all') {
		// 过滤危险的属性，如：过滤on事件lang js
		while ( preg_match ( '/(<[^><]+)(ondblclick|onclick|onload|onerror|unload|onmouseover|onmouseup|onmouseout|onmousedown|onkeydown|onkeypress|onkeyup|onblur|onchange|onfocus|action|background|codebase|dynsrc|lowsrc)([^><]*)/i', $text, $mat ) ) {
			$text = str_ireplace ( $mat [0], $mat [1] . $mat [3], $text );
		}
		while ( preg_match ( '/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat ) ) {
			$text = str_ireplace ( $mat [0], $mat [1] . $mat [3], $text );
		}
	}
	return $text;
}
function real_strip_tags($str, $allowable_tags = "") {
	$str = html_entity_decode ( $str, ENT_QUOTES, 'UTF-8' );
	return strip_tags ( $str, $allowable_tags );
}
function cdnimg($path) {
	return C ( 'CDN_IMG_HOST' ) . $path;
}

/**
 * t函数用于过滤标签，输出没有html的干净的文本
 *
 * @param
 *        	string text 文本内容
 * @return string 处理后内容
 */
function op_t($text) {
	$text = nl2br ( $text );
	$text = real_strip_tags ( $text );
	$text = addslashes ( $text );
	$text = trim ( $text );
	return $text;
}

/**
 * 检测验证码
 * 
 * @param integer $id
 *        	验证码ID
 * @return boolean 检测结果
 * @author Rocks
 */
function check_verify($code, $id = 1) {
	$verify = new \Think\Verify ();
	return $verify->check ( $code, $id );
}

/**
 * 系统公共库文件
 * 主要定义系统公共函数库
 */

/**
 * 检测用户是否登录
 *
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author Rocks
 */
function is_admin_login() {
	$user = session ( 'admin_user_auth' );
	if (empty ( $user )) {
		return 0;
	} else {
		return session ( 'admin_user_auth_sign' ) == data_auth_sign ( $user ) ? $user ['id'] : 0;
	}
}
function get_admin_name() {
	$user = session ( 'admin_user_auth' );
	if (empty ( $user )) {
		return 0;
	} else {
		return session ( 'admin_user_auth_sign' ) == data_auth_sign ( $user ) ? $user ['username'] : 0;
	}
}

/**
 * 记录行为日志，并执行该行为的规则
 *
 * @param string $action
 *        	行为标识
 * @param string $model
 *        	触发行为的模型名
 * @param int $record_id
 *        	触发行为的记录id
 * @param int $user_id
 *        	执行行为的用户id
 * @return boolean
 * @author Rocks
 */
function admin_action_log($action = null, $model = null, $record_id = null, $admin_id = null) {
	
	// 参数检查
	if (empty ( $action ) || empty ( $model ) || empty ( $record_id )) {
		return '参数不能为空';
	}
	if (empty ( $admin_id )) {
		$admin_id = is_admin_login ();
	}
	
	// 查询行为,判断是否执行
	$action_info = M ( 'AdminAction' )->getByName ( $action );
	if ($action_info ['status'] != 1) {
		return '该行为被禁用或删除';
	}
	
	// 插入行为日志
	$data ['action_id'] = $action_info ['id'];
	$data ['admin_id'] = $admin_id;
	$data ['action_ip'] = ip2long ( get_client_ip () );
	$data ['model'] = $model;
	$data ['record_id'] = $record_id;
	$data ['create_time'] = NOW_TIME;
	
	// 解析日志规则,生成日志备注
	if (! empty ( $action_info ['log'] )) {
		if (preg_match_all ( '/\[(\S+?)\]/', $action_info ['log'], $match )) {
			$log ['user'] = $admin_id;
			$log ['record'] = $record_id;
			$log ['model'] = $model;
			$log ['time'] = NOW_TIME;
			$log ['data'] = array (
					'user' => $admin_id,
					'model' => $model,
					'record' => $record_id,
					'time' => NOW_TIME 
			);
			foreach ( $match [1] as $value ) {
				$param = explode ( '|', $value );
				if (isset ( $param [1] )) {
					$replace [] = call_user_func ( $param [1], $log [$param [0]] );
				} else {
					$replace [] = $log [$param [0]];
				}
			}
			$data ['remark'] = str_replace ( $match [0], $replace, $action_info ['log'] );
		} else {
			$data ['remark'] = $action_info ['log'];
		}
	} else {
		// 未定义日志规则，记录操作url
		$data ['remark'] = '操作url：' . $_SERVER ['REQUEST_URI'];
	}
	
	M ( 'AdminActionLog' )->add ( $data );
	
	if (! empty ( $action_info ['rule'] )) {
		// 解析行为
		$rules = parse_admin_action ( $action, $admin_id );
		
		// 执行行为
		$res = execute_admin_action ( $rules, $action_info ['id'], $admin_id );
	}
}

/**
 * 解析行为规则
 * 规则定义 table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
 * 规则字段解释：table->要操作的数据表，不需要加表前缀；
 * field->要操作的字段；
 * condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户
 * rule->对字段进行的具体操作，目前支持四则混合运算，如：1+score*2/2-3
 * cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次
 * max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）
 * 单个行为后可加 ； 连接其他规则
 *
 * @param string $action
 *        	行为id或者name
 * @param int $self
 *        	替换规则里的变量为执行用户的id
 * @return boolean array: ， 成功返回规则数组
 * @author Rocks
 */
function parse_admin_action($action = null, $self) {
	if (empty ( $action )) {
		return false;
	}
	
	// 参数支持id或者name
	if (is_numeric ( $action )) {
		$map = array (
				'id' => $action 
		);
	} else {
		$map = array (
				'name' => $action 
		);
	}
	
	// 查询行为信息
	$info = M ( 'AdminAction' )->where ( $map )->find ();
	if (! $info || $info ['status'] != 1) {
		return false;
	}
	
	// 解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
	$rules = $info ['rule'];
	$rules = str_replace ( '{$self}', $self, $rules );
	$rules = explode ( ';', $rules );
	$return = array ();
	foreach ( $rules as $key => &$rule ) {
		$rule = explode ( '|', $rule );
		foreach ( $rule as $k => $fields ) {
			$field = empty ( $fields ) ? array () : explode ( ':', $fields );
			if (! empty ( $field )) {
				$return [$key] [$field [0]] = $field [1];
			}
		}
		// cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件
		if (! array_key_exists ( 'cycle', $return [$key] ) || ! array_key_exists ( 'max', $return [$key] )) {
			unset ( $return [$key] ['cycle'], $return [$key] ['max'] );
		}
	}
	
	return $return;
}

/**
 * 执行行为
 *
 * @param array $rules
 *        	解析后的规则数组
 * @param int $action_id
 *        	行为id
 * @param array $user_id
 *        	执行的用户id
 * @return boolean false 失败 ， true 成功
 * @author Rocks
 */
function execute_admin_action($rules = false, $action_id = null, $user_id = null) {
	if (! $rules || empty ( $action_id ) || empty ( $user_id )) {
		return false;
	}
	
	$return = true;
	foreach ( $rules as $rule ) {
		
		// 检查执行周期
		$map = array (
				'action_id' => $action_id,
				'user_id' => $user_id 
		);
		$map ['create_time'] = array (
				'gt',
				NOW_TIME - intval ( $rule ['cycle'] ) * 3600 
		);
		$exec_count = M ( 'AdminActionLog' )->where ( $map )->count ();
		if ($exec_count > $rule ['max']) {
			continue;
		}
		
		// 执行数据库操作
		$Model = M ( ucfirst ( $rule ['table'] ) );
		$field = $rule ['field'];
		$res = $Model->where ( $rule ['condition'] )->setField ( $field, array (
				'exp',
				$rule ['rule'] 
		) );
		
		if (! $res) {
			$return = false;
		}
	}
	return $return;
}
function think_ucenter_md5($str, $key = 'ThinkUCenter') {
	return '' === $str ? '' : md5 ( sha1 ( $str ) . $key );
}

/**
 * 系统加密方法
 *
 * @param string $data
 *        	要加密的字符串
 * @param string $key
 *        	加密密钥
 * @param int $expire
 *        	过期时间 (单位:秒)
 * @return string
 */
function think_ucenter_encrypt($data, $key, $expire = 0) {
	$key = md5 ( $key );
	$data = base64_encode ( $data );
	$x = 0;
	$len = strlen ( $data );
	$l = strlen ( $key );
	$char = '';
	for($i = 0; $i < $len; $i ++) {
		if ($x == $l)
			$x = 0;
		$char .= substr ( $key, $x, 1 );
		$x ++;
	}
	$str = sprintf ( '%010d', $expire ? $expire + time () : 0 );
	for($i = 0; $i < $len; $i ++) {
		$str .= chr ( ord ( substr ( $data, $i, 1 ) ) + (ord ( substr ( $char, $i, 1 ) )) % 256 );
	}
	return str_replace ( '=', '', base64_encode ( $str ) );
}

/**
 * 系统解密方法
 *
 * @param string $data
 *        	要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key
 *        	加密密钥
 * @return string
 */
function think_ucenter_decrypt($data, $key) {
	$key = md5 ( $key );
	$x = 0;
	$data = base64_decode ( $data );
	$expire = substr ( $data, 0, 10 );
	$data = substr ( $data, 10 );
	if ($expire > 0 && $expire < time ()) {
		return '';
	}
	$len = strlen ( $data );
	$l = strlen ( $key );
	$char = $str = '';
	for($i = 0; $i < $len; $i ++) {
		if ($x == $l)
			$x = 0;
		$char .= substr ( $key, $x, 1 );
		$x ++;
	}
	for($i = 0; $i < $len; $i ++) {
		if (ord ( substr ( $data, $i, 1 ) ) < ord ( substr ( $char, $i, 1 ) )) {
			$str .= chr ( (ord ( substr ( $data, $i, 1 ) ) + 256) - ord ( substr ( $char, $i, 1 ) ) );
		} else {
			$str .= chr ( ord ( substr ( $data, $i, 1 ) ) - ord ( substr ( $char, $i, 1 ) ) );
		}
	}
	return base64_decode ( $str );
}

/**
 * 后台公共文件
 * 主要定义后台公共函数库
 */

/* 解析列表定义规则 */
function get_list_field($data, $grid, $model) {
	
	// 获取当前字段数据
	foreach ( $grid ['field'] as $field ) {
		$array = explode ( '|', $field );
		$temp = $data [$array [0]];
		// 函数支持
		if (isset ( $array [1] )) {
			$temp = call_user_func ( $array [1], $temp );
		}
		$data2 [$array [0]] = $temp;
	}
	if (! empty ( $grid ['format'] )) {
		$value = preg_replace_callback ( '/\[([a-z_]+)\]/', function ($match) use($data2) {
			return $data2 [$match [1]];
		}, $grid ['format'] );
	} else {
		$value = implode ( ' ', $data2 );
	}
	
	// 链接支持
	if (! empty ( $grid ['href'] )) {
		$links = explode ( ',', $grid ['href'] );
		foreach ( $links as $link ) {
			$array = explode ( '|', $link );
			$href = $array [0];
			if (preg_match ( '/^\[([a-z_]+)\]$/', $href, $matches )) {
				$val [] = $data2 [$matches [1]];
			} else {
				$show = isset ( $array [1] ) ? $array [1] : $value;
				// 替换系统特殊字符串
				$href = str_replace ( array (
						'[DELETE]',
						'[EDIT]',
						'[MODEL]' 
				), array (
						'del?ids=[id]&model=[MODEL]',
						'edit?id=[id]&model=[MODEL]',
						$model ['id'] 
				), $href );
				
				// 替换数据变量
				$href = preg_replace_callback ( '/\[([a-z_]+)\]/', function ($match) use($data) {
					return $data [$match [1]];
				}, $href );
				
				$val [] = '<a href="' . U ( $href ) . '">' . $show . '</a>';
			}
		}
		$value = implode ( ' ', $val );
	}
	return $value;
}

// 获取模型名称
function get_model_by_id($id) {
	return $model = M ( 'Model' )->getFieldById ( $id, 'title' );
}

// 获取属性类型信息
function get_attribute_type($type = '') {
	// TODO 可以加入系统配置
	static $_type = array (
			'num' => array (
					'数字',
					'int(10) UNSIGNED NOT NULL' 
			),
			'string' => array (
					'字符串',
					'varchar(255) NOT NULL' 
			),
			'textarea' => array (
					'文本框',
					'text NOT NULL' 
			),
			'datetime' => array (
					'时间',
					'int(10) NOT NULL' 
			),
			'bool' => array (
					'布尔',
					'tinyint(2) NOT NULL' 
			),
			'select' => array (
					'枚举',
					'char(50) NOT NULL' 
			),
			'radio' => array (
					'单选',
					'char(10) NOT NULL' 
			),
			'checkbox' => array (
					'多选',
					'varchar(100) NOT NULL' 
			),
			'editor' => array (
					'编辑器',
					'text NOT NULL' 
			),
			'picture' => array (
					'上传图片',
					'int(10) UNSIGNED NOT NULL' 
			),
			'file' => array (
					'上传附件',
					'int(10) UNSIGNED NOT NULL' 
			) 
	);
	return $type ? $_type [$type] [0] : $_type;
}

/**
 * 获取对应状态的文字信息
 *
 * @param int $status        	
 * @return string 状态文字 ，false 未获取到
 * @author Rocks
 */
function get_status_title($status = null) {
	if (! isset ( $status )) {
		return false;
	}
	switch ($status) {
		case - 1 :
			return '已删除';
			break;
		case 0 :
			return '禁用';
			break;
		case 1 :
			return '正常';
			break;
		case 2 :
			return '待审核';
			break;
		default :
			return false;
			break;
	}
}

// 获取数据的状态操作
function show_status_op($status) {
	switch ($status) {
		case 0 :
			return '启用';
			break;
		case 1 :
			return '禁用';
			break;
		case 2 :
			return '审核';
			break;
		default :
			return false;
			break;
	}
}

/**
 * 获取文档的类型文字
 *
 * @param string $type        	
 * @return string 状态文字 ，false 未获取到
 * @author Rocks
 */
function get_document_type($type = null) {
	if (! isset ( $type )) {
		return false;
	}
	switch ($type) {
		case 1 :
			return '目录';
			break;
		case 2 :
			return '主题';
			break;
		case 3 :
			return '段落';
			break;
		default :
			return false;
			break;
	}
}

/**
 * 获取配置的类型
 *
 * @param string $type
 *        	配置类型
 * @return string
 */
function get_config_type($type = 0) {
	echo "here";
	$list = C ( 'CONFIG_TYPE_LIST' );
	return $list [$type];
}

/**
 * 获取配置的分组
 *
 * @param string $group
 *        	配置分组
 * @return string
 */
function get_config_group($group = 0) {
	$list = C ( 'CONFIG_GROUP_LIST' );
	return $group ? $list [$group] : '';
}

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map
 *        	映射关系二维数组 array(
 *        	'字段名1'=>array(映射关系数组),
 *        	'字段名2'=>array(映射关系数组),
 *        	......
 *        	)
 * @author Rocks
 * @return array array(
 *         array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *         ....
 *         )
 *        
 */
function int_to_string(&$data, $map = array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'))) {
	if ($data === false || $data === null) {
		return $data;
	}
	$data = ( array ) $data;
	foreach ( $data as $key => $row ) {
		foreach ( $map as $col => $pair ) {
			if (isset ( $row [$col] ) && isset ( $pair [$row [$col]] )) {
				$data [$key] [$col . '_text'] = $pair [$row [$col]];
			}
		}
	}
	return $data;
}

/**
 * 动态扩展左侧菜单,base.html里用到
 *
 * @author Rocks
 */
function extra_menu($extra_menu, &$base_menu) {
	foreach ( $extra_menu as $key => $group ) {
		if (isset ( $base_menu ['child'] [$key] )) {
			$base_menu ['child'] [$key] = array_merge ( $base_menu ['child'] [$key], $group );
		} else {
			$base_menu ['child'] [$key] = $group;
		}
	}
}

/**
 * 获取参数的所有父级分类
 *
 * @param int $cid
 *        	分类id
 * @return array 参数分类和父类的信息集合
 * @author Rocks
 */
function get_parent_category($cid) {
	if (empty ( $cid )) {
		return false;
	}
	$cates = M ( 'BookCategory' )->where ( array (
			'status' => 1 
	) )->field ( 'id,title,pid' )->order ( 'sort' )->select ();
	$child = get_category ( $cid ); // 获取参数分类的信息
	$pid = $child ['pid'];
	$temp = array ();
	$res [] = $child;
	while ( true ) {
		foreach ( $cates as $key => $cate ) {
			if ($cate ['id'] == $pid) {
				$pid = $cate ['pid'];
				array_unshift ( $res, $cate ); // 将父分类插入到数组第一个元素前
			}
		}
		if ($pid == 0) {
			break;
		}
	}
	return $res;
}

// 分析枚举类型配置值 格式 a:名称1,b:名称2
function parse_config_attr($string) {
	$array = preg_split ( '/[,;\r\n]+/', trim ( $string, ",;\r\n" ) );
	if (strpos ( $string, ':' )) {
		$value = array ();
		foreach ( $array as $val ) {
			list ( $k, $v ) = explode ( ':', $val );
			$value [$k] = $v;
		}
	} else {
		$value = $array;
	}
	return $value;
}

// 分析枚举类型字段值 格式 a:名称1,b:名称2
// 暂时和 parse_config_attr功能相同
// 但请不要互相使用，后期会调整
function parse_field_attr($string) {
	if (0 === strpos ( $string, ':' )) {
		// 采用函数定义
		return eval ( substr ( $string, 1 ) . ';' );
	}
	$array = preg_split ( '/[,;\r\n]+/', trim ( $string, ",;\r\n" ) );
	if (strpos ( $string, ':' )) {
		$value = array ();
		foreach ( $array as $val ) {
			list ( $k, $v ) = explode ( ':', $val );
			$value [$k] = $v;
		}
	} else {
		$value = $array;
	}
	return $value;
}

/**
 * 获取行为数据
 *
 * @param string $id
 *        	行为id
 * @param string $field
 *        	需要获取的字段
 * @author Rocks
 */
function get_admin_action($id = null, $field = null) {
	if (empty ( $id ) && ! is_numeric ( $id )) {
		return false;
	}
	$list = S ( 'action_list' );
	if (empty ( $list [$id] )) {
		$map = array (
				'status' => array (
						'gt',
						- 1 
				),
				'id' => $id 
		);
		$list [$id] = M ( 'AdminAction' )->where ( $map )->field ( true )->find ();
	}
	return empty ( $field ) ? $list [$id] : $list [$id] [$field];
}

/**
 * 获取行为类型
 *
 * @param intger $type
 *        	类型
 * @param bool $all
 *        	是否返回全部类型
 * @author Rocks
 */
function get_admin_action_type($type, $all = false) {
	$list = array (
			1 => '系统',
			2 => '用户' 
	);
	if ($all) {
		return $list;
	}
	return $list [$type];
}

/**
 * 根据用户ID获取用户名
 * 
 * @param integer $uid
 *        	用户ID
 * @return string 用户名
 */
function get_usergroup($uid = 0) {
	$User = D ( 'Common/UserUser' );
	$info = $User->info ( $uid );
	return $info ['group_id'];
}

/**
 * 根据用户ID获取用户名
 * 
 * @param integer $uid
 *        	用户ID
 * @return string 用户名
 */
function get_nickname($uid = 0) {
	$User = D ( 'Common/UserUser' );
	$info = $User->info ( $uid );
	return $info ['nickname'];
}

/**
 * 根据用户ID获取用户名
 * 
 * @param integer $uid
 *        	用户ID
 * @return string 用户名
 */
function get_username($uid = 0) {
	$User = D ( 'Common/UserUser' );
	$info = $User->info ( $uid );
	return $info ['username'];
}

/**
 * 根据用户ID获取用户名
 * 
 * @param integer $uid
 *        	用户ID
 * @return string 用户名
 */
function get_user($uid = 0) {
	$User = D ( 'Common/UserUser' );
	$info = $User->info ( $uid );
	
	return $info;
}
function randomkeys($length) {
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
	for($i = 0; $i < $length; $i ++) {
		$key .= $pattern {mt_rand ( 0, 35 )}; // 生成php随机数
	}
	return $key;
}
function get_avatar($id, $field = null) {
	if (empty ( $id )) {
		return false;
	}
	$picture = M ( 'UserAvatar' )->where ( array (
			'status' => 1 
	) )->getById ( $id );
	return empty ( $field ) ? $picture : $picture [$field];
}
function get_admin_avatar($id, $field = null) {
	if (empty ( $id )) {
		return false;
	}
	$picture = M ( 'AdminAvatar' )->where ( array (
			'status' => 1 
	) )->getById ( $id );
	return empty ( $field ) ? $picture : $picture [$field];
}
function get_own_avatar() {
	$id = session ( 'admin_user_auth.avatar_id' );
	$field = 'url';
	if (empty ( $id )) {
		return false;
	}
	$picture = M ( 'AdminAvatar' )->where ( array (
			'status' => 1 
	) )->getById ( $id );
	return empty ( $field ) ? $picture : $picture [$field];
}
function get_video_picture($id, $field = null) {
	if (empty ( $id )) {
		return false;
	}
	
	$picture = M ( 'VideoPicture' )->where ( array (
			'status' => 1 
	) )->getById ( $id );
	return empty ( $field ) ? $picture : $picture [$field];
}
function get_album_picture($id, $field = null) {
	if (empty ( $id )) {
		return false;
	}
	
	$picture = M ( 'VideoAlbumPicture' )->where ( array (
			'status' => 1 
	) )->getById ( $id );
	return empty ( $field ) ? $picture : $picture [$field];
}


function get_rec_picture($id, $field = null) {
	if (empty ( $id )) {
		return false;
	}

	$picture = M ( 'RecommendPicture' )->where ( array (
			'status' => 1
	) )->getById ( $id );
	return empty ( $field ) ? $picture : $picture [$field];
}

function get_members($id) {
	$users = M ( 'UserTeam' )->where ( 'team_id=' . $id )->select ();
	foreach ( $users as $user ) {
		$ids [] = $user ['uid'];
	}
	return $ids;
}

require_once (APP_PATH . '/Common/Common/query_user.php');

