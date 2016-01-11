<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 14-3-10
 * Time: PM7:40
 */

function getPagination($totalCount, $countPerPage = 10)
{
    $pageKey = 'page';

    //获取当前页码
    $currentPage = $_REQUEST[$pageKey] ? $_REQUEST[$pageKey] : 1;

    //计算总页数
    $pageCount = ceil($totalCount / $countPerPage);

    //如果只有1页，就没必要翻页了
    if ($pageCount <= 1) {
        return '';
    }

    //定义返回结果
    $html = '';

    //添加头部
    $html .= '<div class="pagination">';

    //添加上一页的按钮
    if ($currentPage > 1) {
        $prevUrl = addUrlParam(getCurrentUrl(), array($pageKey => $currentPage - 1));
        $html .= "<li><a class=\"\" href=\"{$prevUrl}\">&laquo;</a></li>";
    } else {
        $html .= "<li class=\"disabled\"><a>&laquo;</a></li>";
    }

    //添加各页面按钮
    for ($i = 1; $i <= $pageCount; $i++) {
        $pageUrl = addUrlParam(getCurrentUrl(), array($pageKey => $i));
        if ($i == $currentPage) {
            $html .= "<li class=\"active\"><a class=\"active\" href=\"{$pageUrl}\">{$i}</a></li>";
        } else {
            $html .= "<li><a class=\"\" href=\"{$pageUrl}\">{$i}</a></li>";
        }
    }

    //添加下一页按钮
    if ($currentPage < $pageCount) {
        $nextUrl = addUrlParam(getCurrentUrl(), array($pageKey => $currentPage + 1));
        $html .= "<li><a class=\"\" href=\"{$nextUrl}\">&raquo;</a></li>";
    } else {
        $html .= "<li class=\"disabled\"><a>&raquo;</a></li>";
    }

    //收尾
    $html .= '</div>';
    return $html;
}


function getPageHtml($f_name, $totalpage, $data, $nowpage)
{
    if ($totalpage > 1 && $totalpage != null) {
        $str = '';
        foreach ($data as $k => $v) {
            $str = $str . '"' . $v . '"' . ',';
        }
        $pages = '';
        for ($i = 1; $i <= $totalpage; $i++) {
            if ($i == $nowpage) {
                $pages = $pages . "<li class=\"active\"><a href=\"javascript:\" id='page_" . $i . "' class='page active' onclick='" . $f_name . "(" . $str . $i . ")'>" . $i . "</a></li>";
            } else {
                $pages = $pages . "<li><a href=\"javascript:\" id='page_" . $i . "' class='page' onclick='" . $f_name . "(" . $str . $i . ")'>" . $i . "</a></li>";
            }
        }
        if ($nowpage == 1) {
            $a = $nowpage;
            $pre = "<li class=\"disabled\"><a href=\"javascript:\" class='page_pre'  onclick = '" . $f_name . "( " . $str . $a . ")'>" . "&laquo;" . "</a></li>";
        } else {
            $a = $nowpage - 1;
            $pre = "<li><a href=\"javascript:\" class='page_pre'  onclick = '" . $f_name . "( " . $str . $a . ")'>" . "&laquo;" . "</a></li>";
        }
        /*    $pre = "<li class=\"disabled\"><a class='a page_pre'  onclick = '" . $f_name . "( " . $str . $a . ")'>" . "上一页" . "</a></li>";*/

        if ($nowpage == $totalpage) {
            $b = $totalpage;
            $next = "<li class=\"disabled\"><a href=\"javascript:\" class='a page_next'  onclick = '" . $f_name . "( " . $str . $b . ")'>" . "&raquo;" . "</a></li>";
        } else {
            $b = $nowpage + 1;
            $next = "<li><a href=\"javascript:\" class='a page_next'  onclick = '" . $f_name . "( " . $str . $b . ")'>" . "&raquo;" . "</a></li>";
        }

        return $pre . $pages . $next;
    }
}


function getPage($data, $limit, $page)
{
    $offset = ($page - 1) * $limit;
    return array_slice($data, $offset, $limit);
}


function addUrlParam($url, $params)
{
    $app = MODULE_NAME;
    $controller = CONTROLLER_NAME;
    $action = ACTION_NAME;
    $get = array_merge($_GET, $params);
    return U("$app/$controller/$action", $get);
}

function getCurrentUrl()
{
    return $_SERVER['REQUEST_URI'];
}