<?php
namespace Home\Controller;
use Common\Controller\BaseController;


class IndexController extends BaseController {

	public  function  index()
	{
		$title = I ( 'video_title' );
		$map ['status'] = array (
				'egt',
				0
		);
		$map ['video_title'] = array (
				'like',
				'%' . ( string ) $title . '%'
		);
		$videolist = $this->lists ( 'VideoVideo', $map );
		int_to_string ( $videolist );
		$this->assign ( '_videolist', $videolist );
		
		$videocount = M('VideoVideo')->where('status=1')->count();
		$this->assign('videocount',$videocount);
		
		$verifymap['status']=1;
		$verifymap['user_verify']=1;
		$verifycount = M('UserUser')->where($verifymap)->count();
		$this->assign('verifycount',$verifycount);
		
		
		$albummap['status']=1;
		$albumcount = M('VideoAlbum')->where($albummap)->count();
		$this->assign('albumcount',$albumcount);
		
		$usermap['status']=1;
		$usercount = M('UserUser')->where($usermap)->count();
		$this->assign('usercount',$usercount);
		
		$lines=array();
		for($i=8;$i--;$i>1)
		{
			$time=time()-24*60*60*$i;
			$date=date("Y-m-d",$time); 
			$map['create_time']=array('gt',$time);
			$map['create_time']=array('lt',time()-24*60*60*($i-1));
			$count=M('VideoVideo')->where($map)->count();
			$day['date']=$date;
			$day['count']=$count;
			$lines[]=$day;
			
		}
		$this->assign('lines',$lines);
		
		$this->display();
	}
}