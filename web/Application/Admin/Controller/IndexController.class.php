<?php
// +----------------------------------------------------------------------
// | all for fight
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.quntiao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Rocks 
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi as UserApi;

/**
 * 后台首页控制器
 * @author Rocks
 */
class IndexController extends AdminController {

    /**
     * 后台首页
     * @author Rocks
     */
    public function index(){
        if(UID){
            $this->meta_title = '管理首页';
            $this->display();
        } else {
            $this->redirect('Public/login');
        }
    }

}
