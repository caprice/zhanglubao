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
 * @param null $uid
 * @return array|null
 */
function query_user($fields, $uid = null)
{
	//如果fields不是数组，则返回值也不是数组
	if (!is_array($fields)) {
		$result = query_user(array($fields), $uid);
		return $result[$fields];
	}

	//默认获取自己的资料
	$uid = $uid ? $uid : is_login();
	if (!$uid) {
		return null;
	}

	//查询缓存，过滤掉已缓存的字段
	$cachedFields = array();
	$cacheResult = array();
	foreach ($fields as $field) {
		if (in_array($field, array('icons_html', 'title', 'score'))) {
			continue;
		}

		$cache = read_query_user_cache($uid, $field);
		if (!empty($cache)) {
			$cacheResult[$field] = $cache;
			$cachedFields[] = $field;
		}
	}

	//去除已经缓存的字段
	$fields = array_diff($fields, $cachedFields);

	//获取两张用户表格中的所有字段
	$homeModel = M('Member');
	$ucenterModel = M('UcenterMember');

	$homeFields = $homeModel->getDbFields();
	$ucenterFields = $ucenterModel->getDbFields();

	$homeFields = array_intersect($homeFields, $fields);
	$ucenterFields = array_intersect($ucenterFields, $fields);

	//查询需要的字段
	$homeResult = array();
	$ucenterResult = array();
	if ($homeFields) {
		$homeResult = D('Home/Member')->where(array('uid' => $uid))->field($homeFields)->find();
	}
	if ($ucenterFields) {
		$model = D('User/UcenterMember');
		$ucenterResult = $model->where(array('id' => $uid))->field($ucenterFields)->find();
	}


	//读取头像数据
	$result = array();
	//读取头像数据
	if (in_array('avatar', $fields)) {
		
		$avatarModel=D('Home/Avatar');
		$avatar=$avatarModel->getAvatar($uid);
		if ($avatar)
		{
			$result['avatar']=$avatar;
		}else
		{
			$result['avatar']=cdn('default/avatar.jpg');
		}
	}

	//读取等级数据
	if (in_array('title', $fields)) {
		$titleModel = D('Usercenter/Title');
		$title = $titleModel->getTitle($uid);
		$result['title'] = $title;
	}

	//读取用户名拼音
	if (in_array('pinyin', $fields)) {

		$result['pinyin'] = D('Pinyin')->pinYin($result['username']);
	}

	//获取个人中心地址
	$spaceUrlResult = array();
	if (in_array('space_url', $fields)) {
		$result['space_url'] = U('UserCenter/Index/index', array('uid' => $uid));
	}

	//获取昵称链接
	if (in_array('space_link', $fields)) {
		$result['space_link'] = '<a ucard="' . $uid . '" href="' . U('UserCenter/Index/index', array('uid' => $uid)) . '">' . $ucenterResult['username'] . '</a>';
	}

	//获取用户头衔链接
	if (in_array('rank_link', $fields)) {
		$rank_List = D('rank_user')->where('uid=' . $uid)->select();
		$num = 0;
		foreach ($rank_List as &$val) {
			$rank = D('rank')->where('id=' . $val['rank_id'])->find();
			$val['title'] = $rank['title'];
			$val['logo_url'] = getRootUrl() . D('picture')->where('id=' . $rank['logo'])->getField('path');
			if ($val['is_show']) {
				$num = 1;
			}
		}
		if ($rank_List) {
			$rank_List[0]['num'] = $num;
			$result['rank_link'] = $rank_List;
		} else {
			$result['rank_link'] = array();
		}

	}

	//获取用户认证图标
	if (in_array('icons_html', $fields)) {

		//判断是否有手机图标
		$static = C('TMPL_PARSE_STRING.__STATIC__');
		$iconUrls = array();
		$user = query_user(array('mobile'), $uid);
		if ($user['mobile']) {
			$iconUrls[] = "$static/oneplus/images/mobile-bind.png";
		}
		//生成结果
		$result['icons_html'] = '<span class="usercenter-verify-icon-list">';
		foreach ($iconUrls as $e) {
			$result['icons_html'] .= "<img src=\"{$e}\" title=\"对方已绑定手机\"/>";
		}
		$result['icons_html'] .= '</span>';
	}

	//粉丝数、关注数、微博数
	if (in_array('fans', $fields)) {
		$result['fans'] = D('Follow')->where('follow_who=' . $uid)->count();
	}
	if (in_array('following', $fields)) {
		$result['following'] = D('Follow')->where('who_follow=' . $uid)->count();
	}
	if (in_array('weibocount', $fields)) {
		$result['weibocount'] = D('Weibo')->where('uid=' . $uid)->count();
	}

	//是否关注、是否被关注
	if(in_array('is_following', $fields)) {
		$follow = D('Follow')->where(array('who_follow'=>get_uid(),'follow_who'=>$uid))->find();
		$result['is_following'] = $follow ? true : false;
	}
	if(in_array('is_followed', $fields)) {
		$follow = D('Follow')->where(array('who_follow'=>$uid,'follow_who'=>get_uid()))->find();
		$result['is_followed'] = $follow ? true : false;
	}

	//↑↑↑ 新增字段应该写在在这行注释以上 ↑↑↑

	//合并结果，不包括缓存
	$result = array_merge($ucenterResult, $homeResult, $spaceUrlResult, $result);

	//写入缓存
	foreach ($result as $field => $value) {
		if (in_array($field, array('icons_html', 'title', 'score'))) {
			continue;
		}
		if (!in_array($field, array('rank_link', 'icons_html', 'space_link'))) {
			$value = str_replace('"', '', op_t($value));
		}

		$result[$field] = $value;
		write_query_user_cache($uid, $field, str_replace('"', '', $value));
	}

	//合并结果，包括缓存
	$result = array_merge($result, $cacheResult);
	//返回结果
	return $result;
}

function read_query_user_cache($uid, $field)
{
	return S("query_user_{$uid}_{$field}");
}

function write_query_user_cache($uid, $field, $value)
{
	return S("query_user_{$uid}_{$field}", $value, 300);
}

function clean_query_user_cache($uid, $field)
{
	if (is_array($field)) {
		foreach ($field as $field_item) {
			S("query_user_{$uid}_{$field_item}", null);
		}
	}
	S("query_user_{$uid}_{$field}", null);
}