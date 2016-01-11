<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 1/17/14
 * Time: 7:51 PM
 */

namespace Usercenter\Model;

use Think\Model;

class TitleModel extends Model
{
    public function getTitle($uid)
    {
        $score = query_user(array('score'), $uid);
        return $this->getTitleByScore($score['score']);
    }

    public function getTitleByScore($score)
    {
        //根据积分查询对应等级
        $config = $this->getTitleConfig();

        $config = array_reverse($config, true);
        foreach ($config as $min => $title) {
            if ($score >= $min) {
                return $title;
            }
        }

        //查询无结果，返回最高等级
        $keys = array_keys($config);
        $max_key = $keys[count($config) - 1];
        return $config[$max_key];
    }

    /**获取等级配置
     * @return array
     * @auth 陈一枭
     */
    public function getTitleConfig()
    {
        return array(
            0 => 'Lv1 实习',
            50 => 'Lv2 试用',
            100 => 'Lv3 转正',
            200 => 'Lv 4 助理',
            400 => 'Lv 5 经理',
            800 => 'Lv 6 董事',
            1600 => 'Lv 7 董事长'
        );

        // return C('TITLE');
    }

    public function getScoreTotal($userScore)
    {
        $titles = $this->getTitleConfig();
        array_reverse($titles);
        foreach ($titles as $score => $title) {
            if ($userScore < $score) {
                return $score;
            }
        }

    }
}