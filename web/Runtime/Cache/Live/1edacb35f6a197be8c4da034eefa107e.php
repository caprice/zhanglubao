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

<link href="/Public/Live/css/view.css" rel="stylesheet" />
</head>
<body>

	<div class="playPage">

		<div class="playLeft" id="playLeft">
			<div class="leftNav">
				<div class="top">
					<a class="logo-nav" target="_self" href="/"> </a>

					<form id="frm_search" class="navbar-form navbar-left "
						role="search" method="post" action="/">
						<div class="form-group form-control"
							style="border-radius: 2em; padding-right: 0; margin-top: 5px; padding-top: 5px;">
							<input id="search_keywords" type="text" name="keywords" class=""
								style="border: none; width: 82%; outline: none;"
								placeholder="输入房间名称"> <i id="sbt_search"
								style="color: rgb(72, 184, 122)"
								class="glyphicon glyphicon-search"></i>
						</div>
					</form>
				</div>
				<div class="login-area">
					<a href="javascript:;"
						onclick="user_dialog.open_login(); return false;"
						class="login-btn">登录</a> <a href="javascript:;"
						onclick="user_dialog.open_reg(); return false;" class="login-btn">注册</a>

				</div>

				<div class="all-live">
					<a href="<?php echo U('/live/list');?>" class="live-bg"><span
						class="glyphicon glyphicon-facetime-video live-icon"></span>全部直播</a>
				</div>
				<div id="game_scroll"><?php echo W('ViewGames/lists');?></div>
			</div>
			<div class="leftSmallNav"></div>

		</div>
		<div class="playCenter" id="playCenter">
			<div id="playArea">
				<a id="left_close" class="left_close   "> <span></span>
				</a>

				<?php $user = query_user(array('avatar','username'),$live['uid']); ?>
				<div class="live-main" id="live_main">
					<div class="user-info">
						<div id="live_switch"></div>
						<div class="avatar">
							<a href="<?php echo U('/u/'.$live['id']);?>"> <img
								src="/Public/Core/images/placeholder.png"
								lazy-src="<?php echo ($user["avatar"]); ?>" height="80" width="80" />
							</a>
						</div>
						<div class="pull-left room-info">
							<div class="title">
								<h4><?php echo ($live["title"]); ?></h4>
							</div>
							<div class="anchors">
								主 播:<a href="<?php echo U('/u/'.$live['id']);?>"><?php echo ($user["username"]); ?></a>
							</div>
							<div class="navs">

								<a id="nav-home" class="nav" href="<?php echo U('/live/'.$live['id']);?>"
									hidefocus="true">直播</a> <a id="nav-video" class="nav"
									href="<?php echo U('/u/'.$live['uid']);?>" hidefocus="true">视频</a> <a
									id="nav-album" class="nav" href="<?php echo U('/u/'.$live['uid']);?>"
									hidefocus="true">专辑</a>
							</div>
						</div>
						<div class="pull-right">

							<div class="follow">
								<a href="javascript:;" class="btn-user-subscription"
									id="mod_follow_btn" data-value="1">+ 订阅</a>

							</div>
							<div class="fight">

								<a href="javascript:;" class="btn-user-fight"
									id="mod_follow_btn" data-value="1">挑战他</a>
							</div>
						</div>

					</div>
					<div class="live-info">

						<div id="live_player">
							<div class="swf_container">
								<embed width="100%" height="100%" allownetworking="internal"
									id="WebRoom
								allowscriptaccess="
									always"
								src="http://staticlive.douyutv.com/common/share/play_tv.swf?room_id=15218"
									quality="high" bgcolor="#fffff" wmode="direct"
									allowfullscreen="true" allowFullScreenInteractive="true"
									type="application/x-shockwave-flash">
							</div>
						</div>
						<div class="live-base-info">
							<div class="mod－action">
								<div class="action-item action-collect">
									<a> <span
										class="glyphicon glyphicon-star  action-item-icon"></span><span
										class="action-item-text"> 关注</span>
									</a>
								</div>
								<div class="action-item action-share">
									<a> <span
										class="glyphicon glyphicon-share action-item-icon"></span><span
										class="action-item-text"> 分享</span>
									</a>
								</div>
								<div class="action-item action-phone">
									<a> <span
										class="glyphicon glyphicon-phone action-item-icon"></span><span
										class="action-item-text">手机观看</span>
									</a>
								</div>
							</div>

							<div class="live-match-game-tag">
								<span>现场:<?php echo ($live["online_membes"]); ?>人</span> <span>游戏：<a
									href="/game/10005.html">英雄联盟</a></span>
							</div>

						</div>

					</div>
					<div class="live-description">

						<div class=" column-content">
							<div class="column-content-title">
								<i class="title-tip-box"></i> <span class="title-tip">公告</span>
							</div>

						</div>
						<div class="bulletin"><?php echo ($live["description"]); ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="playRight" id="playRight">
			<a id="right_close" class="right_close "> <span></span>
			</a>

			<div class="chat" id="chatArea">

				<div id="chatContent">
				
				
				
				
				</div>
				<div id="chatButtonArea" class="chatButtonArea">
					<textarea class="chat_input_area" id="chart_content"
						name="chat_content" maxlength="20" placeholder="这里输入聊天内容"
						tabindex="1"></textarea>
						<div class="sendmgarea pull-right">

							<a class="sendmsg" tabindex="2" id="sendmsg">发送</a>
						</div>
				</div>
			</div>

		</div>

	</div>
	<script type="text/javascript" src="/Public/Live/js/view.js"></script>
	 <script
		src="/Public/Core/js/lazyload.js"></script> 
	<!-- /主体 -->

	<!-- 底部 -->
	<!-- /底部 -->
</body>
</html>