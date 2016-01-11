<?php

namespace Team\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class  ForumUeditorMiniWidget extends Action
{

    /* 显示指定分类的同级分类或子分类列表 */
    public function editor($id = 'myeditor', $name = 'content',$default='',$width='100%',$height='200px',$config='toolbar: [\' bold italic underline \']')
    {
        $this->assign('id',$id);
        $this->assign('name',$name);
        $this->assign('default',$default);
        $this->assign('width',$width);
        $this->assign('height',$height);
        $this->assign('config',$config);
        $this->display('Forum/Widget/ueditormini');
    }

}
