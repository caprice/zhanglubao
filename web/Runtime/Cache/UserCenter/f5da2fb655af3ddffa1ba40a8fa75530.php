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

<link href="/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet" />
<link type="text/css" rel="stylesheet"
	href="/Public/static/qtip/jquery.qtip.css" />
<link type="text/css" rel="stylesheet"
	href="/Public/Core/js/ext/toastr/toastr.min.css" />
<link href="/Public/Core/css/core.css" rel="stylesheet" />

    <link href="/Public/UserCenter/css/usercenter.css" rel="stylesheet" type="text/css"/>


<!-- 增强IE兼容性 -->
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]><!-->
<script src="/Public/static/bootstrap/js/html5shiv.js"></script>
<script src="/Public/static/bootstrap/js/respond.js"></script>
<!--<!--[endif]-->



<!--[if lt IE 9]> 
<script type="text/javascript" src="/Public/static/jquery-1.11.1.min.js"></script>
 <![endif]-->

<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.1.1.min.js"></script>
<!--<![endif]-->



<!-- Bootstrap库 -->
<script type="text/javascript"
	src="/Public/static/bootstrap/js/bootstrap.min.js"></script>

<!-- 其他库 -->
<script src="/Public/static/qtip/jquery.qtip.js"></script>
<script type="text/javascript"
	src="/Public/Core/js/ext/toastr/toastr.min.js"></script>
<script type="text/javascript"
	src="/Public/Core/js/ext/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript"
	src="/Public/static/jquery.iframe-transport.js"></script>

<script type="text/javascript" src="/Public/Core/js/core.js"></script>

<script type="text/javascript">

    (function () {

        var ThinkPHP = window.Think = {
            "ROOT": "", //当前网站地址
            "APP": "/index.php?s=", //当前项目地址
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

</head>
<body>
	<!-- 头部 -->
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
	<!-- /头部 -->
	
	<!-- 主体 -->
	
<div id="main-container" class="container">
   
    <div class="col-md-12 usercenter">
        <div class="uc">
                <div class="uc_top_bg">
        <img class="img-responsive" src="/Public/UserCenter/images/fractional.png" style="display: none">
    </div>
    <div class="row uc_info">
        <div class="col-md-3 col-xs-4">
            <dl>
                <dt>
                    <a href="<?php echo ($user_info["space_url"]); ?>" title="">
                        <img src="<?php echo ($user_info["avatar128"]); ?>" class="avatar-img img-responsive top_img"/>
                    </a>
                </dt>
                <dd>
                    <div>
                        <div class="col-xs-4 text-center">
                            <a href="<?php echo U('Weibo/Index/index',array('uid'=>$user_info['uid']));?>"
                               title="微博数"><?php echo ($user_info["weibocount"]); ?></a><br>微博
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="<?php echo U('Usercenter/Index/fans',array('uid'=>$user_info['uid']));?>" title="粉丝数"><?php echo ($user_info["fans"]); ?></a><br>粉丝
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="<?php echo U('Usercenter/Index/following',array('uid'=>$user_info['uid']));?>" title="关注数"><?php echo ($user_info["following"]); ?></a><br>关注
                        </div>
                    </div>
                </dd>
            </dl>
        </div>
        <div class="col-md-6 col-xs-8">
            <div class="uc_main_info">
                <div class="uc_m_t_12 uc_m_b_12 uc_uname">
                <span>
                    <a ucard="<?php echo ($user_info["uid"]); ?>" href="<?php echo ($user_info["space_url"]); ?>" title=""><?php echo (htmlspecialchars($user_info["nickname"])); ?></a>
                </span>
                    <span>
                <?php if($user_info['rank_link'][0]['num']): if(is_array($user_info['rank_link'])): $i = 0; $__LIST__ = $user_info['rank_link'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><img src="<?php echo ($vl["logo_url"]); ?>" title="<?php echo ($vl["title"]); ?>" alt="<?php echo ($vl["title"]); ?>"
                                 style="width: 18px;height: 18px;vertical-align: middle;margin-left: 2px;"/><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </span>
                </div>
                <div class="uc_m_b_12 text-more" style="width: 100%">个性签名：<span>
                <?php if($user_info['signature'] == ''): ?>还没想好O(∩_∩)O
                    <?php else: ?>
                    <attr title="<?php echo ($user_info["signature"]); ?>"><?php echo ($user_info["signature"]); ?></attr><?php endif; ?>
            </span></div>
                <div class="uc_m_b_12">
                <span class="uc_m_r_36">积分：<?php echo ($user_info["score"]); ?>&nbsp;&nbsp;
                </span>
                </div>
                <div class="uc_m_b_12"><span>等级：<?php echo ($user_info["title"]); ?></span></div>
            </div>
        </div>
        <?php if(is_login() && $user_info['uid'] != get_uid()): ?><div class="col-md-3 col-xs-12">
                <div class="uc_follow">
                    <?php $user_info['is_following'] = D('Follow')->where(array('who_follow'=>get_uid(),'follow_who'=>$user_info['uid']))->find(); ?>
                    <?php echo W('Common/Ufollow/render',array('is_following'=>$user_info['is_following'],'uid'=>$user_info['uid']));?>
                </div>
            </div><?php endif; ?>
    </div>
            <?php if(ACTION_NAME=='information'){ $tabClass['user_data'] = 'uc_current'; } elseif(ACTION_NAME=='fans'||ACTION_NAME=='following'){ $tabClass['user_fans'] = 'uc_current'; } else{ $tabClass[$type] = 'uc_current'; } ?>
<nav class="navbar navbar-default uc_navbar" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <?php if(is_array($appArr)): $i = 0; $__LIST__ = $appArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('appList',array('type'=>$key,'uid'=>$uid));?>"  class="<?php echo ($tabClass[$key]); ?>"><?php echo ($vo); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            <li>
                <a href="<?php echo U('information',array('uid'=>$uid));?>" class="<?php echo ($tabClass["user_data"]); ?>">资料</a>
            </li>
            <li>
                <a href="<?php echo U('following',array('uid'=>$uid));?>" class="<?php echo ($tabClass["user_fans"]); ?>">关注/粉丝</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>

            <div class="row uc_content">
                <div class="col-md-7 col-xs-12">
                    <?php echo ($content); ?>
                    <div class="pull-right">
                        <?php echo getPagination($totalCount,10);?>
                    </div>
                </div>
                <div class="col-md-5 col-sm-9 col-xs-12 uc_other_link">
                    <div>
    <div class="uc_link_block clearfix col-xs-12">
        <div class="uc_link_top clearfix">
            <div class="uc_title">
                <?php if($uid == is_login()): ?>我<?php else: ?>TA<?php endif; ?>的关注(<?php echo ((isset($follow_totalCount) && ($follow_totalCount !== ""))?($follow_totalCount):0); ?>)
            </div>
            <div class="uc_fl_right uc_more_link"><a href="<?php echo U('following',array('uid'=>$uid));?>">更多</a></div>
        </div>
        <div class="col-md-12 uc_link_info">
            <?php if(is_array($follow_default)): $i = 0; $__LIST__ = $follow_default;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fl): $mod = ($i % 2 );++$i;?><div class="col-sm-3 col-xs-4">
                    <dl>
                        <a href="<?php echo ($fl["user"]["space_url"]); ?>">
                            <dt><img ucard="<?php echo ($fl["user"]["uid"]); ?>" src="<?php echo ($fl["user"]["avatar64"]); ?>" class="avatar-img img-responsive">
                            </dt>
                            <dd ucard="<?php echo ($fl["user"]["uid"]); ?>" class="text-more" style="width: 100%"><?php echo ($fl["user"]["nickname"]); ?></dd>
                        </a>
                    </dl>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(count($follow_default) == 0): ?><p style="text-align: center; font-size: 24px;">
                <br><br>
                暂无关注任何人哦～
                <br><br><br>
            </p><?php endif; ?>
        </div>

    </div>
    <div class="uc_link_block clearfix col-xs-12" style="margin-top: 10px;">
        <div class="uc_link_top clearfix">
            <div class="uc_title">
                <?php if($uid == is_login()): ?>我<?php else: ?>TA<?php endif; ?>的粉丝(<?php echo ((isset($fans_totalCount) && ($fans_totalCount !== ""))?($fans_totalCount):0); ?>)
            </div>
            <div class="uc_fl_right uc_more_link"><a href="<?php echo U('fans',array('uid'=>$uid));?>">更多</a></div>
        </div>
        <div class="col-md-12 uc_link_info">
            <?php if(is_array($fans_default)): $i = 0; $__LIST__ = $fans_default;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fs): $mod = ($i % 2 );++$i;?><div class="col-sm-3 col-xs-4">
                    <dl>
                        <a href="<?php echo ($fs["user"]["space_url"]); ?>">
                            <dt><img ucard="<?php echo ($fs["user"]["uid"]); ?>" src="<?php echo ($fs["user"]["avatar64"]); ?>" class="avatar-img img-responsive">
                            </dt>
                            <dd ucard="<?php echo ($fs["user"]["uid"]); ?>" class="text-more" style="width: 100%"><?php echo ($fs["user"]["nickname"]); ?></dd>
                        </a>
                    </dl>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(count($fans_default) == 0): ?><p style="text-align: center; font-size: 24px;">
                <br><br>
                暂无粉丝哦～
                <br><br><br>
            </p><?php endif; ?>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
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