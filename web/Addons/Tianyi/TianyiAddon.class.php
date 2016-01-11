<?php

namespace Addons\Tianyi;

use Common\Controller\Addon;

/**
 * 天翼短信插件插件
 * @author caipeichao
 */
class TianyiAddon extends Addon
{
    private $error;

    public $info = array(
        'name' => 'Tianyi',
        'title' => '天翼短信插件',
        'description' => '用于发送手机短信验证码、模板短信',
        'status' => 1,
        'author' => 'caipeichao',
        'version' => '0.1'
    );

    public function install()
    {
        $prefix = C("DB_PREFIX");
        return $this->runMultiSql(array(
            "DROP TABLE IF EXISTS {$prefix}tianyi_verify",
            "CREATE TABLE {$prefix}tianyi_verify (id int primary key auto_increment, mobile varchar(20) not null, verify varchar(6) not null, expire int not null, status int not null);"
        ));
    }

    public function uninstall()
    {
        $prefix = C("DB_PREFIX");
        return $this->runMultiSql(array(
            "DROP TABLE IF EXISTS {$prefix}tianyi_verify",
        ));
    }

    private function runMultiSql($sql)
    {
        $result = true;
        $model = D();
        foreach ($sql as $e) {
            $result &= $model->execute($e);
        }
        return true;
    }

    public function documentDetailAfter()
    {
    }

    /**
     * 返回非负代表成功，负数代表错误码
     * @param $mobile
     * @return mixed
     */
    public function sendVerify($mobile)
    {
        $model = $this->getTianyiVerifyModel();
        $error_code = $model->sendVerify($mobile);
        $this->error = $model->getError();
        return $error_code;
    }

    /**
     * 返回非负代表成功，负数代表错误码
     * @param $mobile
     * @param $verify
     */
    public function checkVerify($mobile, $verify)
    {
        $model = $this->getTianyiVerifyModel();
        return $model->checkVerify($mobile, $verify);
    }

    private function getTianyiVerifyModel()
    {
        $config = $this->getConfig();
        $model = D('Addons://Tianyi/TianyiVerify');
        $model->setConfig($config);
        return $model;
    }

    public function getError()
    {
        return $this->error;
    }
}