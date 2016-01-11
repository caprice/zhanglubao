<?php
namespace Common\Model;

use Think\Model;

class VideoCommentModel extends Model {
	protected $_validate = array (
			array (
					'content',
					'1,99999',
					'内容不能为空',
					self::EXISTS_VALIDATE,
					'length' 
			),
			array (
					'content',
					'0,500',
					'内容太长',
					self::EXISTS_VALIDATE,
					'length' 
			) 
	);
	protected $_auto = array (
			array (
					'create_time',
					NOW_TIME,
					self::MODEL_INSERT 
			),
			array (
					'praised',
					'1',
					self::MODEL_INSERT 
			),
			array (
					'ip',
					'1',
					self::MODEL_INSERT
			),
			array (
					'ip',
					get_client_ip,
					self::MODEL_INSERT,
					'function',
					1
			) 
	);

	public function addComment($uid, $video_id, $content, $pid = 0) {
		$data = array (
				'uid' => $uid,
				'content' => $content,
				'video_id' => $video_id,
				'pid' => $pid 
		);
		$data = $this->create ( $data );
		if (! $data)
			return false;
		$comment_id = $this->add ( $data );
		D ( 'VideoVideo' )->where ( array (
				'id' => $video_id 
		) )->setInc ( 'comment_count' );
		return $comment_id;
	}

	public function getComment($id) {
		$comment = $this->field ( array (
				'id','uid','content','create_time','praised'
		)) ->find ( $id );
		return $comment;
	}
	public function  getReply($pid)
	{
		return  array();
	}

	public function getCommentList($video_id, $page = 0, $show_more = 0) {
		$order = 'id desc';
		$start=$page*10;
		$comment = $this->where ( array (
				'video_id' => $video_id,
				'status' => 1 
		) )->order ( $order )->limit ( $start.",10" )->field ( 'id' )->select ();
		$ids = getSubByKey ( $comment, 'id' );
		$list = array ();
		foreach ( $ids as $v ) {
			$comment = $this->getComment ( $v );
			$comment['replylist']=$this->getReply($list [$v]['id']);
			$list[]=$comment;
		}
		return $list;
	}
	
	protected function _after_find(&$result, $options) {
	 
		if (! empty ( $result ['uid'] )) {
			$result ['user'] =D ( 'UserUser' )->field ( 'uid,nickname,avatar_id' )->find($result['uid']);
		}
	
	}
	
	
}
?>