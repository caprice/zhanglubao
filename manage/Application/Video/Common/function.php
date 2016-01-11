<?php 



function fetch_youku_flv($url){ 
    preg_match("#id_(.*?)\.html#",$url,$out); 
 
    $id=$out[1]; 
    $content=get_curl_contents('http://v.youku.com/player/getPlayList/VideoIDS/'.$id); 
    
    echo $content;
    return ;
    $data=json_decode($content); 
    foreach($data->data[0]->streamfileids AS $k=>$v){ 
    $sid=getSid(); 
    $fileid=getfileid($v,$data->data[0]->seed); 
    $one=($data->data[0]->segs->$k); 
    if($k == 'flv' || $k == 'mp4') return "http://f.youku.com/player/getFlvPath/sid/{$sid}_00/st/{$k}/fileid/{$fileid}?K={$one[0]->k}"; 
    continue; 
    } 
}  
function get_curl_contents($url, $second = 5){ 
    if(!function_exists('curl_init')) die('php.ini未开启php_curl.dll'); 
    $c = curl_init(); 
    curl_setopt($c,CURLOPT_URL,$url); 
    $UserAgent=$_SERVER['HTTP_USER_AGENT']; 
    curl_setopt($c,CURLOPT_USERAGENT,$UserAgent); 
    curl_setopt($c,CURLOPT_HEADER,0); 
    curl_setopt($c,CURLOPT_TIMEOUT,$second); 
    curl_setopt($c,CURLOPT_RETURNTRANSFER, true); 
    $cnt = curl_exec($c); 
    $cnt=mb_check_encoding($cnt,'utf-8')?iconv('gbk','utf-8//IGNORE',$cnt):$cnt; //字符编码转换 
    curl_close($c); 
    return $cnt; 
} 
function getSid() { 
    $sid = time().(rand(0,9000)+10000); 
    return $sid; 
} 
function getkey($key1,$key2){ 
    $a = hexdec($key1); 
    $b = $a ^ 0xA55AA5A5; 
    $b = dechex($b); 
    return $key2.$b; 
} 
function getfileid($fileId,$seed) { 
    $mixed = getMixString($seed); 
    $ids = explode("*",$fileId); 
    unset($ids[count($ids)-1]); 
    $realId = ""; 
    for ($i=0;$i < count($ids);++$i) { 
    $idx = $ids[$i]; 
    $realId .= substr($mixed,$idx,1); 
    } 
    return $realId; 
} 
function getMixString($seed) { 
    $mixed = ""; 
    $source = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/\\:._-1234567890"; 
    $len = strlen($source); 
    for($i=0;$i< $len;++$i){ 
    $seed = ($seed * 211 + 30031) % 65536; 
    $index = ($seed / 65536 * strlen($source)); 
    $c = substr($source,$index,1); 
    $mixed .= $c; 
    $source = str_replace($c, "",$source); 
    } 
    return $mixed; 
} 