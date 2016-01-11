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

<link href="/Public/Shop/css/shops.css" rel="stylesheet" type="text/css" />


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
   

<div>

	<div class="shop">
		<nav class="shop_navbar" role="navigation">


			<!-- Collect the nav links, forms, and other content for toggling -->
			<div>
				<ul class="shop-nav">
					<li><a href="<?php echo U('/shop/index');?>" class="shop-index">商城首页</a></li>
					<li><a href="<?php echo U('goods');?>">所有分类</a></li>
					<?php if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top): $mod = ($i % 2 );++$i; if($top['status'] == 1): ?><li><a href="<?php echo U('goods',array('category_id'=>$top['id']));?>"><?php echo ($top["title"]); ?></a>
					</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<div class="fl_right">


					<ul class="">
						<!--一级菜单-->
						<li class=""><a onclick="if(MID==0){op_info('没有登录，请先登录！','提示信息');return false;}" href="<?php echo U('myGoods');?>"> <i
								class="glyphicon glyphicon-list-alt"></i> 我的订单
						</a></li>

						<!--一级菜单-->
						<?php if(is_login() != 0): ?><li class=""><a href=""> <i
								class="glyphicon glyphicon-stats"></i> 当前金币：<?php echo ($my_quntiao_money); ?>
						</a></li><?php endif; ?>
					</ul>


					 
				</div>
			</div>
			<!-- /.navbar-collapse -->
		</nav>
    <div class="col-md-12  app_block clearfix">
        <div class="col-md-9 fl_left goods_detail">
            <div class="row pad_15">
                <h2 class="title_content">分类&nbsp;->&nbsp;<a
                        href="<?php echo U('goods',array('category_id'=>$top_category));?>"><?php echo ($category_name); ?></a>
                    <?php if($child_category_name != '' && $child_category_name != null): ?>&nbsp;->&nbsp;<a
                            href="<?php echo U('goods',array('category_id'=>$category_id));?>"><?php echo ($child_category_name); ?></a><?php endif; ?>
                    &nbsp;->&nbsp;<a
                            href="<?php echo U('goodsDetail',array('id'=>$content['id']));?>"><?php echo ($content["goods_name"]); ?></a>
                </h2>
                <div class="col-md-6">
                    <img class="img-responsive" src="<?php echo query_picture('url',$content['goods_ico']);?>" height="359px" width="270px">
                </div>
                <div class="col-md-6">
                    <h3 class="text-more mb_34" style="width: 100%"><font title="<?php echo (op_t($content["goods_name"])); ?>"><?php echo ($content["goods_name"]); ?></font>
                    </h3>

                    <div class="clearfix mb_34 info_item_s">
                        <?php if(is_login() != 0): ?><font title="我的<?php echo ($quntiao_money_cname); ?>：<?php echo ($my_quntiao_money); ?>"><span>所需<?php echo ($quntiao_money_name); ?>：<aq>
                                <?php echo ($content["quntiao_money_need"]); ?>
                            </aq></span></font>
                            <?php else: ?>
                            <span>所需<?php echo ($quntiao_money_name); ?>：<aq><?php echo ($content["quntiao_money_need"]); ?></aq></span><?php endif; ?>
                        <span>库存：<aq><?php echo ($content["goods_num"]); ?></aq></span>
                    </div>
                    <?php $class=''; if(is_login()){ if($my_quntiao_money>=$vo['quntiao_money_need']){ $class='open-popup-link'; }else{ $class='money_not_enough '; } } ?>
                    <div class="mb_34"><a href="#frm-post-popup" class="<?php echo ($class); ?> btn exchange_goods btn-primary "
                                          goods_id="<?php echo ($content['id']); ?>">&nbsp;&nbsp;兑&nbsp;&nbsp;换&nbsp;&nbsp;</a>
                    </div>
                    <div class="text-more mb_34 intro">
                                <span><font
                                        title="<?php echo (op_t($content["goods_introduct"])); ?>"><?php echo ($content["goods_introduct"]); ?></font></span>
                    </div>
                    <div class="time_show">
                        发布时间： <?php echo date('Y-m-d',$content['createtime']);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        更新时间： <?php echo date('Y-m-d',$content['changetime']);?>
                    </div>
                </div>
            </div>
            <div class="details">
                <h3>商品详情</h3>
                <?php echo ($content["goods_detail"]); ?>
            </div>
            <div style="padding: 5px 20px 50px 20px;">
                <?php echo hook('localComment', array('path'=>"Shop/index/$content[id]", 'uid'=>$content['uid']));?>
            </div>
        </div>
        <div class="col-md-3 fl_left">
            <?php if(is_login() != 0): ?><div class="row pad_15">
                    <h2 style="font-size: 16px;">最近浏览</h2>

                    <div class="goods_same_category clearfix">
                        <ul>
                            <?php if(is_array($goods_see_list)): $i = 0; $__LIST__ = $goods_see_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="items clearfix">
                                    <dl>
                                        <dt><a href="<?php echo U('Shop/Index/goodsDetail',array('id'=>$vo['id']));?>">
                                        <img class="img-responsive" src="<?php echo query_picture('url',$vo['goods_ico']);?>" height="150px" width="222px"></a></dt>
                                        
                                        
                                        <dd>
                                            <h3 class="text-more"><font
                                                    title="<?php echo (op_t($vo["goods_name"])); ?>"><?php echo ($vo["goods_name"]); ?></font>
                                            </h3>

                                            <div class="money"><font title="所需<?php echo ($quntiao_money_name); ?>"><i class="ico_to_money"></i>&nbsp;<?php echo ($vo["quntiao_money_need"]); ?></font>
                                            </div>
                                            <?php $class=''; if(is_login()){ if($my_quntiao_money>=$vo['quntiao_money_need']){ $class='open-popup-link'; }else{ $class='money_not_enough '; } } ?>
                                            <div><a href="#frm-post-popup"
                                                    class="<?php echo ($class); ?> btn exchange_goods btn-primary"
                                                    goods_id="<?php echo ($vo['id']); ?>">&nbsp;兑&nbsp;换&nbsp;</a></div>
                                        </dd>
                                    </dl>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <?php if(count($goods_see_list) == 0): ?><div style="font-size: 16px;padding:2em 0;color: #ccc;text-align: center">
                            你还没有浏览过其他商品哦。O(∩_∩)O~
                        </div><?php endif; ?>
                </div><?php endif; ?>
            <div class="row pad_15">
                <h2 style="font-size: 16px;">同类对比</h2>

                <div class="goods_same_category clearfix">
                    <ul>
                        <?php if(is_array($contents_same_category)): $i = 0; $__LIST__ = $contents_same_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="items clearfix">
                                <dl>
                                    <dt><a href="<?php echo U('Shop/Index/goodsDetail',array('id'=>$vo['id']));?>">
                                    <img   src="<?php echo query_picture('url',$vo['goods_ico']);?>" height="100px" width="135px"></a></dt>
                                    <dd>
                                        <h3 class="text-more"><font
                                                title="<?php echo (op_t($vo["goods_name"])); ?>"><?php echo ($vo["goods_name"]); ?></font>
                                        </h3>

                                        <div class="money"><font title="所需<?php echo ($quntiao_money_name); ?>"><i class="ico_to_money"></i>&nbsp;<?php echo ($vo["quntiao_money_need"]); ?></font>
                                        </div>
                                        <?php $class=''; if(is_login()){ if($my_quntiao_money>=$vo['quntiao_money_need']){ $class='open-popup-link'; }else{ $class='money_not_enough '; } } ?>
                                        <div><a href="#frm-post-popup" class="<?php echo ($class); ?> btn exchange_goods btn-primary"
                                                goods_id="<?php echo ($vo['id']); ?>">&nbsp;兑&nbsp;换&nbsp;</a></div>
                                    </dd>
                                </dl>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <?php if(count($contents_same_category) == 0): ?><div style="font-size: 16px;padding:2em 0;color: #ccc;text-align: center">
                        该商品没有同类商品哦。O(∩_∩)O~
                    </div><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if(is_login()): ?><!-- Modal -->
<div id="frm-post-popup" class="white-popup mfp-hide" style="max-width: 500px;">
    <h2>收货信息填写<span style="font-size: 12px;color: #BEBEBE;">(为了确保您能收到商品，请正确填写收货信息)</span></h2>

    <div class="aline" style="margin-bottom: 10px"></div>
    <div class="row">
        <form class="form-horizontal  ajax-form" role="form" action="<?php echo U('Shop/Index/goodsBuy');?>" method="post">
            <input type="hidden" id="goods_id" name="id" value="">
            <input type="hidden" name="address_id" value="<?php echo ($shop_address['id']); ?>">

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label" style="width: 20%">姓名</label>

                <div class="col-sm-10" style="width: 60%">
                    <input id="name" name="name" type="text" class="form-control"
                           value="<?php echo ($shop_address['name']); ?>"
                           placeholder="姓名"/>
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-sm-2 control-label" style="width: 20%">收货地址</label>

                <div class="col-sm-10" style="width: 60%">
                    <textarea id="address" name="address" class="form-control" placeholder="收货地址"
                              style="max-width: 310px"><?php echo ($shop_address['address']); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="zipcode" class="col-sm-2 control-label" style="width: 20%">邮编</label>

                <div class="col-sm-10" style="width: 60%">
                    <input id="zipcode" name="zipcode" type="text" class="form-control"
                           value="<?php echo ($shop_address['zipcode']); ?>" placeholder="邮编"/>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-sm-2 control-label" style="width: 20%">手机号码</label>

                <div class="col-sm-10" style="width: 60%">
                    <input id="phone" name="phone" type="text" class="form-control"
                           value="<?php echo ($shop_address['phone']); ?>"
                           placeholder="手机号码"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary ">提交</button>
                </div>
            </div>
        </form>
    </div>


</div>
<!-- /.modal --><?php endif; ?>
</div>
<input type="hidden" id="quntiao_money_name" value="<?php echo ($quntiao_money_name); ?>"/>

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

    <link type="text/css" rel="stylesheet" href="/Public/Core/js/ext/magnific/magnific-popup.css"/>
    <script type="text/javascript" src="/Public/Static/uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript" src="/Public/Core/js/ext/magnific/jquery.magnific-popup.min.js"></script>
    <script>
        var quntiao_money_name=$('#quntiao_money_name').val().trim();
        $(function () {
            $('.exchange_goods').click(function () {
                if (MID == 0) {
                    op_info('登录后才能兑换商品！', '提示消息');
                    return false;
                }
                var goods_id = this.getAttribute('goods_id');
                $('#goods_id').val(goods_id);
            });
            if (MID != 0) {
                $('.money_not_enough').click(function(){
                    op_info('你的'+quntiao_money_name+'不足！', '提示消息');
                    return false;
                });
                $('.open-popup-link').magnificPopup({
                    type: 'inline',
                    midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
                    closeOnBgClick: false
                });
            }
        })
    </script>

<?php echo hook('pageFooter', 'widget');?>
<div class="hidden">
	
</div>

	<!-- /底部 -->
</body>
</html>