<?php

namespace Common\Model;

use Think\Model;

class SeoRuleModel extends Model
{
    public function getMetaOfCurrentPage()
    {
        $result = $this->getMeta(MODULE_NAME, CONTROLLER_NAME, ACTION_NAME);
        return $result;
    }

    private function getMeta($module, $controller, $action)
    {
        //查询缓存，如果已有，则直接返回
        $cacheKey = "quntiao_seo_meta_{$module}_{$controller}_{$action}";
         $cache = S($cacheKey);
        if($cache !== null) {
            return $cache;
        }
        //获取相关的规则
        $rules = $this->getRelatedRules($module, $controller, $action);

        //按照排序计算最终结果
        $title = '';
        $keywords = '';
        $description = '';
        foreach ($rules as $e) {
            if (!$title && $e['seo_title']) {
                $title = $e['seo_title'];
            }
            if (!$keywords && $e['seo_keywords']) {
                $keywords = $e['seo_keywords'];
            }
            if (!$description && $e['seo_description']) {
                $description = $e['seo_description'];
            }
        }

        //生成结果
        $result = array('title' => $title, 'keywords' => $keywords, 'description' => $description);

        //写入缓存
        S($cacheKey, $result);

        //返回结果
        return $result;
    }

    private function getRelatedRules($module, $controller, $action)
    {
        //防止SQL注入
        $module = mysql_escape_string($module);
        $controller = mysql_escape_string($controller);
        $action = mysql_escape_string($action);

        //查询与当前页面相关的SEO规则
        $map = array();
        $map['_string'] = "(app='' or app='$module') and (controller='' or controller='$controller') and (action='' or action='$action') and status=1";
        $rules = $this->where($map)->order('sort asc')->select();

        
        //返回规则列表
        return $rules;
    }
}