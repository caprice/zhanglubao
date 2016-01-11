<?php
namespace Video\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexHeartStoneWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
        // $videos = S('video_index_heartstone');
        if (empty($videos)) {
        	$map['status']=1;
        	$map ['game_id'] = 10007;
			$videos = D ( 'Video' )->getVideosInfo ( $map, 12 );
			S ( 'video_index_heartstone', $videos, 3000 );
        }
        $this->assign('heartstones', $videos);
        $this->display('Widget/Index/heartstone');
    }
}