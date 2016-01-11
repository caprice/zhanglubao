<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<?php $quntiao_seo_meta = get_seo_meta($vars,$seo); ?>
<?php if($quntiao_seo_meta['title']): ?><title><?php echo ($quntiao_seo_meta['title']); ?></title>
<?php else: ?>
<title><?php echo C('WEB_SITE_TITLE');?></title><?php endif; ?>
<?php if($quntiao_seo_meta['keywords']): ?><meta name="keywords" content="<?php echo ($quntiao_seo_meta['keywords']); ?>"/><?php endif; ?>
<?php if($quntiao_seo_meta['description']): ?><meta name="description" content="<?php echo ($quntiao_seo_meta['description']); ?>"/><?php endif; ?>

<!--[if lt IE 9]> 
<script type="text/javascript" src="/Public/Static/js/jquery-1.11.1.min.js?v=1.0"></script>
 <![endif]-->

<!--[if gte IE 9]><!-->
<script type="text/javascript"  src="/Public/Static/js/jquery-2.1.1.min.js?v=1.0"></script>
<!--<![endif]-->

<link href="/Public/Static/css/core.css?v=1.0" type="text/css" rel="stylesheet" />
 


<link href="/Public/Home/css/index.css" type="text/css" rel="stylesheet" />

</head>
<body class="w1216">
	<div class="screen">
		<div class="header">
			<div class="header-logo">
				<div class="logo">
					<a title="群挑 quntiao.com" href="http://www.quntiao.com">群挑</a>
				</div>


				<div class="header-search">
					<form action="http://www.quntiao.com/search.html" method="get" target="_blank">
						<div class="header-search-box">
							<input class="header-search-text" type="text" autocomplete="off" name="keyword" value="<?php echo ((isset($keyword) && ($keyword !== ""))?($keyword):''); ?>"
								placeholder="Faker">
						</div>
						<div class="header-search-btn">
							<button class="header-search-submit" type="submit">
								<i class="iconfont">&#xe61d;</i>搜索
							</button>
						</div>
					</form>
					<a href="http://v.quntiao.com/top.html"
						class="header-rank iconfont" target="_blank" title="群挑排行榜">&#xe632;</a>

				</div>

			</div>
			<div class="header-nav">
				<div class="header_nav_main">
					<ul class="header-nav-master">
						<li><a href="http://www.quntiao.com">首页</a></li>
						<li><a href="http://v.quntiao.com/fresh.html">最新视频</a></li>
						<li><a href="http://v.quntiao.com/top.html">热门视频</a></li>
						<li><a href="http://v.quntiao.com/comm.html">解说视频</a></li>
						<li><a href="http://v.quntiao.com/master.html">高手视频</a></li>
						<li><a href="http://v.quntiao.com/match.html">比赛视频</a></li>
						<li><a href="http://v.quntiao.com/album.html">特别栏目</a></li>
						<li><a href="http://v.quntiao.com/other.html">其它视频</a></li>
					</ul>
					<ul class="header-nav-sub">
						<li id="header-nav-last"><a rel="nofollow" target="_blank"
							href="http://www.quntiao.com/app.html">APP下载</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="wrap">

			

<div class="main">
	<div class="mod"><?php echo W('IndexRec/recommends');?></div>
	<div class="mod"><?php echo W('IndexNew/videos');?></div>
	<div class="mod"><?php echo W('IndexAlbum/videos');?></div>
	<div class="mod"><?php echo W('IndexMaster/videos');?></div>
	<div class="mod"><?php echo W('IndexMatch/videos');?></div>
	<div class="mod"><?php echo W('IndexOther/videos');?></div>
</div>
<div class="side"><?php echo W('IndexSideUser/hots');?>
	<?php echo W('IndexSideRec/videos');?> <?php echo W('IndexSideTeam/teams');?>
	<?php echo W('IndexSideMatch/matches');?> <?php echo W('IndexSideAlbum/albums');?>
	<?php echo W('IndexSideCom/users');?></div>





		</div>
		<div class="footer">
			<div class="footer_inner">
				

<div class="footer_list">
	<div class="footer-col ">
		<dl>
			<dt>视频分类</dt>
			<dd>
				<a href="http://v.quntiao.com/top.html" target="_blank">热门视频</a> <a
					href="http://v.quntiao.com/fresh.html" target="_blank">最新视频</a> <a
					href="http://v.quntiao.com/top.html" target="_blank">排行榜</a> <a
					href="http://v.quntiao.com/master.html" target="_blank">高手榜</a> <a
					href="http://v.quntiao.com/comm.html" target="_blank">解说视频</a>
			</dd>
		</dl>
	</div>


	<div class="footer-col">
		<dl>
			<dt>游戏明星</dt>
			<dd>
				<a href="http://v.quntiao.com/master.html" target="_blank">高手视频</a>
				<a href="http://v.quntiao.com/match.html" target="_blank">比赛视频</a> <a
					href="http://v.quntiao.com/match.html" target="_blank">战队视频</a> <a
					href="http://v.quntiao.com/other.html" target="_blank">其它视频</a> <a
					href="http://v.quntiao.com/master.html" target="_blank">特别栏目</a>
			</dd>
		</dl>
	</div>
	<div class="footer-col">
		<dl>
			<dt>客户端下载</dt>
			<dd>
				<a href="http://www.quntiao.com/app.html" rel="nofollow"
					target="_blank">PC客户端</a><a href="http://www.quntiao.com/app.html"
					rel="nofollow" target="_blank">iPhone版</a> <a
					href="http://www.quntiao.com/app.html" rel="nofollow"
					target="_blank">iPad版</a> <a href="http://www.quntiao.com/app.html"
					rel="nofollow" target="_blank">Andoird Phone版</a> <a
					href="http://www.quntiao.com/app.html" rel="nofollow"
					target="_blank">Android Pad版</a>
			</dd>
		</dl>
	</div>
	<div class="footer-col">
		<dl>
			<dt>在线联系</dt>
			<dd>
				<a href="http://weibo.com/quntiao" target="_blank" rel="nofollow">新浪微博</a>
				<a href="http://t.qq.com/quntiao" rel="nofollow" target="_blank">腾讯微博</a>
				<a target="_blank"
					href="http://wpa.qq.com/msgrd?v=3&uin=2667069763&site=qq&menu=yes"
					rel="nofollow"><img src="/Public/Static/images/placeholder.png"
					lazy-src="http://img.quntiao.net/default/counseling_style_52.png"
					title="点击这里给我发消息" class="logo_img"></a> <a target="_blank"
					href="http://shang.qq.com/wpa/qunwpa?idkey=7171572b5ae8d3801b56204576200c59c4356eafdf19e0060e48e1e2b02f44db"><img
					border="0" src="/Public/Static/images/placeholder.png" rel="nofollow"
					lazy-src="http://pub.idqqimg.com/wpa/images/group.png"
					alt="群挑网" title="群挑网"></a>
			</dd>
		</dl>
	</div>

	<div class="footer-col ">

		<img src="/Public/Static/images/placeholder.png"
			lazy-src="http://img.quntiao.net/default/weixin.jpg" alt="群挑网微信"
			with="180px" height="180px" />
	</div>
</div>

<block name="script"> <script type="text/javascript"
	src="/Public/Home/js/jquery.tabs.js?v=1.0"></script> <script
	type="text/javascript">
		$("#newtab").tabso({
			cntSelect : "#newcontent",
			tabEvent : "mouseover",
			tabStyle : "normal"
		});

		$("#albumtab").tabso({
			cntSelect : "#albumcontent",
			tabEvent : "mouseover",
			tabStyle : "normal"
		});

		$("#mastertab").tabso({
			cntSelect : "#mastercontent",
			tabEvent : "mouseover",
			tabStyle : "normal"
		});

		$("#matchtab").tabso({
			cntSelect : "#matchcontent",
			tabEvent : "mouseover",
			tabStyle : "normal"
		});

		$("#othertab").tabso({
			cntSelect : "#othercontent",
			tabEvent : "mouseover",
			tabStyle : "normal"
		});
	</script> 

				<div class="mod_footer">

					<div class="footermenu">
						<a href="http://www.quntiao.com/about/quntiao.html" rel="nofollow"
							target="_blank">关于群挑</a> | <a
							href="http://www.quntiao.com/about/contact.html" rel="nofollow"
							target="_blank">我要投稿</a> | <a
							href="http://www.quntiao.com/about/contact.html" rel="nofollow"
							target="_blank">广告服务</a> | <a
							href="http://www.quntiao.com/about/contact.html" rel="nofollow"
							target="_blank">问题反馈</a> | <a
							href="http://www.quntiao.com/about/contact.html" rel="nofollow"
							target="_blank">联系我们</a>
					</div>

					<div class="copyrighten">
						Copyright © 2009 - <span><script>
							document.write(new Date().getFullYear());
						</script></span> Quntiao. <a target="_blank"  rel="nofollow">All
							Rights Reserved.</a>
					</div>
					<div class="copyrightzh">
						群挑网 蜀ICP备08111247号 <a target="_blank" rel="nofollow">版权所有</a>
					</div>
				</div>


			</div>
		</div>
	</div>
	 
	<script type="text/javascript">
	
	</script>
	<script src="/Public/Static/js/lazyload.js?v=1.0"></script>
	
	
	<div style="display:none">
	<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F43904e78c51101e47654fc376d7c63fb' type='text/javascript'%3E%3C/script%3E"));
</script>
	
	</div>
</body>
</html>