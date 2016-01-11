<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>群挑网-系统管理</title>


<link href="/Public/Static/css/bootstrap/bootstrap.min.css?v=1.0"
	rel="stylesheet" />


<link href="/Public/Static/css/libs/font-awesome.css?v=1.0" type="text/css"
	rel="stylesheet" />
<link rel="stylesheet" href="/Public/Static/css/libs/nanoscroller.css?v=1.0"
	type="text/css" />

<link rel="stylesheet" type="text/css"
	href="/Public/Static/css/compiled/layout.css?v=1.0">
<link rel="stylesheet" type="text/css"
	href="/Public/Static/css/compiled/elements.css?v=1.0">

<link rel="stylesheet" href="/Public/Static/css/libs/fullcalendar.css?v=1.0"
	type="text/css" />
<link rel="stylesheet"
	href="/Public/Static/css/libs/fullcalendar.print.css?v=1.0" type="text/css"
	media="print" />
<link rel="stylesheet" href="/Public/Static/css/compiled/calendar.css?v=1.0"
	type="text/css" media="screen" />
<link rel="stylesheet" href="/Public/Static/css/libs/morris.css?v=1.0"
	type="text/css" />
<link rel="stylesheet"
	href="/Public/Static/css/libs/daterangepicker.css?v=1.0" type="text/css" />
<link rel="stylesheet"
	href="/Public/Static/css/libs/jquery-jvectormap-1.2.2.css?v=1.0"
	type="text/css" />
<link type="text/css" rel="stylesheet"
	href="/Public/Static/js/toastr/toastr.min.css" />

<link type="image/x-icon" href="favicon.png" rel="shortcut icon" />


<!--[if lt IE 9]>
		<script src="/Public/Static/js/html5shiv.js?v=1.0"></script>
		<script src="/Public/Static/js/respond.min.js?v=1.0"></script>
	<![endif]-->

<link rel="stylesheet" type="text/css"
	href="/Public/Static/css/compiled/wizard.css">

<link rel="stylesheet" type="text/css"
	href="/Public/Static/css/libs/dropzone.css">

<link rel="stylesheet" type="text/css"
	href="/Public/Static/lib/selectize/css/selectize.default.css">


</head>
<body>



	<header class="navbar" id="header-navbar">
		<div class="container">
			<a href="<?php echo U('Home/Index/index');?>" id="logo" class="navbar-brand">
				<img src="/Public/Static/img/logo.png" alt=""
				class="normal-logo logo-white" /> <img
				src="/Public/Static/img/logo-black.png" alt=""
				class="normal-logo logo-black" /> <img
				src="/Public/Static/img/logo-small.png" alt=""
				class="small-logo hidden-xs hidden-sm hidden" />
			</a>
			<div class="clearfix">
				<button class="navbar-toggle" data-target=".navbar-ex1-collapse"
					data-toggle="collapse" type="button">
					<span class="sr-only">Toggle navigation</span> <span
						class="fa fa-bars"></span>
				</button>
				<div
					class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
					<ul class="nav navbar-nav pull-left">
						<li><a class="btn" id="make-small-nav"> <i
								class="fa fa-bars"></i>
						</a></li>
					</ul>
				</div>
				<div class="nav-no-collapse pull-right" id="header-nav">
					<ul class="nav navbar-nav pull-right">

						<li class="dropdown hidden-xs"><a class="btn dropdown-toggle"
							data-toggle="dropdown"> <i class="fa fa-warning"></i>
						</a>
							<ul class="dropdown-menu notifications-list">

							</ul></li>
						<li class="dropdown hidden-xs"><a class="btn dropdown-toggle"
							data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
						</a>
							<ul class="dropdown-menu notifications-list messages-list">

							</ul></li>
						<li class="hidden-xs"><a class="btn"> <i
								class="fa fa-cog"></i>
						</a></li>
						<li class="dropdown profile-dropdown"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown"> <img
								src="<?php echo get_own_avatar();?>" /> <span class="hidden-xs"><?php echo session('admin_user_auth.username');?></span>
								<b class="caret"></b>
						</a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo U('System/Admin/edit/id/'.UID);?>"><i
										class="fa fa-user"></i>个人资料</a></li>
								<li><a href="#"><i class="fa fa-cog"></i>系统设置</a></li>
								<li><a href="#"><i class="fa fa-envelope-o"></i>信息提示</a></a></li>
								<li><a href="<?php echo U('Member/Logout/logout');?>"><i
										class="fa fa-power-off"></i>注销</a></li>
							</ul></li>
						<li class="hidden-xxs"><a class="btn"
							href="<?php echo U('Member/Logout/logout');?>"> <i
								class="fa fa-power-off"></i>
						</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<div id="page-wrapper" class="container">
		<div class="row">
			<div id="nav-col">
				<section id="col-left" class="col-left-nano">
					<div id="col-left-inner" class="col-left-nano-content">
						<div id="user-left-box" class="clearfix hidden-sm hidden-xs">
							<img src="<?php echo get_own_avatar();?>" width="80px" height="80px" />
							<div class="user-box">
								<span class="name">
									<?php echo session('admin_user_auth.username');?> </span><br /> <span
									class="status"> <i class="fa fa-circle"></i> 在线
								</span>
							</div>
						</div>
						<div class="collapse navbar-collapse navbar-ex1-collapse"
							id="sidebar-nav">
							<ul class="nav nav-pills nav-stacked">
								<li id="MenuHome"><a href="<?php echo U('Home/Index/index');?>"> <i
										class="fa fa-dashboard"></i> <span>系统中心</span>
								</a></li>


								<li id="MenuSystem"><a href="#" class="dropdown-toggle">
										<i class="fa fa-gear"></i> <span>系统设置</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubAdmin"><a
											href="<?php echo U('System/Admin/index');?>"> 管理员 </a></li>
										<li id="MenuSubConfig"><a
											href="<?php echo U('System/Config/index');?>"> 系统设置 </a></li>
										<li id="MenuSubSeo"><a href="<?php echo U('System/Seo/index');?>">
												SEO管理 </a></li>

										<li id="MenuSubAdminMenu"><a href="#"> 后台菜单 </a></li>
										<li id="MenuSubAuthManager"><a href="#"> 系统授权 </a></li>
										<li id="MenuSubCountry"><a
											href="<?php echo U('System/Country/index');?>"> 国家管理 </a></li>
										<li id="MenuSubGame"><a href="#"> 游戏管理 </a></li>
									</ul></li>



								<li id="MenuLol"><a class="dropdown-toggle"> <i
										class="fa  fa-drupal"></i> <span>英雄联盟</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubHero"><a href="<?php echo U('LOL/LolHero/index');?>">
												英雄列表 </a></li>

									</ul></li>



								<li id="MenuUser"><a class="dropdown-toggle"> <i
										class="fa fa-users"></i> <span>用户信息</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubUser"><a href="<?php echo U('User/User/index');?>">
												用户列表 </a></li>
										<li id="MenuSubUserGroup"><a
											href="<?php echo U('User/UserGroup/index');?>"> 用户分组 </a></li>
										<li id="MenuSubUserVerify"><a
											href="<?php echo U('User/UserVerify/index');?>"> 认证用户 </a></li>
										<li id="MenuSubUserTeam"><a
											href="<?php echo U('User/UserTeam/index');?>"> 战队列表 </a></li>
									</ul></li>


								<li id="MenuRecommend"><a href="#" class="dropdown-toggle">
										<i class="fa  fa-thumbs-up"></i> <span>推荐管理</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">

										<li id="MenuSubRecommendContent"><a
											href="<?php echo U('Recommend/RecommendContent/index');?>"> 推荐列表 </a></li>
										<li id="MenuSubRecommendPlace"><a
											href="<?php echo U('Recommend/RecommendPlace/index');?>">推荐位置 </a></li>
									</ul></li>


								<li id="MenuVideo"><a href="#" class="dropdown-toggle">
										<i class="fa  fa-video-camera"></i> <span>视频管理</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">

										<li id="MenuSubVideo"><a href="<?php echo U('Video/Video/index');?>">
												视频列表 </a></li>
										<li id="MenuSubVideoCategory"><a
											href="<?php echo U('Video/VideoCategory/index');?>"> 视频分类 </a></li>
										<li id="MenuSubVideoAlbum"><a
											href="<?php echo U('Video/VideoAlbum/index');?>"> 视频专辑 </a></li>
									</ul></li>

								<li id="MenuLive"><a href="#" class="dropdown-toggle">
										<i class="fa  fa-desktop"></i> <span>直播管理</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubLive"><a href="#"> 直播列表 </a></li>
									</ul></li>


								<li id="MenuWeb"><a href="#" class="dropdown-toggle"> <i
										class="fa  fa-question-circle"></i> <span>问答系统</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubFriendLink"><a
											href="<?php echo U('Question/Question/index');?>"> 问题管理 </a></li>


									</ul></li>

								<li id="MenuArticle"><a href="#" class="dropdown-toggle">
										<i class="fa   fa-file-text-o"></i> <span>文章系统</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubDcArticle"><a
											href="<?php echo U('Article/DcArticle/index');?>"> 文章管理 </a></li>
										<li id="MenuSubDcCategory"><a
											href="<?php echo U('Article/DcCategory/index');?>"> 文章分类 </a></li>
									</ul></li>




								<li id="MenuArticle"><a href="#" class="dropdown-toggle">
										<i class="fa   fa-file-text-o"></i> <span>文章系统</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubDcArticle"><a
											href="<?php echo U('Article/DcArticle/index');?>"> 文章管理 </a></li>
										<li id="MenuSubDcCategory"><a
											href="<?php echo U('Article/DcCategory/index');?>"> 文章分类 </a></li>
									</ul></li>




								<li id="MenuLOL"><a href="#" class="dropdown-toggle"> <i
										class="fa  fa-crosshairs"></i> <span>比赛系统</span> <i
										class="fa   fa-chevron-circle-right  drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubHero"><a href="<?php echo U('LOL/Series/index');?>">
												英雄 </a></li>
										<li id="MenuSubSeries"><a href="<?php echo U('LOL/Series/index');?>">
												比赛 </a></li>

									</ul></li>


								<li id="MenuWeb"><a href="#" class="dropdown-toggle"> <i
										class="fa  fa-ge"></i> <span>网页系统</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubFriendLink"><a
											href="<?php echo U('Web/FriendLink/index');?>"> 友情链接 </a></li>
									</ul></li>

								<li id="MenuApp"><a href="#" class="dropdown-toggle"> <i
										class="fa  fa-mobile-phone"></i> <span>应用系统</span> <i
										class="fa fa-chevron-circle-right drop-icon"></i>
								</a>
									<ul class="submenu">
										<li id="MenuSubAppSlide"><a
											href="<?php echo U('App/Slide/index');?>"> 滑动广告 </a></li>
									</ul></li>

							</ul>
						</div>
					</div>
				</section>
			</div>
			<div id="content-wrapper">
				<div class="row">
					<div class="col-lg-12">

						
<div class="row">
	<div class="col-lg-12">
		<div class="main-box clearfix" style="min-height: 1180px;">
			<header class="main-box-header clearfix">
				<h2>添加英雄</h2>
			</header>
			<div class="main-box-body clearfix">
				<form class="form-horizontal" action="<?php echo U();?>" method="post">

					<input type="hidden" name="id" value="<?php echo ($hero["id"]); ?>">
					<div class="form-group">
						<label for="inputTitle" class="col-lg-1 control-label">英雄大名</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle"
								value="<?php echo ($hero["name"]); ?>" name="name" placeholder="英雄大名">
						</div>
					</div>

					<div class="form-group">
						<label for="inputTitle" class="col-lg-1 control-label">英文名字</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle"
								value="<?php echo ($hero["en_name"]); ?>" name="en_name" placeholder="英文名字">
						</div>
					</div>

					<div class="form-group">
						<label for="inputTitle" class="col-lg-1 control-label">英雄昵称</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle"
								value="<?php echo ($hero["nick"]); ?>" name="nick" placeholder="英雄昵称">
						</div>
					</div>

					<div class="form-group">
						<label for="inputTitle" class="col-lg-1 control-label">TAG1</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle"
								value="<?php echo ($hero["tag1"]); ?>" name="tag1" placeholder="tag1">
						</div>
					</div>


					<div class="form-group">
						<label for="inputTitle" class="col-lg-1 control-label">TAG2</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle"
								value="<?php echo ($hero["tag2"]); ?>" name="tag1" placeholder="tag3">
						</div>
					</div>


					<div class="form-group">
						<label for="inputTitle" class="col-lg-1 control-label">TAG3</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle"
								value="<?php echo ($hero["tag3"]); ?>" name="tag3" placeholder="tag3">
						</div>
					</div>


					<div class="form-group">
						<label for="inputTitle" class="col-lg-1 control-label">TAG4</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle"
								value="<?php echo ($hero["tag4"]); ?>" name="tag4" placeholder="tag4">
						</div>
					</div>




					<div class="form-group">
						<label for="articleIntro" class="col-lg-1 control-label">头像</label>
						<div class="col-lg-11">
							<input type="file" id="upload_file_image"> <input
								type="hidden" name="avatar" value="{hero.avatar}" />


							<div class="upload-img-box">
								<?php if(!empty($hero['avatar'])): ?><div class="upload-pre-item">
									<img src="<?php echo ($hero['avatar']); ?>" />
								</div><?php endif; ?>
							</div>
						</div>
					</div>



					<div class="form-group">
						<label for="articleTags" class="col-lg-1 control-label"></label>
						<div class="col-lg-11">
							<input type="submit" class="btn btn-success ajax-post"
								target-form="form-horizontal" value="提交">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>






					</div>
				</div>
				<footer id="footer-bar" class="row">
					<p id="footer-copyright" class="col-xs-12">
						&copy; 2014 <a href="http://www.quntiao.com/" target="_blank">Rocks</a>.
						Powered by Quntiao.
					</p>
				</footer>
			</div>
		</div>
	</div>
	<div id="config-tool" class="closed">
		<a id="config-tool-cog"> <i class="fa fa-cog"></i>
		</a>
		<div id="config-tool-options">
			<h4>布局选项</h4>
			<ul>
				<li>
					<div class="checkbox-nice">
						<input type="checkbox" id="config-fixed-header" /> <label
							for="config-fixed-header"> 固定头部 </label>
					</div>
				</li>
				<li>
					<div class="checkbox-nice">
						<input type="checkbox" id="config-fixed-sidebar" /> <label
							for="config-fixed-sidebar"> 固定菜单 </label>
					</div>
				</li>
				<li>
					<div class="checkbox-nice">
						<input type="checkbox" id="config-fixed-footer" /> <label
							for="config-fixed-footer"> 固定底部 </label>
					</div>
				</li>
			</ul>
			<br />
			<h4>皮肤颜色</h4>
			<ul id="skin-colors" class="clearfix">
				<li><a class="skin-changer" data-skin="" data-toggle="tooltip"
					title="Default" style="background-color: #34495e;"> </a></li>
				<li><a class="skin-changer" data-skin="theme-white"
					data-toggle="tooltip" title="White/Green"
					style="background-color: #2ecc71;"> </a></li>
				<li><a class="skin-changer blue-gradient"
					data-skin="theme-blue-gradient" data-toggle="tooltip"
					title="Gradient"> </a></li>
				<li><a class="skin-changer" data-skin="theme-amethyst"
					data-toggle="tooltip" title="Amethyst"
					style="background-color: #9b59b6;"> </a></li>
				<li><a class="skin-changer" data-skin="theme-blue"
					data-toggle="tooltip" title="Blue"
					style="background-color: #2980b9;"> </a></li>
				<li><a class="skin-changer" data-skin="theme-red"
					data-toggle="tooltip" title="Red"
					style="background-color: #e74c3c;"> </a></li>
			</ul>
		</div>
	</div>

	<script src="/Public/Static/js/demo-skin-changer.js?v=1.0"></script>
	<script src="/Public/Static/js/jquery.js?v=1.0"></script>
	<script src="/Public/Static/js/bootstrap.js?v=1.0"></script>
	<script src="/Public/Static/js/jquery.nanoscroller.min.js?v=1.0"></script>
	<script src="/Public/Static/js/demo.js?v=1.0"></script>

	<script src="/Public/Static/js/jquery-ui.custom.min.js?v=1.0"></script>
	<script src="/Public/Static/js/fullcalendar.min.js?v=1.0"></script>
	<script src="/Public/Static/js/jquery.slimscroll.min.js?v=1.0"></script>
	<script src="/Public/Static/js/raphael-min.js?v=1.0"></script>
	<script src="/Public/Static/js/morris.min.js?v=1.0"></script>
	<script src="/Public/Static/js/moment.min.js?v=1.0"></script>
	<script src="/Public/Static/js/daterangepicker.js?v=1.0"></script>
	<script src="/Public/Static/js/jquery-jvectormap-1.2.2.min.js?v=1.0"></script>
	<script src="/Public/Static/js/jquery-jvectormap-world-merc-en.js?v=1.0"></script>
	<script src="/Public/Static/js/gdp-data.js?v=1.0"></script>
	<script src="/Public/Static/js/flot/jquery.flot.js?v=1.0"></script>
	<script src="/Public/Static/js/flot/jquery.flot.min.js?v=1.0"></script>
	<script src="/Public/Static/js/flot/jquery.flot.pie.min.js?v=1.0"></script>
	<script src="/Public/Static/js/flot/jquery.flot.stack.min.js?v=1.0"></script>
	<script src="/Public/Static/js/flot/jquery.flot.resize.min.js?v=1.0"></script>
	<script src="/Public/Static/js/flot/jquery.flot.time.min.js?v=1.0"></script>
	<script src="/Public/Static/js/flot/jquery.flot.threshold.js?v=1.0"></script>

	<script src="/Public/Static/js/scripts.js?v=1.0"></script>

	<script src="/Public/Static/js/toastr/toastr.min.js?v=1.0"></script>
	<script src="/Public/Static/js/common.js?v=1.0"></script>

	<script>
		$(document).ready(function() {

			/* initialize the external events
			-----------------------------------------------------------------*/

			$('#external-events div.external-event').each(function() {

				// it doesn't need to have a start or end
				var eventObject = {
					title : $.trim($(this).text())
				// use the element's text as the event title
				};

				// store the Event Object in the DOM element so we can get to it later
				$(this).data('eventObject', eventObject);

				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex : 999,
					revert : true, // will cause the event to go back to its
					revertDuration : 0
				//  original position after the drag
				});

			});

			var MODULE_NAME = "<?php echo MODULE_NAME; ?>";
			var CONTROLLER_NAME = "<?php echo CONTROLLER_NAME; ?>";
			$("#Menu" + MODULE_NAME).addClass('active');
			$("#MenuSub" + CONTROLLER_NAME + " a").addClass('active');

		});
	</script>
	 <script
	src="/Public/Static/lib/selectize/js/standalone/selectize.js"></script> <script
	src="/Public/Static/js/uploadify/jquery.uploadify.min.js">
		
	</script> <script type="text/javascript">
		//上传图片
		/* 初始化上传插件 */
		$("#upload_file_image")
				.uploadify(
						{
							"height" : 30,
							"swf" : "/Public/Static/js/uploadify/uploadify.swf",
							"fileObjName" : "download",
							"buttonText" : "上传附件",
							"uploader" : "<?php echo U('Avatar/uploadAvatarPicture',array('session_id'=>session_id()));?>",
							"width" : 120,
							'removeTimeout' : 1,
							"onUploadSuccess" : uploadFileavatar,
							'onFallback' : function() {
								alert('未检测到兼容版本的Flash.');
							}
						});
		function uploadFileavatar(file, data) {

			var data = $.parseJSON(data);

			if (data.status) {
				var name = "avatar";
				$("input[name=" + name + "]").val(data.url);
				$("input[name=" + name + "]")
						.parent()
						.find('.upload-img-box')
						.html(
								"<div class=\"upload-pre-file\"><span class=\"upload_icon_all\"></span> <img src='"
										+ data.url + "'/></div>");
			} else {
				updateAlert(data.info);
				setTimeout(function() {
					$('#top-alert').find('button').click();
					$(that).removeClass('disabled').prop('disabled', false);
				}, 1500);
			}
		}
	</script> 
</body>
</html>