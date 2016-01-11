<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<?php $quntiao_seo_meta = get_seo_meta($vars); ?>
<?php if($quntiao_seo_meta['title']): ?><title><?php echo ($quntiao_seo_meta['title']); ?></title>
<?php else: ?>
<title><?php echo C('WEB_SITE_TITLE');?></title><?php endif; ?>
<?php if($quntiao_seo_meta['keywords']): ?><meta name="keywords" content="<?php echo ($quntiao_seo_meta['keywords']); ?>" /><?php endif; ?>
<?php if($quntiao_seo_meta['description']): ?><meta name="description" content="<?php echo ($quntiao_seo_meta['description']); ?>" /><?php endif; ?>

<link href="/Public/Static/bootstrap/css/bootstrap.css" rel="stylesheet" />
<link type="text/css" rel="stylesheet"
	href="/Public/Static/qtip/jquery.qtip.css" />
<link type="text/css" rel="stylesheet"
	href="/Public/Static/quntiao/js/ext/toastr/toastr.min.css" />
<link href="/Public/Static/quntiao/css/core.css" rel="stylesheet" />


<!-- 增强IE兼容性 -->
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]><!-->
<script src="/Public/Static/bootstrap/js/html5shiv.js"></script>
<script src="/Public/Static/bootstrap/js/respond.js"></script>
<!--<!--[endif]-->



<!--[if lt IE 9]> 
<script type="text/javascript" src="/Public/Static/jquery-1.11.1.min.js"></script>
 <![endif]-->

<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/Static/jquery-2.1.1.min.js"></script>
<!--<![endif]-->



<!-- Bootstrap库 -->
<script type="text/javascript"
	src="/Public/Static/bootstrap/js/bootstrap.min.js"></script>

<!-- 其他库 -->
<script src="/Public/Static/qtip/jquery.qtip.js"></script>
<script type="text/javascript"
	src="/Public/Static/quntiao/js/ext/toastr/toastr.min.js"></script>
<script type="text/javascript"
	src="/Public/Static/quntiao/js/ext/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript"
	src="/Public/Static/jquery.iframe-transport.js"></script>

<script type="text/javascript" src="/Public/Static/quntiao/js/core.js"></script>

<script>
	//全局内容的定义
	var _ROOT_ = "";
	var MID = "<?php echo is_login();?>";
	var MODULE_NAME = "<?php echo MODULE_NAME; ?>";
</script>

<audio id="music" src="" autoplay="autoplay"></audio>


<?php echo hook('pageHeader');?>

<link href="/Public/Competition/css/matchgame.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/Competition/js/scrollview.js"></script>
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-logo" href="http://www.quntiao.com"> <img
				src="/Public/Static/quntiao/image/quntiao-logo.png" />
			</a>
		</div>
		<div>
			<ul class="nav navbar-nav " style="font-size: 16px">
				<li><a href="<?php echo U('/competition/index');?>">比赛</a></li>
		
				<li><a href="<?php echo U('/fight/index');?>">约战</a></li>
				<li><a href="<?php echo U('/live/index');?>">直播</a></li>
				<li><a href="<?php echo U('/video/index');?>">视频</a></li>
				<li><a href="<?php echo U('/team/index');?>">战队</a></li>
				<li><a href="<?php echo U('/shop/index');?>">商城</a></li>
				<li><a href="<?php echo U('/client/index');?>" rel="nofollow">客户端</a></li>
			</ul>
			<form id="frm_search" class="navbar-form navbar-left " role="search"
				method="post" action="/">
				<div class="form-group form-control"
					style="border-radius: 2em; padding-right: 0; margin-top: 5px; padding-top: 5px;">
					<input id="search_keywords" type="text" name="keywords" class=""
						style="border: none; width: 82%; outline: none;"
						placeholder="输入关键字"> <i id="sbt_search"
						style="color: rgb(72, 184, 122)"
						class="glyphicon glyphicon-search"></i>
				</div>
			</form>
			<?php if(is_login()): ?><ul class="nav navbar-nav navbar-right">

				<li class="dropdown op_nav_ico ">
					<ul class="dropdown-menu extended notification">
						<li style="padding-left: 15px; padding-right: 15px;">
							<div class="row nav_info_center">
								<div class="col-xs-9 nav_align_left">
									<span id="nav_hint_count"><?php echo count($unreadMessage);?></span> 条未读
								</div>
								<div class="col-xs-3">
									<i onclick="setAllReaded()"
										class="set_read glyphicon glyphicon-ok" title="全部标为已读"></i>
								</div>
							</div>
						</li>
						<li>
							<div
								style="position: relative; width: auto; overflow: hidden; max-height: 250px">
								<ul id="nav_message" class="dropdown-menu-list scroller "
									style="width: auto;">
									<?php if(count($unreadMessage) == 0): ?><div
										style="font-size: 18px; color: #ccc; font-weight: normal; text-align: center; line-height: 150px">
										暂无任何消息!</div>
									<?php else: ?> <?php if(is_array($unreadMessage)): $i = 0; $__LIST__ = $unreadMessage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$message): $mod = ($i % 2 );++$i;?><li><a data-url="<?php echo ($message["url"]); ?>"
										onclick="readMessage(this,<?php echo ($message["id"]); ?>)"> <i
											class="glyphicon glyphicon-bell"></i> <?php echo ($message["title"]); ?> <span
											class="time"> <?php echo ($message["ctime"]); ?> </span>
									</a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>

								</ul>
							</div>

						</li>
						<li class="external"><a
							href="<?php echo U('Usercenter/Message/message');?>"> 查看全部 <i
								class="glyphicon glyphicon-circle-arrow-right"
								style="background: none; color: rgb(72, 184, 122)"></i>
						</a></li>
					</ul> <script>
                $(function () {
                    $('.scroller').slimScroll({
                        height: '150px'
                    });
                });
            </script> <a id="nav_info dropdown-toggle " data-toggle="dropdown"><i
						class="glyphicon glyphicon-bullhorn"></i> <span
						id="nav_bandage_count"<?php if(count($unreadMessage) == 0): ?>style="display:
							none"<?php endif; ?> class="badge pull-right"><?php echo count($unreadMessage);?></span> &nbsp; </a>
				</li>


				<li class="dropdown"><?php $common_header_user = query_user(array(avatar)); ?> <a role="button"
					class="dropdown-toggle" data-toggle="dropdown"> <img
						src="<?php echo ($common_header_user['avatar']); ?>" class="navbar-avatar-img" />
				</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo U('UserCenter/Index/index');?>"><span
								class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;个人中心</a></li>
						<li><a href="<?php echo U('UserCenter/Message/session');?>"><span
								class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;我的会话</a></li>
						<li><a href="<?php echo U('UserCenter/Forum/myTopic');?>"><span
								class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;我的主题</a></li>
						<li><a href="<?php echo U('UserCenter/Forum/myTakePartIn');?>"><span
								class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;我的参与</a></li>
						<li><a href="<?php echo U('UserCenter/Forum/myBookmark');?>"><span
								class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;我的收藏</a></li>
						<?php if(is_administrator()): ?><li><a href="<?php echo U('Admin/Index/index');?>" target="_blank"><span
								class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;管理后台</a></li><?php endif; ?>
						<li><a event-node="logout"><span
								class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;注销</a></li>
					</ul></li>
			</ul>
			<?php else: ?>
			<ul class="nav navbar-nav navbar-right">
				<!--登录注册-->
				<li><a href="<?php echo U('/user/login');?>" rel="nofollow">登录</a></li>
				<li><a href="<?php echo U('/user/reg');?>" rel="nofollow">注册</a></li>
			</ul><?php endif; ?>
		</div>
	</div>
</div>
<a id="goTopBtn"></a>
	<div id="main-container" class="container">
		<div class="row">
			<!-- left side -->
			<div class="col-xs-9">
				<div class="vs-title-info">
					<i class="vs-title-tip-box"></i> <span class="vs-title-tip">
						<span class="title-content"> <span class="match-name"><a
								href="<?php echo U('/match/'.$matchgame['match_id']);?>"><?php echo query_match('title',$matchgame['match_id']);?></a></span>
							<span class="match-game-title"><h3>
									<a href="<?php echo U('/team/'.$matchgame['blue_team']);?>">
										<?php echo query_team('name',$matchgame['blue_team']);?> </a><b><?php echo ($matchgame['blue_result']); ?>:<?php echo ($matchgame['red_result']); ?></b> <a
										href="<?php echo U('/team/'.$matchgame['red_team']);?>"><?php echo query_team('name',$matchgame['red_team']);?>
									</a>
								</h3></span> <span class="match-game-category"> <a
								href="<?php echo U('/game/'.$matchgame['game_id']);?>"><?php echo get_game($matchgame['game_id'],'title');?></a>
						</span>
					</span>
				</div>
				<div class="vs-team-info">
					<div class="vs-blue-team">
						<ul>
							<?php if(is_array($bluemembers)): $i = 0; $__LIST__ = $bluemembers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bluemember): $mod = ($i % 2 );++$i;?><li><div>
								<a href="<?php echo U('/u/'.$bluemember['uid']);?>">	<img src="/Public/Static/quntiao/image/placeholder.png"
										width="80px" height="80px"
										lazy-src="<?php echo query_user('avatar',$bluemember['uid']);?>"></a>
								</div>

								<div class="vs-user-name">
									<span> <?php echo query_user('username',$bluemember['uid']);?> </span>

								</div></li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>

					<div class="vs-info">
						<embed align="none" allowfullscreen="true"
						allowscriptaccess="never" class="edui-faked-video" height="500"
						loop="false" menu="false" play="true"
						pluginspage="http://www.macromedia.com/go/getflashplayer"
						src="<?php echo current($gamevideos)['flash_url'] ?>"
						type="application/x-shockwave-flash" width="730"
						wmode="transparent">
					</div>

					<div class="vs-red-team">
						<ul>
							<?php if(is_array($redmembers)): $i = 0; $__LIST__ = $redmembers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$redmember): $mod = ($i % 2 );++$i;?><li>
								<div>
									<a href="<?php echo U('/u/'.$redmember['uid']);?>"><img src="/Public/Static/quntiao/image/placeholder.png"
										width="80px" height="80px"
										lazy-src="<?php echo query_user('avatar',$redmember['uid']);?>"></a>
								</div>
								<div class="vs-user-name"><?php echo query_user('username',$redmember['uid']);?></div>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
				<!-- action row -->
				<div class="vs-base-info">
					<div class="mod－action">
						<div class="action-item action-collect">
							<a> <span class="glyphicon glyphicon-star  action-item-icon"></span><span
								class="action-item-text"> 收藏</span>
							</a>
						</div>
						<div class="action-item action-share">
							<a> <span class="glyphicon glyphicon-share action-item-icon"></span><span
								class="action-item-text"> 分享</span>
							</a>
						</div>
						<div class="action-item action-phone">
							<a> <span class="glyphicon glyphicon-phone action-item-icon"></span><span
								class="action-item-text">手机观看</span>
							</a>
						</div>
					</div>

					<div class="vs-match-game-tag">
						<span>标签:</span>
						<ul>
							<?php if(is_array($matchgame['format_tags'])): $i = 0; $__LIST__ = $matchgame['format_tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$format_tag): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/tag/'.$format_tag);?>"><?php echo ($format_tag); ?></a>
							<li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>

				</div>

				<div class="other-match-game">

					<span id="prev_btn"
						class="other-match-game-prev glyphicon glyphicon-chevron-left"></span>

					<div class="inner" id="inner">
						<ul class="inner-ul">
							<?php if(is_array($nearmatchgames)): $i = 0; $__LIST__ = $nearmatchgames;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nearmatchgame): $mod = ($i % 2 );++$i;?><li>
								<div class="match-team">
									<div class="match-team-item">
										<?php if($nearmatchgame['blue_team']): ?><a
											href="<?php echo U('/matchgame/'.$nearmatchgame['id']);?>"> <img
											src="<?php echo query_team('cover',$nearmatchgame['blue_team']);?>"
											width="50" height="50">
										</a> <?php else: ?>
										<div class="vs">弃权</div><?php endif; ?>

									</div>
									<div class="match-team-vs">VS</div>
									<div class="match-team-item">
										<?php if($nearmatchgame['red_team']): ?><a
											href="<?php echo U('/matchgame/'.$nearmatchgame['id']);?>"> <img
											src="<?php echo query_team('cover',$nearmatchgame['red_team']);?>"
											width="50" height="50">
										</a> <?php else: ?>
										<div class="vs">弃权</div><?php endif; ?>

									</div>

								</div>

								<div class="match-info">
									<div class="match-team-item">
										<a href="<?php echo U('/matchgame/'.$nearmatchgame['id']);?>"><?php echo query_team('name',$nearmatchgame['blue_team']);?></a>
									</div>
									<div class="match-team-vs">:</div>
									<div class="match-team-item">
										<a href="<?php echo U('/matchgame/'.$nearmatchgame['id']);?>"><?php echo query_team('name',$nearmatchgame['red_team']);?></a>
									</div>
								</div>


							</li><?php endforeach; endif; else: echo "" ;endif; ?>

						</ul>
					</div>
					<span id="next_btn"
						class="other-match-game-next glyphicon glyphicon-chevron-right"></span>
				</div>

				<div class="comment">
					<!-- 多说评论框 start -->
					<div class="ds-thread" data-thread-key="matchgame-<?php echo ($matchgame['id']); ?>"
						data-title="<?php echo query_team('name',$matchgame['blue_team']);?> vs <?php echo query_team('name',$matchgame['red_team']);?>"
						data-url="http://www.quntiao.com/matchgame/<?php echo ($matchgame["id"]); ?>.html"></div>
					<!-- 多说评论框 end -->
					<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
					<script type="text/javascript">
						var duoshuoQuery = {
							short_name : "quntiao"
						};
						(function() {
							var ds = document.createElement('script');
							ds.type = 'text/javascript';
							ds.async = true;
							ds.src = (document.location.protocol == 'https:' ? 'https:'
									: 'http:')
									+ '//static.duoshuo.com/embed.js';
							ds.charset = 'UTF-8';
							(document.getElementsByTagName('head')[0] || document
									.getElementsByTagName('body')[0])
									.appendChild(ds);
						})();
					</script>
					<!-- 多说公共JS代码 end -->

				</div>


			</div>
			<!-- right side -->
			<div class="col-xs-3">
				<!-- guess -->
				<div class="row">
					<div class="guess-detail-win">
						<div class="guess-item-detail">
							<span class="guess-item-detail-win"><?php echo query_team('name',$matchgame['blue_team']);?>
								胜</span> <span class="guess-item-detail-even">平</span> <span
								class="guess-item-detail-win"><?php echo query_team('name',$matchgame['red_team']);?>
								胜</span>
						</div>
					</div>

				</div>
				

				<?php if($gamevideos): ?><div class="row">
					<div class="col-xs-12  column-content">
						<div class="column-content-title">
							<i class="title-tip-box"></i> <span class="title-tip"><a
								href="<?php echo U('competition/video');?>">本场视频</a></span> <span
								class="pull-right"> <a href="<?php echo U('competition/videos');?>">更多视频</a></span>
						</div>
					</div>
					<div class="col-xs-12  column-content">
						<div class="side-matchvideo-list">
							<ul>
								<?php if(is_array($gamevideos)): $i = 0; $__LIST__ = $gamevideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gamevideo): $mod = ($i % 2 );++$i;?><li>

									<div class="v-thumb">
										<a href="<?php echo U('/video/'.$gamevideo['id']);?>" onclick=""> <img
											src="/Public/Static/quntiao/image/placeholder.png"
											lazy-src="<?php echo query_picture('url',$gamevideo['cover']);?>"
											alt="<?php echo ($gamevideo['title']); ?>" width="145px" height="80px"></a>

									</div>

									<div class="v-meta">

										<div class="v-meta-title">
											<a href="<?php echo U('/video/'.$gamevideo['id']);?>"><?php echo ($gamevideo['title']); ?></a>

										</div>

										<div class="v-num">
											<span class="glyphicon glyphicon-facetime-video  "></span> <span
												class="game-des-online"><?php echo ($gamevideo['views']); ?></span>
										</div>
									</div>

								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>
				</div><?php endif; ?>


				<!-- new video -->
				<div class="row">
					<div class="col-xs-12  column-content">
						<div class="column-content-title">
							<i class="title-tip-box"></i> <span class="title-tip"><a
								href="<?php echo U('competition/video');?>">最新比赛视频</a></span> <span
								class="pull-right"> <a href="<?php echo U('competition/video');?>">更多视频</a></span>
						</div>
					</div>
					<div class="col-xs-12  column-content">
						<div class="side-matchvideo-list">
							<ul>
								<?php if(is_array($matchvideos)): $i = 0; $__LIST__ = $matchvideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$matchvideo): $mod = ($i % 2 );++$i;?><li>

									<div class="v-thumb">
										<a href="<?php echo U('/video/'.$matchvideo['id']);?>"> <img
											src="/Public/Static/quntiao/image/placeholder.png"
											lazy-src="<?php echo query_picture('url',$matchvideo['cover']);?>"
											alt="<?php echo ($matchvideo['title']); ?>" width="145px" height="80px"></a>

									</div>

									<div class="v-meta">

										<div class="v-meta-title">
											<a href="<?php echo U('/video/'.$matchvideo['id']);?>"><?php echo ($matchvideo['title']); ?></a>

										</div>

										<div class="v-num">
											<span class="glyphicon glyphicon-facetime-video  "></span> <span
												class="game-des-online"><?php echo ($matchvideo['views']); ?></span>
										</div>
									</div>

								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<div></div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function() {
			$(window).resize(
					function() {
						$("#main-container").css("min-height",
								$(window).height() - 343);
					}).resize();
		});
		
		 
		
		
	</script>
	<!-- /主体 -->
	<!-- 底部 -->
	<div class="foot">
	<div class="container">
		<div class="row">
			<div class="footer footer_list clearfix">
				<div class="footer-col ">
					<dl>
						<dt>英雄联盟</dt>
						<dd>
							<a href="#">热门直播</a> <a href="#">解说视频</a> <a href="#">高手视频</a> <a
								href="#">比赛视频</a> <a href="#">教学视频</a>
						</dd>
					</dl>
				</div>

				<div class="footer-col">
					<dl>
						<dt>游戏直播</dt>
						<dd>
							<a href="#">LOL直播</a> <a href="#">DOTA2直播</a> <a href="#">炉石传说直播</a>
							<a href="#">穿越火线直播</a> <a href="#">其他直播</a>
						</dd>
					</dl>
				</div>
				<div class="footer-col">
					<dl>
						<dt>游戏视频</dt>
						<dd>
							<a href="#">LOL视频</a> <a href="#">DOTA2视频</a> <a href="#">炉石传说视频</a>
							<a href="#">穿越火线视频</a> <a href="#">其他视频</a>
						</dd>
					</dl>
				</div>
				<div class="footer-col">
					<dl>
						<dt>客户端下载</dt>
						<dd>
							<a href="#" rel="nofollow">PC客户端</a><a href="#" rel="nofollow">iPhone版</a>
							<a href="#" rel="nofollow">iPad版</a> <a href="#" rel="nofollow">Andoird
								Phone版</a> <a href="#" rel="nofollow">Android Pad版</a>
						</dd>
					</dl>
				</div>
				<div class="footer-col">
					<dl>
						<dt>关于我们</dt>
						<dd>
							<a href="#" rel="nofollow">关于我们</a> <a href="#" rel="nofollow">联系方式</a>
							<a href="#" rel="nofollow">免责声明</a> <a href="#" rel="nofollow">问题反馈</a>
							<a href="#" rel="nofollow">广告合作</a>
						</dd>
					</dl>
				</div>
				<div class="footer-col">
					<dl>
						<dt>在线联系</dt>
						<dd>
							<a href="#" rel="nofollow">关于我们</a> <a href="#" rel="nofollow">联系方式</a>
							<a href="#" rel="nofollow">免责声明</a> <a href="#" rel="nofollow">问题反馈</a>
							<a href="#" rel="nofollow">广告合作</a>
						</dd>
					</dl>
				</div>
			</div>
			<p class="copyright">Copyright 群挑游戏网. All Rights Reserved.
				网站备案号：蜀ICP备08111247号-8</p>

		</div>
	</div>
</div>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "",  
		"APP"    : "", 
		"PUBLIC" : "/Public", 
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>",  
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>
 <script
	src="/Public/Static/quntiao/js/lazyload.js"></script> 
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden">
	
</div>

	<!-- /底部 -->
</body>
</html>