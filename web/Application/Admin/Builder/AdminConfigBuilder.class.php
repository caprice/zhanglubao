<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 14-3-12
 * Time: AM10:08
 */

namespace Admin\Builder;

class AdminConfigBuilder extends AdminBuilder {
    private $_title;
    private $_keyList = array();
    private $_data = array();
    private $_buttonList = array();
    private $_savePostUrl = array();

    public function title($title) {
        $this->_title = $title;
        return $this;
    }

    public function key($name, $title, $subtitle=null, $type, $opt=null) {
        $key = array('name'=>$name, 'title'=>$title, 'subtitle'=>$subtitle, 'type'=>$type, 'opt'=>$opt);
        $this->_keyList[] = $key;
        return $this;
    }

    public function keyHidden($name, $title, $subtitle=null) {
        return $this->key($name, $title, $subtitle, 'hidden');
    }

    public function keyReadOnly($name, $title, $subtitle=null) {
        return $this->key($name, $title, $subtitle, 'readonly');
    }

    public function keyText($name, $title, $subtitle=null) {
        return $this->key($name, $title, $subtitle, 'text');
    }

    public function keyTextArea($name, $title, $subtitle=null) {
        return $this->key($name, $title, $subtitle, 'textarea');
    }

    public function keyInteger($name, $title, $subtitle=null) {
        return $this->key($name, $title, $subtitle, 'integer');
    }

    public function keyUid($name, $title, $subtitle=null) {
        return $this->key($name, $title, $subtitle, 'uid');
    }

    public function keyStatus($name='status', $title='状态', $subtitle=null) {
        $map = array(-1=>'删除', 0=>'禁用', 1=>'启用', 2=>'未审核');
        return $this->keySelect($name, $title, $subtitle, $map);
    }

    public function keySelect($name, $title, $subtitle=null, $options) {
        return $this->key($name, $title, $subtitle, 'select', $options);
    }

    public function keyRadio($name, $title, $subtitle=null, $options) {
        return $this->key($name, $title, $subtitle, 'radio', $options);
    }

    public function keyCheckBox($name, $title, $subtitle=null, $options) {
        return $this->key($name, $title, $subtitle, 'checkbox', $options);
    }

    public function keyEditor($name, $title, $subtitle=null) {
        return $this->key($name, $title, $subtitle, 'editor');
    }

    public function keyTime($name, $title, $subtitle=null) {
        return $this->key($name, $title, $subtitle, 'time');
    }

    public function keyCreateTime($name='create_time', $title='创建时间', $subtitle=null) {
        return $this->keyTime($name, $title, $subtitle);
    }

    public function keyBool($name, $title, $subtitle=null) {
        $map = array(1=>'是',0=>'否');
        return $this->keyRadio($name, $title, $subtitle, $map);
    }

    public function keyUpdateTime($name='update_time', $title='修改时间', $subtitle=null) {
        return $this->keyTime($name, $title, $subtitle);
    }

    public function keyTitle($name='title', $title='标题', $subtitle=null) {
        return $this->keyText($name, $title, $subtitle);
    }

    public function keyId($name='id', $title='编号', $subtitle=null) {
        return $this->keyReadOnly($name, $title, $subtitle);
    }

    public function keyMultiUserGroup($name, $title, $subtitle=null) {
        $options = $this->readUserGroups();
        return $this->keyCheckBox($name, $title, $subtitle, $options);
    }
    public function keySingleImage($name,$title,$subtitle=null){

        return $this->key($name, $title,$subtitle, 'image');
    }

    public function keySingleUserGroup($name, $title, $subtitle=null) {
        $options = $this->readUserGroups();
        return $this->keySelect($name, $title, $subtitle, $options);
    }

    public function button($title, $attr=array()) {
        $this->_buttonList[] = array('title'=>$title, 'attr'=>$attr);
        return $this;
    }

    public function buttonSubmit($url, $title='确定') {
        $this->savePostUrl($url);

        $attr = array();
        $attr['class'] = "btn submit-btn ajax-post";
        $attr['id'] = 'submit';
        $attr['type'] = 'submit';
        $attr['target-form'] = 'form-horizontal';
        return $this->button($title, $attr);
    }

    public function buttonBack($title='返回') {
        $attr = array();
        $attr['onclick'] = 'javascript:history.back(-1);return false;';
        $attr['class'] = 'btn btn-return';
        return $this->button($title, $attr);
    }

    public function data($list) {
        $this->_data = $list;
        return $this;
    }

    public function savePostUrl($url) {
        if($url) {
            $this->_savePostUrl = $url;
        }
    }

    public function display() {
        //将数据融入到key中
        foreach($this->_keyList as &$e) {
            $e['value'] = $this->_data[$e['name']];
        }

        //编译按钮的html属性
        foreach($this->_buttonList as &$button) {
            $button['attr'] = $this->compileHtmlAttr($button['attr']);
        }

        //显示页面
        $this->assign('title', $this->_title);
        $this->assign('keyList', $this->_keyList);
        $this->assign('buttonList', $this->_buttonList);
        $this->assign('savePostUrl', $this->_savePostUrl);
        parent::display('admin_config');
    }

    private function readUserGroups() {
        $list = M('AuthGroup')->where(array('status'=>1))->order('id asc')->select();
        $result = array();
        foreach($list as $group) {
            $result[$group['id']] = $group['title'];
        }
        return $result;
    }
}