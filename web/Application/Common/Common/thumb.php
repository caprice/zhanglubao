<?php
 

function getImageUrlByPath($path, $size) {
    $thumb = getThumbImage($path, $size);
    $thumb = $thumb['src'];
    $thumb = substr($thumb,1);
    return getRootUrl().$thumb;
}

/**
 *  获取缩略图
 *  @param  unknown_type  $filename  原图路径、url
 *  @param  unknown_type  $width  宽度
 *  @param  unknown_type  $height  高
 *  @param  unknown_type  $cut  是否切割  默认不切割
 *  @return  string
 */
function getThumbImage($filename, $width=100, $height='auto', $cut=false, $replace=false) {
    $UPLOAD_URL='';
    $UPLOAD_PATH='';
    $filename  =  str_ireplace($UPLOAD_URL,  '',  $filename);  //将URL转化为本地地址
    $info  =  pathinfo($filename);
    $oldFile  =  $info['dirname']  .  DIRECTORY_SEPARATOR  .  $info['filename']  .  '.'  .  $info['extension'];
    $thumbFile  =  $info['dirname']  .  DIRECTORY_SEPARATOR  .  $info['filename']  .  '_'  .  $width  .  '_'  .  $height  .  '.'  .  $info['extension'];

    $oldFile  =  str_replace('\\',  '/',  $oldFile);
    $thumbFile  =  str_replace('\\',  '/',  $thumbFile);


    $filename  =  ltrim($filename,  '/');
    $oldFile  =  ltrim($oldFile,  '/');
    $thumbFile  =  ltrim($thumbFile,  '/');
    //原图不存在直接返回
    if  (!file_exists($UPLOAD_PATH  .  $oldFile))  {
        @unlink($UPLOAD_PATH  .  $thumbFile);
        $info['src']  =  $oldFile;
        $info['width']  =  intval($width);
        $info['height']  =  intval($height);
        return  $info;
        //缩图已存在并且  replace替换为false
    }  elseif  (file_exists($UPLOAD_PATH  .  $thumbFile)  &&  !$replace)  {
        $imageinfo  =  getimagesize($UPLOAD_PATH  .  $thumbFile);
        //dump($imageinfo);exit;
        $info['src']  =  $thumbFile;
        $info['width']  =  intval($imageinfo[0]);
        $info['height']  =  intval($imageinfo[1]);
        return  $info;
        //执行缩图操作
    }  else  {
        $oldimageinfo  =  getimagesize($UPLOAD_PATH  .  $oldFile);
        $old_image_width  =  intval($oldimageinfo[0]);
        $old_image_height  =  intval($oldimageinfo[1]);
        if  ($old_image_width  <=  $width  &&  $old_image_height  <=  $height)  {
            @unlink($UPLOAD_PATH  .  $thumbFile);
            @copy($UPLOAD_PATH  .  $oldFile,  $UPLOAD_PATH  .  $thumbFile);
            $info['src']  =  $thumbFile;
            $info['width']  =  $old_image_width;
            $info['height']  =  $old_image_height;
            return  $info;
        }  else  {
            //生成缩略图  -  更好的方法
            if  ($height  ==  "auto")  $height  =  0;
            //import('phpthumb.PhpThumbFactory');
            require_once('ThinkPHP/Library/Vendor/phpthumb/PhpThumbFactory.class.php');
            $thumb  =  PhpThumbFactory::create($UPLOAD_PATH  .  $filename);
            if  ($cut)  {
                $thumb->adaptiveResize($width,  $height);
            }  else  {
                $thumb->resize($width,  $height);
            }
            $res  =  $thumb->save($UPLOAD_PATH  .  $thumbFile);
            //缩图失败
            if  (!$res)  {
                $thumbFile  =  $oldFile;
            }
            $info['width']  =  $width;
            $info['height']  =  $height;
            $info['src']  =  $thumbFile;
            return  $info;
        }
    }
}

function getRootUrl() {
    return "http://$_SERVER[HTTP_HOST]$GLOBALS[_root]";
}


function getThumbImageById($cover_id, $width = 100, $height = 'auto', $cut = true, $replace = false)
{
    $picture = M('Picture')->where(array('status' => 1))->getById($cover_id);
    if(empty($picture))
    {
        return 'Public/Core/image/nopic.jpg';
    }
    $attach = getThumbImage($picture['path'], $width, $height, $cut, $replace);

    return $attach['src'];
}