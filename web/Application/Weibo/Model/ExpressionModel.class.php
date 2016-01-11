<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 14-3-10
 * Time: PM9:01
 */

namespace Weibo\Model;

use Think\Model;

class ExpressionModel extends Model
{
    /**
     * 获取当前所有的表情
     * @param boolean $flush 是否更新缓存，默认为false
     * @return array 返回表情数据
     */
    public function getAllExpression()
    {
        define('ROOT_PATH', str_replace('/Application/Weibo/Model/ExpressionModel.class.php', '', str_replace('\\', '/', __FILE__)));
        $pkg = 'miniblog'; //TODO 临时写死
        $filepath = ROOT_PATH . "/Public/static/image/expression/" . $pkg;
        $list = $this->myreaddir($filepath);

        $res = array();
        foreach ($list as $value) {
            $file = explode(".", $value);
            $temp['title'] = $file[0];
            $temp['emotion'] = '[' . $file[0] . ']';
            $temp['filename'] = $value;
            $temp['type'] = $pkg;
            $temp['src'] = __ROOT__ . "/Public/static/image/expression/" . $pkg . '/' . $value;
            $res[$temp['emotion']] = $temp;
        }
        return $res;
    }

    public function myreaddir($dir)
    {
        $handle = opendir($dir);
        $i = 0;
        while ($file = readdir($handle)) {
            if (($file != ".") and ($file != "..")) {
                $list[$i] = $file;
                $i = $i + 1;
            }
        }
        closedir($handle);
        return $list;
    }

    /**
     * 将表情格式化成HTML形式
     * @param string $data 内容数据
     * @return string 转换为表情链接的内容
     */
    public function parse($data)
    {
        $data = preg_replace("/img{data=([^}]*)}/", "<img src='$1'  data='$1' >", $data);
        return $data;
    }
}















