<?php
/**
 * 支持的字段有
 * member表中的所有字段，ucenter_member表中的所有字段
 * 等级：title
 * 头像：avatar32 avatar64 avatar128 avatar256 avatar512
 * 个人中心地址：space_url
 * 认证图标：icons_html
 *
 * @param $fields array|string 如果是数组，则返回数组。如果不是数组，则返回对应的值
 * @param null $pictureid
 * @return array|null
 */
function query_picture($fields, $pictureid = null)
{
	//如果fields不是数组，则返回值也不是数组
	if (!is_array($fields)) {
		$result = query_picture(array($fields), $pictureid);
		return $result[$fields];
	}

	//默认获取自己的资料
	$pictureid = $pictureid ? $pictureid : 1;
	if (!$pictureid) {
		return null;
	}

	//查询缓存，过滤掉已缓存的字段
	$cachedFields = array();
	$cacheResult = array();
	foreach ($fields as $field) {
		$cache = read_query_picture_cache($pictureid, $field);
		if (!empty($cache)) {
			$cacheResult[$field] = $cache;
			$cachedFields[] = $field;
		}
	}

	 
	//获取两张用户表格中的所有字段
	$pictureModel = M('Picture');
	$pictureFields = $pictureModel->getDbFields();
	$pictureFields = array_intersect($pictureFields, $fields);

	
	//查询需要的字段
	$pictureResult = array();
	if ($pictureFields) {
		$pictureResult = $pictureModel->where(array('id' => $pictureid))->field($pictureFields)->find();
	}
	//读取头像数据
	$result = array();

 

	//合并结果，不包括缓存
	$result = array_merge($pictureResult, $result);

	//写入缓存
	foreach ($result as $field => $value) {
		$result[$field] = $value;
		write_query_picture_cache($pictureid, $field, str_replace('"', '', $value));
	}

	//合并结果，包括缓存
	$result = array_merge($result, $cacheResult);
	//返回结果
	return $result;
}

function read_query_picture_cache($pictureid, $field)
{
	return S("query_picture_{$pictureid}_{$field}");
}

function write_query_picture_cache($pictureid, $field, $value)
{
	return S("query_picture_{$pictureid}_{$field}", $value, 300);
}

function clean_query_picture_cache($pictureid, $field)
{
	if (is_array($field)) {
		foreach ($field as $field_item) {
			S("query_picture_{$pictureid}_{$field_item}", null);
		}
	}
	S("query_picture_{$pictureid}_{$field}", null);
}