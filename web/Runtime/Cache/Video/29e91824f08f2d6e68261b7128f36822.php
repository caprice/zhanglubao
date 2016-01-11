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
	href="/Public/Core/js/ext/toastr/toastr.min.css" />
<link href="/Public/Core/css/core.css" rel="stylesheet" />


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
	src="/Public/Core/js/ext/toastr/toastr.min.js"></script>
<script type="text/javascript"
	src="/Public/Core/js/ext/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript"
	src="/Public/Static/jquery.iframe-transport.js"></script>

<script type="text/javascript" src="/Public/Core/js/core.js"></script>

<script type="text/javascript">

    (function () {

        var ThinkPHP = window.Think = {
            "ROOT": "", //当前网站地址
            "APP": "", //当前项目地址
            "PUBLIC": "/Public", //项目公共目录地址
            "DEEP": "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL": ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR": ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"],
            'URL_MODEL': "<?php echo C('URL_MODEL');?>"
        }
    })();
</script>

<script>
//全局内容的定义
	var _ROOT_ = "";
	var MID = "<?php echo is_login();?>";
	var MODULE_NAME="<?php echo MODULE_NAME; ?>";
	var ACTION_NAME="<?php echo ACTION_NAME; ?>";
	var MODULE_NAME = "<?php echo MODULE_NAME; ?>";
</script>

<audio id="music" src="" autoplay="autoplay"></audio>


<?php echo hook('pageHeader');?>

<link href="/Public/Video/css/view.css" rel="stylesheet" />
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-logo" href="http://www.quntiao.com"> <img
				src="/Public/Core/images/quntiao-logo.png" />
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


				<li class="dropdown"><?php $common_header_user = query_user(array('avatar')); ?> <a role="button"
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
				<div class="video-title-info">
					<i class="video-title-tip-box"></i> <span class="video-title-tip">
						<span class="title-content">
							<h3><?php echo ($video["title"]); ?></h3>
					</span>
					</span> </span>
				</div>
				<div class="video-team-info">


					<div class="video-info">
						<embed align="none" allowfullscreen="true"
							allowscriptaccess="never" class="edui-faked-video" height="542"
							loop="false" menu="false" play="true"
							pluginspage="http://www.macromedia.com/go/getflashplayer"
							src="<?php echo ($video["flash_url"]); ?>" type="application/x-shockwave-flash"
							width="890" wmode="transparent">
					</div>


				</div>
				<!-- 视频操作 -->
				<div class="video-base-info">
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

					<div class="video-match-game-tag">
						<span>游戏：<a href="<?php echo U('/game/'.$video['game_id']);?>"><?php echo get_game($video['game_id'],'title');?></a></span>

						<span>标签:</span>
						<ul>
							<?php if(is_array($video['format_tags'])): $i = 0; $__LIST__ = $video['format_tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$format_tag): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/tag/'.$format_tag);?>"><?php echo ($format_tag); ?></a>
							<li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>

				</div>

				<!-- 个人信息 -->
				<div class="video-user-info">

					<div class="user-area">
						<?php $user = query_user(array('avatar','username'),$video['uid']); ?>

						<div class="user-thumb">
							<a href="<?php echo U('/u/'.$video['id']);?>"><img
								src="/Public/Core/images/placeholder.png"
								lazy-src="<?php echo ($user["avatar"]); ?>" height="84" width="84" /> </a>
						</div>

						<div class="user-info">

							<div class="user-name">
								<a href="<?php echo U('/u/'.$video['uid']);?>"><?php echo ($user["username"]); ?></a>
							</div>

							<div class="user-subscription">

								<a href="javascript:;" class="btn-user-subscription"
									id="mod_follow_btn" data-value="<?php echo ($video["uid"]); ?>">订阅</a>
							</div>

						</div>
					</div>

					<div class="video-info-area">

						<div class="title">
							<h4><?php echo ($video["title"]); ?></h4>
						</div>
						<div class="tags">
							<span><span class="info-label">添加时间:</span><?php echo date('Y-m-d',$video['create_time']);?></span>
							<span>
								<ul>
									<?php if(is_array($video['format_tags'])): $i = 0; $__LIST__ = $video['format_tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$format_tag): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/tag/'.$format_tag);?>"><?php echo ($format_tag); ?></a>
									<li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</span>
						</div>
						<div class="description">
							<span class="info-label">简介:</span><span class="pull-left"><p><?php echo ($video["description"]); ?></p></span>
						</div>
					</div>

				</div>


				<div class="">

					<div class="column-content">
						<div class="column-content-title">
							<i class="title-tip-box"></i> <span class="title-tip"><a
								href="<?php echo U('/u/'.$video['uid']);?>">作者最新视频 </a></span> </span> <span
								class="pull-right"> <a
								href="<?php echo U('/u/'.$video['uid']);?>">更多视频</a>
							</span>
						</div>
					</div>
					<div class="column-content">

						<div class="author-video-list">
							<ul>
								<?php if(is_array($uservideos)): $i = 0; $__LIST__ = $uservideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$uservideo): $mod = ($i % 2 );++$i;?><li>
									<div class="author-video-thumb">
										<a href="<?php echo U('/video/'.$uservideo['id']);?>"> <img
											src="/Public/Core/images/placeholder.png"
											lazy-src="<?php echo query_picture('url',$uservideo['cover']);?>"
											alt="<?php echo ($uservideo['title']); ?>" width="216px" height="120px">
										</a>
									</div>
									<div class="author-video-des"><?php echo ($uservideo["title"]); ?></div>
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>


				</div>


				<div class="comment">
					<!-- 多说评论框 start -->
					<div class="ds-thread" data-thread-key="video-<?php echo ($video['id']); ?>"
						data-title="<?php echo ($video["title"]); ?>"
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



				<div class="row">
					<div class="col-xs-12  column-content">
						<div class="column-content-title">
							<i class="title-tip-box"></i> <span class="title-tip"><a
								href="<?php echo U('competition/video');?>">相关视频</a></span> <span
								class="pull-right"></span>
						</div>
					</div>
					<div class="col-xs-12  column-content">
						<div class="side-matchvideo-list">
							<ul>
								<?php if(is_array($nearvideos)): $i = 0; $__LIST__ = $nearvideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nearvideo): $mod = ($i % 2 );++$i;?><li>

									<div class="v-thumb">
										<a href="<?php echo U('/video/'.$nearvideo['id']);?>" onclick=""> <img
											src="/Public/Core/images/placeholder.png"
											lazy-src="<?php echo query_picture('url',$nearvideo['cover']);?>"
											alt="<?php echo ($nearvideo['title']); ?>" width="145px" height="80px"></a>

									</div>

									<div class="v-meta">

										<div class="v-meta-title">
											<a href="<?php echo U('/video/'.$nearvideo['id']);?>"><?php echo ($nearvideo['title']); ?></a>

										</div>

										<div class="v-num">
											<span class="glyphicon glyphicon-facetime-video  "></span> <span
												class="v-meta-des"><?php echo ($nearvideo['views']); ?></span>
										</div>
									</div>

								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>
				</div>

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


<script type="text/javascript" src="/Public/Core/js/ext/magnific/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="/Public/Core/js/ext/placeholder/placeholder.js"></script>
<script type="text/javascript" src="/Public/Core/js/ext/atwho/atwho.js"></script>
<link type="text/css" rel="stylesheet" href="/Public/Core/js/ext/atwho//atwho.css"/>
 <script
	src="/Public/Core/js/lazyload.js"></script> 
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden">
	
</div>

	<!-- /底部 -->
</body>
</html>