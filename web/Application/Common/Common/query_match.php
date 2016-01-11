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
 * @param null $matchid
 * @return array|null
 */
function query_match($fields, $matchid = null)
{
	//如果fields不是数组，则返回值也不是数组
	if (!is_array($fields)) {
		$result = query_match(array($fields), $matchid);
		return $result[$fields];
	}
 
	//默认获取自己的资料
	$matchid = $matchid ? $matchid : 1;
	if (!$matchid) {
		return null;
	}

	//查询缓存，过滤掉已缓存的字段
	$cachedFields = array();
	$cacheResult = array();
	foreach ($fields as $field) {
		$cache = read_query_match_cache($matchid, $field);
		if (!empty($cache)) {
			$cacheResult[$field] = $cache;
			$cachedFields[] = $field;
		}
	}


	//获取两张用户表格中的所有字段
	$matchModel = M('Match');
	$matchFields = $matchModel->getDbFields();
	$matchFields = array_intersect($matchFields, $fields);

	//查询需要的字段
	$matchResult = array();
	if ($matchFields) {
		
		$matchResult = $matchModel->where(array('id' => $matchid))->field($matchFields)->find();
	}
	
	//读取头像数据
	$result = array();

	//读取头像数据
	if (in_array('cover', $fields)) {
		$result['cover']=query_picture('url',$matchResult['cover']);
	}


	//合并结果，不包括缓存
	$result = array_merge($matchResult, $result);

	//写入缓存
	foreach ($result as $field => $value) {
		$result[$field] = $value;
		write_query_match_cache($matchid, $field, str_replace('"', '', $value));
	}

	//合并结果，包括缓存
	$result = array_merge($result, $cacheResult);
	//返回结果
	return $result;
}

function read_query_match_cache($matchid, $field)
{
	return S("query_match_{$matchid}_{$field}");
}

function write_query_match_cache($matchid, $field, $value)
{
	return S("query_match_{$matchid}_{$field}", $value, 300);
}

function clean_query_match_cache($matchid, $field)
{
	if (is_array($field)) {
		foreach ($field as $field_item) {
			S("query_match_{$matchid}_{$field_item}", null);
		}
	}
	S("query_match_{$matchid}_{$field}", null);
}