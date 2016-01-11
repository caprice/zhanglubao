<?php

namespace Team\Model;

use Think\Model;

class ForumPostModel extends Model {
	
	
	
	protected $_validate = array(
			array('title', '1,100', '标题长度不合法', self::EXISTS_VALIDATE, 'length'),
			array('content', '1,40000', '内容长度不合法', self::EXISTS_VALIDATE, 'length'),
	);
	
	protected $_auto = array(
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
			array('last_reply_time', NOW_TIME, self::MODEL_INSERT),
			array('status', '1', self::MODEL_INSERT),
	);
	
	public function editPost($data) {
		$at_source=$data['content'];
	
		$data = $this->create($data);
		if(!$data) return false;
		// 对@进行处理
	
		$content = $this->filterPostContent($data['content']);
		$data['content']=$content;
		$data['title']=op_t($data['title']);
		$this->handlerAt($at_source,$data['id']);
		return $this->save($data);
	}
	
	public function createPost($data) {
		//新增帖子
		$at_source=$data['content'];
		$data = $this->create($data);
	
		//对帖子内容进行安全过滤
		if(!$data) return false;
	
	
	
	
		$content = $this->filterPostContent($data['content']);
		$data['content']=$content;
		$data['title']=op_t($data['title']);
		$result = $this->add($data);
		action_log('add_post','ForumPost',$result,is_login());
		if(!$result) {
			return false;
		}
	
		//增加板块的帖子数量
		D('Forum')->where(array('id'=>$data['forum_id']))->setInc('post_count');
		$this->handlerAt($at_source,$result);
		//返回帖子编号
		return $result;
	}
	
	/**
	 * @param $data
	 * @auth 陈一枭
	 */
	private function handlerAt($content,$id)
	{
		D('ContentHandler')->handleAtWho($content,U('Forum/Index/detail',array('id'=>$id)));
	
	}
	
	private function filterPostContent($content)
	{
		$content = op_h($content);
		$content = $this->limitPictureCount($content);
		$content = op_h($content);
		return $content;
	}
	private function limitPictureCount($content)
	{
		//默认最多显示10张图片
		$maxImageCount = 10;
	
		//正则表达式配置
		$beginMark = 'BEGIN0000hfuidafoidsjfiadosj';
		$endMark = 'END0000fjidoajfdsiofjdiofjasid';
		$imageRegex = '/<img(.*?)\\>/i';
		$reverseRegex = "/{$beginMark}(.*?){$endMark}/i";
	
		//如果图片数量不够多，那就不用额外处理了。
		$imageCount = preg_match_all($imageRegex, $content);
		if ($imageCount <= $maxImageCount) {
			return $content;
		}
	
		//清除伪造图片
		$content = preg_replace($reverseRegex, "<img$1>", $content);
	
		//临时替换图片来保留前$maxImageCount张图片
		$content = preg_replace($imageRegex, "{$beginMark}$1{$endMark}", $content, $maxImageCount);
	
		//替换多余的图片
		$content = preg_replace($imageRegex, "[图片]", $content);
	
		//将替换的东西替换回来
		$content = preg_replace($reverseRegex, "<img$1>", $content);
	
		//返回结果
		return $content;
	}
	
	
	
	public function getForumPostInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getForumPostInfo ( $v );
		}
		
		return $cacheList;
	}
	
	
	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param integer $uid
	 *        	游戏UID
	 * @return array 指定游戏的相关信息
	 */
	public function getForumPostByName($name) {
		if (empty ( $name )) {
			return false;
		}
		$forumpost = S ( 'forumpost_info_name_' . $name );
		if (! $forumpost) {
			$map ['name'] = $name;
			$forumpost = $this->_getForumPostInfo ( $map );
			S ( 'forumpost_info_name_' . $name, $forumpost, 400 );
		}
		return $forumpost;
	}
	
	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param integer $uid
	 *        	游戏UID
	 * @return array 指定游戏的相关信息
	 */
	public function getForumPostInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		//$forumpost = S ( 'forumpost_info_' . $id );
		if (! $forumpost) {
			$map ['id'] = $id;
			$forumpost = $this->_getForumPostInfo ( $map );
		}
		return $forumpost;
	}
	
	
	public function getForumPostsInfo($map, $limit = 20, $order = 'id asc') {
		$forumposts = $this->where ( $map )->field ( array (
				'id' 
		) )->order ( $order )->limit ( $limit )->select ();
		
		foreach ( $forumposts as $v ) {
			! $cacheList [$v ['id']] && $cacheList [$v ['id']] = $this->getForumPostInfo ( $v ['id'] );
		}
		
		return $cacheList;
	}
	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定游戏的相关信息
	 */
	private function _getForumPostInfo($map, $field = "*") {
		$forumpost = $this->where ( $map )->field ( $field )->find ();
		$forumpost['forum_name']=D('Forum')->getForumName($forumpost['forum_id']);
		
		
		S ( 'forumpost_info_' . $forumpost ['id'], $forumpost, 400 );
		return $forumpost;
	}
	
	
	
	
	/**
	 * 清除指定ForumPost数据
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys = S ( 'forumpost_info_' . $id );
			foreach ( $keys as $k ) {
				S ( $k, null );
			}
			S ( 'forumpost_info_' . $id, null );
		}
		
		return true;
	}
}

