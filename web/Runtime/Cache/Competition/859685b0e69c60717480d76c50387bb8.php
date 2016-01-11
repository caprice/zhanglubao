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

<script type="text/javascript" src="/Public/Competition/js/index.js"></script>
<link href="/Public/Competition/css/index.css" rel="stylesheet" />
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
				<div class="row"><?php echo W('CAd/lists');?></div>
				<div class="row">
					<div class="col-xs-12  column-content">
						<div class="column-content-title">
							<i class="title-tip-box"></i> <span class="title-tip"><a
								href="#">最新联赛</a></span> <span class="recommend-tag"><a href="#">英雄联盟</a>
								<a href="#">DOTA2</a> <a href="#">炉石传说</a> <a href="#">穿越火线</a>
								<a href="#">地下城与勇士</a> </span> <span class="pull-right"> <a
								href="<?php echo U('/match/index');?>">更多比赛</a></span>
						</div>
					</div>
					<div class="col-xs-12  column-content">
						<div class="match-list">
							<ul>
								<?php if(is_array($matches)): $i = 0; $__LIST__ = $matches;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$match): $mod = ($i % 2 );++$i;?><li class="match-item">
									<div class="match-item-image">
									
									<a href="<?php echo U('/match/'.$match['id']);?>">
										<img width="273" height="118"
											src="/Public/Core/images/placeholder.png"
											lazy-src="<?php echo query_picture('url',$match['cover']);?>"
											alt="<?php echo ($matche["title"]); ?>">
											
											</a>
									</div>
									<div class="match-item-innr ">
										<div class="match-item-tit">	<a href="<?php echo U('/match/'.$match['id']);?>"><?php echo ($match["title"]); ?></a></div>
										<div class="match-item-date">活动时间：<?php echo date('Y-m-d',$match['start_time']);?>~<?php echo date('Y-m-d',$match['end_time']);?></div>
									</div> <span class="match-item-name"><?php echo get_game($match['game_id'],'title');?></span>
									<i class="match-item-sbg "></i> <?php if($match['match_status'] < 2): ?><div class="match-item-times">
										<?php if($match['days'] < 3000): ?><em>
											<?php echo ($match['days']); ?> </em>天<br>
										后结束 <?php else: ?> <span class="match-item-timesred">永久</span><?php endif; ?>
									</div>
									<?php else: ?>
									<div class="match-item-times match-item-timesgray">已结束</div><?php endif; ?>
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<!-- New GameMatch -->
				<div class="row">
					<div class="col-xs-12  column-content">
						<div class="column-content-title">
							<i class="title-tip-box"></i> <span class="title-tip"><a
								href="#">最新比赛</a></span> <span class="recommend-tag"><a href="#">英雄联盟</a>
								<a href="#">DOTA2</a> <a href="#">炉石传说</a> <a href="#">穿越火线</a>
								<a href="#">地下城与勇士</a> </span> <span class="pull-right"> <a href="<?php echo U('/matchgame/index');?>">更多比赛</a></span>
						</div>
					</div>
					<div class="col-xs-12  column-content">
						<div class="guess-list">
							<ul>
								<?php if(is_array($guesses)): $i = 0; $__LIST__ = $guesses;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$guess): $mod = ($i % 2 );++$i;?><li class="guess-item">
									<div class="guess-item-content">
										<div class="col-xs-4">
											<?php if($guess['blue_team']): ?><a
												href="<?php echo U('/matchgame/'.$guess['id']);?>"> <img
												src="/Public/Core/images/placeholder.png"
												lazy-src="<?php echo query_team('cover',$guess['blue_team']);?>"
												alt="<?php echo ($video['title']); ?>" width="50" height="50">
											</a> <?php else: ?>
											<div class="vs">弃权</div><?php endif; ?>
										</div>
										<div class="col-xs-4 vs">VS</div>
										<div class="col-xs-4">
											<?php if($guess['red_team']): ?><a
												href="<?php echo U('/matchgame/'.$guess['id']);?>"> <img
												src="/Public/Core/images/placeholder.png"
												lazy-src="<?php echo query_team('cover',$guess['red_team']);?>"
												alt="<?php echo ($video['title']); ?>" width="50" height="50">
											</a> <?php else: ?>
											<div class="vs">弃权</div><?php endif; ?>
										</div>
									</div>
									<div class="guess-team-name">
										<ul>
											<li><?php if($guess['blue_team']): ?><a href="<?php echo U('/matchgame/'.$guess['id']);?>"><?php echo query_team('name',$guess['blue_team']);?></a>
												<?php else: ?> 弃权<?php endif; ?></li>
											<li></li>
											<li><?php if($guess['red_team']): ?><a
													href="<?php echo U('/matchgame/'.$guess['id']);?>"><?php echo query_team('name',$guess['red_team']);?></a>
												<?php else: ?> 弃权<?php endif; ?></li>
										</ul>
									</div>
									<div class="guess-item-des">
										<ul>
											<li><span class="pull-left"><a
													href="<?php echo U('/matchgame/'.$guess['id']);?>"><?php echo get_game($guess['game_id'],'title');?></a></span>
												<span class="pull-right"><?php echo date('m-d
													H:i',$guess['start_time']);?></span></li>
											<li><span class="pull-left"><a
													href="<?php echo U('/matchgame/'.$guess['id']);?>"><?php echo query_match('title',$guess['match_id']);?></a></span>
												<span class="pull-right"><a class="submit-guess"
													href="<?php echo U('/matchgame/'.$guess['id']);?>">竞猜</a></span></li>
										</ul>
									</div>
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<!-- New GameMatch Video -->
				<div class="row">
					<div class="col-xs-12  column-content">
						<div class="column-content-title">
							<i class="title-tip-box"></i> <span class="title-tip"><a
								href="#">最新比赛视频</a></span> <span class="recommend-tag"><a
								href="#">英雄联盟</a> <a href="#">DOTA2</a> <a href="#">炉石传说</a> <a
								href="#">穿越火线</a> <a href="#">地下城与勇士</a> </span> <span
								class="pull-right"> <a href="#">更多联赛</a></span>
						</div>
					</div>
					<div class="col-xs-12  column-content">
						<div class="video-list">
							<ul>
								<?php if(is_array($videos)): $i = 0; $__LIST__ = $videos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><li>
									<div class="video-thumb">
										<a href="<?php echo U('/video/'.$video['id']);?>"> <img
											src="/Public/Core/images/placeholder.png"
											lazy-src="<?php echo query_picture('url',$video['cover']);?>"
											alt="<?php echo ($video['title']); ?>" width="216px" height="120px">
										</a>
										<div class="video-name">
											<span><?php echo ($video['title']); ?></span>
										</div>
									</div>
									<div class="video-des">
										<span class="pull-left"> <span
											class="glyphicon glyphicon-facetime-video "></span> <span
											class="game-des-online"><?php echo ($video['views']); ?>人</span></span> <span
											class="pull-right ">
											<?php echo get_game($video['game_id'],'title');?> </span>
									</div>
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<!-- series 系列赛事 -->
				<div class="row">
					<div class="col-xs-12  column-content">
						<div class="column-content-title">
							<i class="title-tip-box"></i> <span class="title-tip"><a
								href="#">系列赛事</a></span> <span class="recommend-tag"><a href="#">英雄联盟</a>
								<a href="#">DOTA2</a> <a href="#">炉石传说</a> <a href="#">穿越火线</a>
								<a href="#">地下城与勇士</a> </span> <span class="pull-right"> <a
								href="<?php echo U('/series/index');?>">更多系列赛</a></span>
						</div>
					</div>
					<div class="col-xs-12  column-content">
						<div class="series-list">
							<ul>
								<?php if(is_array($serieses)): $i = 0; $__LIST__ = $serieses;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$series): $mod = ($i % 2 );++$i;?><li>
									<div class="series-thumb">
										<a href="<?php echo U('/series/'.$series['id']);?>"> <img
											src="/Public/Core/images/placeholder.png"
											lazy-src="<?php echo query_picture('url',$series['cover']);?>"
											alt="<?php echo ($series['title']); ?>" width="216px" height="120px">
										</a>
										<div class="series-name">
											<span><?php echo ($series['title']); ?></span>
										</div>
									</div>
									<div class="series-des">
										<span class="pull-left"> <span
											class="glyphicon glyphicon-facetime-video "></span> <span
											class="game-des-online"><?php echo ($series['match_count']); ?>个赛季</span></span> <span
											class="pull-right ">
											<?php echo get_game($series['game_id'],'title');?> </span>
									</div>
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- right side -->
			<div class="col-xs-3">
				<div>
					<div class="right-want-box">
						<div class="row">
							<div class="col-xs-2">
								<span class="glyphicon glyphicon-bell want-box-icon "></span>
							</div>
							<div class="col-lg-4">
								<a href="#" class="want-box-text" rel="nofollow">我的关注</a>
							</div>
							<div class="col-xs-1">
								<span class="glyphicon glyphicon-stats want-box-share-icon "></span>
							</div>
							<div class="col-xs-4">
								<a href="#" class="want-box-text" rel="nofollow">我的竞猜</a>
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-xs-12  column-content">
							<div class="column-content-title">
								<i class="title-tip-box"></i> <span class="title-tip">热门比赛</span> <span class="pull-right"> <a href="<?php echo U('/matchgame/index');?>">更多比赛</a></span>
							</div>

							<?php echo W('HotMatchGame/lists');?>
						</div>
					</div>

					<!-- hot team -->
					<div class="row">
						<div class="col-xs-12  column-content">
							<div class="column-content-title">
								<i class="title-tip-box"></i> <span class="title-tip"><a
									href="#">热门战队</a></span> <span class="pull-right"> <a href="#">更多战队</a></span>
							</div>
							<div class="teams">
								<ul>
									<?php if(is_array($teams)): $i = 0; $__LIST__ = $teams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team): $mod = ($i % 2 );++$i;?><li class="col-xs-4">
										<div>
											<a href="<?php echo U('/team/'.$team['id']);?>"> <img
												src="/Public/Core/images/placeholder.png"
												lazy-src="<?php echo query_team('cover',$team['id']);?>"
												alt="<?php echo ($team['name']); ?>" width="52" height="52"></a>
										</div>
										<div class="team_name"><?php echo ($team['name']); ?></div>
									</li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</div>
						</div>
					</div>
					<!-- hot player -->
					<div class="row">
						<div class="col-xs-12  column-content">
							<div class="column-content-title">
								<i class="title-tip-box"></i> <span class="title-tip"><a
									href="#">热门选手</a></span> <span class="pull-right"> <a href="#">更多选手</a></span>
							</div>
							<div class="members">
								<ul>
									<?php if(is_array($members)): $i = 0; $__LIST__ = $members;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$member): $mod = ($i % 2 );++$i;?><li><?php $user = query_user(array('avatar','username'),$member['uid']); ?>

										<div class="anchors-thumb">
											<a href="<?php echo U('/user/'.$member['uid']);?>"><img
												src="/Public/Core/images/placeholder.png"
												lazy-src="<?php echo ($user["avatar"]); ?>" height="84" width="84" /> </a>
										</div>
										<div class="members-des"><?php echo ($user["username"]); ?></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</div>
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