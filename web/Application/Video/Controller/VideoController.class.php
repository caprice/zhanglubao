<?php
namespace Video\Controller;
use Think\Controller;

class VideoController extends Controller{
	
	
	public  function view($id)
	{
		$video=D('Video')->getVideoInfo($id);
		
		D('Video')->view($id);
		$nearvideos=D('Video')->getNearVideos($id, $video['game_id']);
		$uservideos=D('Video')->getAuthor($video['uid']);
		$this->assign('uservideos',$uservideos);
		$this->assign('nearvideos',$nearvideos);
		$this->assign('video',$video);
		$this->display();
	}
}

?>