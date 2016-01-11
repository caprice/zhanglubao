<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>管理平台登录</title>


<link href="/Public/Static/css/bootstrap/bootstrap.css" rel="stylesheet" />

<link href="/Public/Static/css/libs/font-awesome.css" type="text/css"
	rel="stylesheet" />

<link rel="stylesheet" type="text/css"
	href="/Public/Static/css/compiled/layout.css">
<link rel="stylesheet" type="text/css"
	href="/Public/Static/css/compiled/elements.css">

<link type="image/x-icon" href="favicon.png" rel="shortcut icon" />
<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
	<![endif]-->

</head>
<body id="login-page-full">

	<div id="login-full-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div id="login-box">
						<div class="row">
							<div class="col-xs-12">
								<header id="login-header">
									<div id="login-logo">
										<img src="/Public/Static/images/login_logo.png" alt="" />
									</div>
								</header>
								<div id="login-box-inner">
									<form role="form" action="<?php echo U();?>" method="post"
										class="form-horizontal">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<input class="form-control" type="text" name="email"
												placeholder="邮箱地址">
										</div>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-key"></i></span>
											<input type="password" class="form-control" name="password"
												placeholder="密码">
										</div>

										<div class="row">
											<div class="col-xs-12">
												<button type="submit" target-form="form-horizontal"
													class="btn btn-success col-xs-12 ajax-post">登陆</button>
											</div>
										</div>
										
										<div class="row">
											<div class="col-xs-12">
												<p id="logintips" class="check-tips"></p>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="/Public/Static/js/jquery.js"></script>
	<script src="/Public/Static/js/bootstrap.js"></script>
	<script src="/Public/Member/js/login.js"></script>
	
	

</body>
</html>