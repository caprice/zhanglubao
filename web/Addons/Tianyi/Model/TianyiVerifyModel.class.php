<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 1/16/14
 * Time: 3:07 PM
 */

namespace Addons\Tianyi\Model;

use Think\Model;

class TianyiVerifyModel extends Model
{
    private $config;
    private $addonName = 'Tianyi';

    /**
     * 调用天翼接口前必须调用此方法传入配置信息
     * @param $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * 向手机发送验证码
     * @param $mobile
     * @return int
     */
    public function sendVerify($mobile)
    {
        if ($this->isAccessTokenNeedRefresh()) {
            $this->refreshAccessToken();
        }

        //测试模式
        //只有特定号码段的手机才支持
        //在测试模式下，不会真正发送短信，而且每次都假定验证码为123456
        $test = false;

        //确认确实是测试手机
        if (!$this->isTestMobile($mobile)) {
            $test = false;
        }
        //确认已经配置
        if (!$this->config) {
            $this->error = "未提供配置";
            return -6;
        }
        //确认手机号码有效
        if (!$this->isValidMobile($mobile)) {
            $this->error = "无效手机号";
            return -1;
        }
        //如果验证码已经发送过了，取消有效的验证码
        $this->invalidateVerify($mobile);
        //生成验证码
        $verify = $this->generateVerify();
        if ($test)
            $verify = '123456';
        if (!$this->addVerify($mobile, $verify)) {
            $this->error = $this->getErrorMessage(-3);
            return -3; //写入数据库失败
        }
        //发送验证码
        if ($test)
            return 1;
        $token = $this->tianyiGetTrustToken();
        if (!$token) {
            $this->error = '获取信任码失败：' . $this->error;
            return -4;
        }
        if (!$this->tianyiSendVerify($mobile, $verify, $token)) {
            $this->error = '发送短信失败：' . $this->error;
            return -5;
        }
        //返回成功消息
        return 1;
    }

    public function checkVerify($mobile, $verify)
    {
        //获取验证码
        $expect = $this->getVerify($mobile);
        if (!$expect) {
            $this->error = "验证码已过期";
            return false;
        }
        $result = ($expect === $verify);
        if ($result) {
            //使验证码失效
            $this->invalidateVerify($mobile);
        }

        //确认验证码相同
        return $result;
    }

    public function getErrorMessage($error_code)
    {
        $map = array(
            -1 => '无效手机号',
            -2 => '验证码不存在或已经过期',
            -3 => '写入数据库失败',
            -4 => '获取信任码失败',
            -5 => '下发短信失败',
            -6 => '未提供配置信息',
        );
        $message = $map[$error_code];
        if ($message) {
            return $message;
        } else {
            return "未知错误";
        }
    }

    private function invalidateVerify($mobile)
    {
        $map = array(
            'mobile' => $mobile,
            'status' => 1,
        );
        $row = array(
            'status' => -1,
        );
        return $this->where($map)->save($row);
    }

    private function generateVerify()
    {
        $rand = rand(0, 999999);
        return sprintf("%06d", $rand);
    }

    private function addVerify($mobile, $verify)
    {
        $row = array(
            'mobile' => $mobile,
            'verify' => $verify,
            'expire' => time() + $this->config['expire'],
            'status' => 1,
        );
        $this->create($row);
        return $this->add();
    }

    private function tianyiSendVerify($mobile, $verify, $token)
    {
        $api = "http://api.189.cn/v2/dm/randcode/sendSms";
        $result = $this->callTianyiApi($api, array(
            'phone' => $mobile,
            'url' => 'test',
            'randcode' => $verify,
            'token' => $token,
            'exp_time' => intval(round(($this->config['expire'])/60)),//修复验证码过期时间无效问题
        ));
        $error_code = $result['res_code'];
        $identifier = $result['identifier'];
        if ($error_code) {
            $this->error = "下发验证码失败，错误代码：{$error_code}";
            return false;
        }
        return true;
    }

    private function tianyiGetTrustToken()
    {
        $api = "http://api.189.cn/v2/dm/randcode/token";
        $result = $this->callTianyiApi($api);
        $error_code = $result['res_code'];
        if ($error_code) {
            $this->error = "获取信任码失败，错误代码{$error_code}";
            return false;
        }
        $token = $result['token'];
        return $token;
    }

    private function tianyiRefreshAccessToken()
    {
        //调用接口来获取新的AT
        $url = 'https://oauth.api.189.cn/emp/oauth2/v2/access_token';
        $result = $this->callApi($url, array(
            'app_id' => $this->config['app_id'],
            'app_secret' => $this->config['app_secret'],
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->config['refresh_token'],
        ));

        //如果失败，就直接返回
        if ($result['res_code'] != 0) {
            return false;
        }

        //如果成功，就返回新的AT
        return $result['access_token'];
    }

    private function callTianyiApi($url, $params = array())
    {
        //获取配置
        $app_id = $this->config['app_id'];
        $access_token = $this->config['access_token'];
        $app_secret = $this->config['app_secret'];

        //发送HTTP请求
        $timestamp = date('Y-m-d H:i:s');
        $param['app_id'] = $app_id;
        $param['access_token'] = $access_token;
        $param['timestamp'] = $timestamp;
        $param = array_merge($param, $params);
        $param['sign'] = $this->computeSign($app_secret, $param);
        $str = http_build_query($param);
        $result = $this->curl_post($url, $str);
        $resultArray = json_decode($result, true);
        return $resultArray;
    }

    private function callApi($url, $params = array())
    {
        $str = http_build_query($params);
        $result = $this->curl_post($url, $str);
        $resultArray = json_decode($result, true);
        return $resultArray;
    }

    private function getVerify($mobile)
    {
        $map = array();
        $map['status'] = 1;
        $map['expire'] = array("GT", time());
        $map['mobile'] = $mobile;
        $verify = $this->where($map)->find();
        return $verify['verify'];
    }

    private function computeSign($app_secret, $param)
    {
        //
        ksort($param);
        $text = array();
        foreach ($param as $k => $v) {
            $text[] = "$k=$v";
        }
        $plain = implode("&", $text);
        return base64_encode(hash_hmac("sha1", $plain, $app_secret, $raw_output = True));
    }

    function curl_get($url = '', $options = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function curl_post($url = '', $postdata = '', $options = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private function isValidMobile($mobile)
    {
        if (strlen($mobile) != 11) {
            return false;
        }
        return (bool)preg_match("/^[0-9]+$/", $mobile);
    }

    private function isTestMobile($mobile)
    {
        if (strstr($mobile, '1373225') == $mobile) {
            return true;
        } else {
            return false;
        }
    }

    private function isAccessTokenNeedRefresh()
    {
        $lastUpdate = $this->getAccessTokenLastUpdateTime();
        $updateInterval = $this->config['update_access_token_interval'];
        if (time() - $lastUpdate >= $updateInterval) {
            return true;
        } else {
            return false;
        }
    }

    private function refreshAccessToken()
    {
        $newAccessToken = $this->tianyiRefreshAccessToken();
        $this->config['access_token'] = $newAccessToken;
        $this->updateLastUpdateTime();
        $this->saveConfig();
    }

    private function getAccessTokenLastUpdateTime()
    {
        return intval($this->config['last_update_time']);
    }

    private function updateLastUpdateTime()
    {
        $this->config['last_update_time'] = time();
    }

    private function saveConfig()
    {
        $map = array('name' => $this->addonName);
        $data = array('config' => json_encode($this->config));
        M('Addons')->where($map)->save($data);
    }
}
