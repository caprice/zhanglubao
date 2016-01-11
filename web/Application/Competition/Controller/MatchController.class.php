<?php
namespace Competition\Controller;

class MatchController extends BaseController {
	
	public  function  index()
	{
		$list = $this->lists ( 'Match' );
		$this->assign ( '_list', $list );
		$this->display();
	}
	public function  view($id)
	{
		$match=D('Match')->getMatchInfo($id);
		$mathgames=D('Match')->getMatchGameById($id);
		$videomap['match_id']=$id;
		$matchvideos=D('MatchVideo')->getVideosInfo($videomap,6);
		$this->assign('matchvideos',$matchvideos);
		$this->assign('matchgames',$mathgames);
		$this->assign('match',$match);
		$this->display();
	}
}