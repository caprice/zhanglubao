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
 * @param null $teamid
 * @return array|null
 */
function query_team($fields, $teamid = null)
{
	//如果fields不是数组，则返回值也不是数组
	if (!is_array($fields)) {
		$result = query_team(array($fields), $teamid);
		return $result[$fields];
	}

	//默认获取自己的资料
	$teamid = $teamid ? $teamid : 1;
	if (!$teamid) {
		return null;
	}

	//查询缓存，过滤掉已缓存的字段
	$cachedFields = array();
	$cacheResult = array();
	foreach ($fields as $field) {
		$cache = read_query_team_cache($teamid, $field);
		if (!empty($cache)) {
			$cacheResult[$field] = $cache;
			$cachedFields[] = $field;
		}
	}


	//获取两张用户表格中的所有字段
	$teamModel = M('Team');
	$teamFields = $teamModel->getDbFields();
	$teamFields = array_intersect($teamFields, $fields);


	//查询需要的字段
	$teamResult = array();
	if ($teamFields) {
		$teamResult = $teamModel->where(array('id' => $teamid))->field($teamFields)->find();
	}
	//读取头像数据
	$result = array();

	//读取头像数据
	if (in_array('cover', $fields)) {
		$result['cover']=query_picture('url',$teamResult['cover']);
	}


	//合并结果，不包括缓存
	$result = array_merge($teamResult, $result);

	//写入缓存
	foreach ($result as $field => $value) {
		$result[$field] = $value;
		write_query_team_cache($teamid, $field, str_replace('"', '', $value));
	}

	//合并结果，包括缓存
	$result = array_merge($result, $cacheResult);
	//返回结果
	return $result;
}

function read_query_team_cache($teamid, $field)
{
	return S("query_team_{$teamid}_{$field}");
}

function write_query_team_cache($teamid, $field, $value)
{
	return S("query_team_{$teamid}_{$field}", $value, 300);
}

function clean_query_team_cache($teamid, $field)
{
	if (is_array($field)) {
		foreach ($field as $field_item) {
			S("query_team_{$teamid}_{$field_item}", null);
		}
	}
	S("query_team_{$teamid}_{$field}", null);
}