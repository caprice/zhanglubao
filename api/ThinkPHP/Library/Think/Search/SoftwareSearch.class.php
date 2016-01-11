<?php

namespace Think\Search;
class SoftwareSearch {

    const PAGE_SIZE = 60;
    
    public static function loadParam() {
        $param = array();
        $param["q"] = isset($_GET["keyword"]) ? $_GET["keyword"] : "英雄联盟";
        $param["page"] = isset($_GET["p"]) ? $_GET["p"] : 1;
        return $param;
    }

    public static function buildLinkUrls($param, $url_query) {
        $link_urls = array();
        return $link_urls;
    }

    public static function buildSearchParam($param = array(),&$search) {
       if (!$param) {
            $param = self::loadParam();
        }
        //设置查询关键词
        self::buildQuery($param, $search);
        //设置排序规则
        self::buildSort($param, $search);
        //设置搜索过滤条件
        self::buildFilter($param, $search);

        // 指定搜索返回的格式。
        $search->setFormat('json');
        //设置返回结果起始位置
        $search->setStartHit(((int)$param["page"]-1)*self::PAGE_SIZE);
        //设置返回结果条数
        $search->setHits(self::PAGE_SIZE); 
    }

    private static function buildFilter($param, &$search) {
    }

    private static function buildQuery($param, &$search) {
        $search->setQueryString("default:'".$param['q']."'");
        return true;
    }

    private static function buildSort($param, &$search) {
    	 
        return true;
    }

}

//end class
?>
