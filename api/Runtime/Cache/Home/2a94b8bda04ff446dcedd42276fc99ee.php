<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="margin: 0 auto">
<head>
<?php $quntiao_seo_meta = get_seo_meta($vars,$seo); ?>
<?php if($quntiao_seo_meta['title']): ?><title><?php echo ($quntiao_seo_meta['title']); ?></title>
<?php else: ?>
<title><?php echo C('WEB_SITE_TITLE');?></title><?php endif; ?>
<?php if($quntiao_seo_meta['keywords']): ?><meta name="keywords" content="<?php echo ($quntiao_seo_meta['keywords']); ?>"/><?php endif; ?>
<?php if($quntiao_seo_meta['description']): ?><meta name="description" content="<?php echo ($quntiao_seo_meta['description']); ?>"/><?php endif; ?>
<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon"
	href="http://img.quntiao.net/api/logo.png" type="image/x-icon">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no,address=no" />
<meta name="viewport"
	content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<link href="/Public/Static/css/core.css" type="text/css" rel="stylesheet" />

<link href="/Public/Home/css/index.css" type="text/css" rel="stylesheet" />

</head>
<body>
	 <?php echo W('IndexSlide/index');?> 
</body>