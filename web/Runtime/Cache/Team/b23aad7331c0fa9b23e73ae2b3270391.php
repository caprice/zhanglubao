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

<link href="/Public/Team/css/forum.css" rel="stylesheet" />
<script type="text/javascript"
	src="/Public/Core/js/ext/magnific/jquery.magnific-popup.min.js"></script>
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
			<!-- 左边 -->
			<div class="col-xs-9">
				<div class="row">

					<div class="col-xs-12">
						<div class="team-info">
							<div class="team-icon">
								<a href="<?php echo U('/team/'.$team['id']);?>"> <img
									src="/Public/Core/images/placeholder.png"
									lazy-src="<?php echo (get_cover($team["cover"],url)); ?>" height="80" width="80" />
								</a>
							</div>
							<div class="pull-left team-info">
								<div class="title">
									<h4><?php echo ($team["name"]); ?></h4>
								</div>

								<div class="team-navs">
									<a id="nav-home" class="team-nav" href="<?php echo U('/team/'.$teamid);?>">首页</a>
									<a id="nav-video" class="team-nav"
										href="<?php echo U('/team/video/'.$teamid);?>">视频</a> <a id="nav-album"
										class="team-nav team-nav-current"
										href="<?php echo U('/team/forum/'.$teamid);?>">论坛</a> <a id="nav-album"
										class="team-nav" href="<?php echo U('/team/album/'.$teamid);?>">专辑</a> <a
										id="nav-album" class="team-nav"
										href="<?php echo U('/team/match/'.$teamid);?>">比赛</a>
								</div>
							</div>
							<div class="pull-right">

								<div class="follow">
									<a href="javascript:;" class="btn-team-subscription"
										id="mod_follow_btn" data-value="1">+ 订阅</a>

								</div>

								<div class="join">

									<a href="javascript:;" class="btn-team-join"
										id="mod_follow_btn" data-value="1">加入</a>
								</div>
							</div>

						</div>


						<script type="text/javascript" src="/Public/Team/js/common.js"></script>
						<div class=" post_content">
							<div class="col-xs-12 forum_block_border "
								style="background: white">
								<div style="margin-top: 15px"></div>
								<?php $user = query_user(array('avatar','uid','username'), $post['uid']); ?>
								<?php if($showMainPost): ?><div style="position: relative">
									<div class="forum_left_operation">
										<div class="text-right btn-toolbar btn-group-vertical"
											role="toolbar">
											<div class="btn-group">
												<?php if($post['uid']==is_login()): ?><a
													class="btn" title="编辑"
													href="<?php echo U('Team/Forum/edit',array('post_id'=>$post['id']));?>">
													<i class="forum_edit"></i>
												</a><?php endif; ?>
												<a class="btn" title="回复" href="#reply_form"> <i
													class="forum_reply"></i></a>


												<?php $hideStyle = 'display: none;'; $bookmarkStyle = $isBookmark ? $hideStyle : ''; $unbookmarkStyle = $isBookmark ? '' : $hideStyle; ?>
												<a title="取消收藏" id="unbookmark_button" class="btn "
													style="display: none"
													href="<?php echo U('Forum/doBookmark?add=0',array('post_id'=>$post['id']));?>">
													<i class="forum_uncollect"></i>
												</a> <a title="收藏本帖" id="bookmark_button" class="btn " style=""
													href="<?php echo U('Forum/doBookmark',array('post_id'=>$post['id']));?>"><i
													class="forum_collect"></i></a>

											</div>
										</div>
									</div>
									<div class="col-xs-2">
										<p>
											<a href="<?php echo U('/u/'.$user['uid']);?>" ucard="<?php echo ($user["uid"]); ?>"> <img
												src="/Public/Core/images/placeholder.png" width="118px" height="118px"
												lazy-src="<?php echo ($user["avatar"]); ?>" class="avatar-img" />
											</a>
										</p>

										<p class="text-center">
											<a href="<?php echo U('/u/'.$user.uid);?>" ucard="<?php echo ($user["uid"]); ?>"><?php echo (htmlspecialchars($user["username"])); ?></a>
										</p>

										<p class="text-center">
											<?php if(is_array($user["rank_link"])): $i = 0; $__LIST__ = $user["rank_link"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['is_show']): ?><img src="<?php echo ($vo["logo_url"]); ?>"
												title="<?php echo ($vo["title"]); ?>" alt="<?php echo ($vo["title"]); ?>" class="rank_html" /><?php endif; endforeach; endif; else: echo "" ;endif; ?>
										</p>
									</div>
									<div class="col-xs-10 ">
										<div class="row">
											<div style="position: relative">
												<a class="ribbion-green">楼主</a>

												<div style="padding: 10px"></div>
												<div class="col-md-12 post_title">
													<h2><?php echo (op_t($post["title"])); ?></h2>

													<div class="small sub_title">
														<br /> <a href="<?php echo U('/u/'.$user.uid);?>"
															ucard="<?php echo ($user["uid"]); ?>" class="text-primary"><?php echo ($user["username"]); ?></a>
														<?php echo (time_format($post["create_time"])); ?>
													</div>
												</div>

											</div>
										</div>
										<div style="padding: 10px"></div>
										<div class="col-md-12 main_content">
											<?php echo (parse_at_users(parse_popup($post["content"]))); ?></div>
										<div>

											<br />
											<?php if($post['create_time'] != $post['update_time']): ?><p class="text-muted">[最后编辑于
												<?php echo (time_format($post['update_time'])); ?> ]</p><?php endif; ?>
										</div>
										<div>
											<div class="bdsharebuttonbox">
												<a href="#" class="bds_more" data-cmd="more"></a><a href="#"
													class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a
													href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a
													href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a
													href="#" class="bds_renren" data-cmd="renren"
													title="分享到人人网"></a><a href="#" class="bds_weixin"
													data-cmd="weixin" title="分享到微信"></a><a href="#"
													class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a
													href="#" class="bds_copy" data-cmd="copy" title="分享到复制网址"></a>
											</div>
											<script>
												window._bd_share_config = {
													"common" : {
														"bdSnsKey" : {},
														"bdText" : "",
														"bdMini" : "2",
														"bdMiniList" : false,
														"bdPic" : "",
														"bdStyle" : "1",
														"bdSize" : "16"
													},
													"share" : {}
												};
												with (document)
													0[(getElementsByTagName('head')[0] || body)
															.appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='
															+ ~(-new Date() / 36e5)];
											</script>

										</div>

									</div>
								</div>

								<hr class="post_line" /><?php endif; ?>

								<?php if(is_array($replyList)): $k = 0; $__LIST__ = $replyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$reply): $mod = ($k % 2 );++$k;?><div class="row" style="position: relative">
									<a id="<?php echo ($reply["id"]); ?>"
										style="margin-top: -100px; position: absolute;"></a>
									<?php if(($reply["uid"]) == $post['uid']): ?><a
										class="ribbion-green">楼主</a><?php endif; ?>

									<div class="col-xs-2">
										<p class="text-center">
											<a ucard="<?php echo ($reply["uid"]); ?>" href="<?php echo U('/u/'.$reply.user.uid);?>"><img
												src="/Public/Core/images/placeholder.png" width="118px" height="118px"
												lazy-src="<?php echo ($reply["user"]["avatar"]); ?>"  
												class="avatar-img" /></a>
										</p>

										<p class="text-center">
											<a ucard="<?php echo ($reply["uid"]); ?>" href="<?php echo ($reply["user"]["space_url"]); ?>"><?php echo ($reply["user"]["username"]); ?></a>
										</p>

										<p class="text-center">
											<?php if(is_array($reply["user"]["rank_link"])): $i = 0; $__LIST__ = $reply["user"]["rank_link"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['is_show']): ?><img src="<?php echo ($vo["logo_url"]); ?>"
												title="<?php echo ($vo["title"]); ?>" alt="<?php echo ($vo["title"]); ?>" class="rank_html" /><?php endif; endforeach; endif; else: echo "" ;endif; ?>
										</p>
									</div>
									<div class="col-xs-10">
										<div
											style="min-height: 10em; overflow: hidden; word-break: break-all"
											class="post_content">
											<div style="padding: 15px"></div>
											<?php echo (parse_at_users(parse_popup($reply["content"]))); ?> <br />
										</div>
										<p class="pull-right text-muted">
											<?php echo getLou( $limit*($page-1)+$k+1);?> 发表于
											<?php echo (time_format($reply["create_time"])); ?>
											<?php if(CheckPermission(array($reply['uid']))): ?><a
												href="javascript:" class="del_reply_btn"
												args="reply_id=<?php echo ($reply['id']); ?>">删除</a><?php endif; ?>
											<?php if($reply['uid']==is_login()){ ?>
											<a
												href="<?php echo U('/Team/Forum/editReply',array('reply_id'=>$reply['id']));?>">编辑</a>
											<?php } ?>

											<a href="javascript:" class="reply_btn" args="<?php echo ($reply['id']); ?>"
												id="reply_btn_<?php echo ($reply['id']); ?>">回复(<?php echo ($reply["lzl_count"]); ?>)</a>

										</p>

										<div class="clearfix"></div>
										<div id="lzl_reply_div_<?php echo ($reply['id']); ?>"
											<?php if($reply['lzl_count'] == 0): ?>style="display:none"<?php endif; ?>
											>
											<?php echo W('ForumLZLReply/LZLReply',array('to_f_reply_id'=>$reply['id'],'post_id'=>$post['id'],'reply_uid'=>$reply['uid'],'count'=>$reply['lzl_count']));?>
										</div>

									</div>
								</div>
								<hr class="post_line" /><?php endforeach; endif; else: echo "" ;endif; ?>

								<div class="row">
									<div class="col-xs-12">
										<pull class="pull-right">
										<?php echo getPagination($replyTotalCount);?> </pull>
									</div>
								</div>

								<br />

								<!--发表回复-->
								<?php if(is_login()): $user = query_user(array('avatar','uid')); ?>
								<div class="row">
									<div class="col-xs-2">
										<p>
											<a href="<?php echo U('/u/'.$user['uid']);?>" ucard="<?php echo ($user["uid"]); ?>">  <img
												src="/Public/Core/images/placeholder.png" width="118px" height="118px"
												lazy-src="<?php echo ($user["avatar"]); ?>"  
												class="avatar-img" />
												
												</a>
										</p>
									</div>
									<div class="col-xs-10">
										<div id="reply_block">
											<form id="reply_form"
												action="<?php echo U('doReply',array('post_id'=>$post['id']));?>"
												method="post" class="ajax-form">
												<p><h4>发表回复</h4></p>
												<p>
													<?php echo W('ForumUeditorMini/editor',array('contentEditor','content','','100%','250px'));?>
												</p>

												<p class="pull-right">
													<input type="submit" id="reply_button"
														class="btn btn-primary" value="发表 Ctrl+Enter" />
												</p>
											</form>
										</div>
									</div>
								</div>
								<?php else: ?>
								<p class="text-center text-muted"
									style="font-size: 3em; padding-top: 2em; padding-bottom: 2em;">
									请<a href="<?php echo U('/user/login');?>">登录</a>后发帖
								</p><?php endif; ?>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div>


					<div class="right-want-box">
						<div class="row">
							<div class="col-xs-2">
								<span class=" glyphicon glyphicon-flash want-box-icon "></span>
							</div>
							<div class="col-lg-4">
								<a href="#" class="want-box-text" rel="nofollow">我要约战</a>
							</div>
							<div class="col-xs-1">
								<span
									class="glyphicon glyphicon-facetime-video  want-box-share-icon "></span>
							</div>
							<div class="col-xs-4">
								<a href="#" class="want-box-text" rel="nofollow">我要直播</a>
							</div>
						</div>
					</div>
					<?php echo W('TeamSide/hot',array($teamid));?>




				</div>
			</div>


		</div>
	</div>


	<script>
		var SUPPORT_URL = "<?php echo addons_url('Support://Support/doSupport');?>";
		//点击收藏/取消收藏按钮
		$(function() {

			$('#reply_form').keypress(function(e) {
				if (e.ctrlKey && e.which == 13 || e.which == 10) {
					$('#reply_button').focus();
					$("#reply_form").submit();
				}
			});

			//var $inputor = $('#contentEditor').atwho(atwho_config);

			bindSupport();
			$('#bookmark_button, #unbookmark_button').click(function(e) {

				//取消默认操作
				e.preventDefault();

				//发送AJAX请求
				var button = $(this);
				var href = button.attr('href');
				var originalClass = $(this).attr('class');
				button.attr('class', 'btn');
				$.post(href, {}, function(a) {
					button.attr('class', originalClass);
					if (a.status) {
						switchButtonVisibility();
					}
				});

				return false;
			});

			function switchButtonVisibility() {
				switchVisibility('#bookmark_button');
				switchVisibility('#unbookmark_button');
			}

			function switchVisibility(css) {
				var element = $(css);
				if (element.is(':visible')) {
					element.hide();
				} else {
					element.show();
				}
			}

			if ("<?php echo ($sr); ?>" != "") {
				$('#lzl_reply_list_<?php echo ($sr); ?>').load(
						U('Team/LZL/lzllist', [ 'to_f_reply_id', '<?php echo ($sr); ?>',
								'page', '<?php echo ($sp); ?>' ], true), function() {
							ucard();
						});
			}
		})

		$(document)
				.ready(
						function() {

							$('.popup-gallery')
									.each(
											function() { // the containers for all your galleries
												$(this)
														.magnificPopup(
																{
																	delegate : '.popup',
																	type : 'image',
																	tLoading : 'Loading image #%curr%...',
																	mainClass : 'mfp-img-mobile',
																	gallery : {
																		enabled : true,
																		navigateByImgClick : true,
																		preload : [
																				0,
																				1 ]
																	// Will preload 0 - before current, and 1 after the current image
																	},
																	image : {
																		tError : '<a href="%url%">The image #%curr%</a> could not be loaded.',
																		titleSrc : function(
																				item) {
																			/*           return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';*/
																			return '';
																		}
																	}
																});
											});
						});
	</script>
	<style>
.forum-first-block {
	background: white;
	box-shadow: 0 0 5px rgb(204, 204, 204);
	-moz-box-shadow: 0 0 5px #CCCCCC;
	-khtml-box-shadow: 0 0 5px #CCCCCC;
	margin-top: 15px;
}
</style>

	<script type="text/javascript">
		$(function() {
			$(window).resize(
					function() {
						$("#main-container").css("min-height",
								$(window).height() - 280);
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