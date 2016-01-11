<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ($meta_title); ?>|群挑管理平台</title>
<link href="/Public/favicon.ico" type="image/x-icon"
	rel="shortcut icon">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css"
	media="all">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css"
	media="all">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css"
	media="all">
<link rel="stylesheet" type="text/css"
	href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">

<!--[if lt IE 9]> 
<script type="text/javascript" src="/Public/static/jquery-1.11.1.min.js"></script>
 <![endif]-->

<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
<!--<![endif]-->




</head>
<body>
<!-- 头部 -->
<div class="header"><!-- Logo --> <a
	href="<?php echo U('Home/Index/index');?>" title="回到前台" target="_blank"><span
	class="logo"></span></a> <!-- /Logo --> <!-- 主导航 -->
<ul class="main-nav">
	<?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<!-- /主导航 --> <!-- 用户栏 -->
<div class="user-bar"><a href="javascript:;" class="user-entrance"><i
	class="icon-user"></i></a>
<ul class="nav-list user-menu hidden">
	<li class="manager">你好，<em
		title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
	<li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
	<li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
	<li><a href="<?php echo U('Public/logout');?>">退出</a></li>
</ul>
</div>
</div>
<!-- /头部 -->

<!-- 边栏 -->
<div class="sidebar"><!-- 子导航 --> 
<div id="subnav" class="subnav"><?php if(!empty($_extra_menu)): ?> <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?> <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 --> <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
<ul class="side-sub-menu">
	<?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li><a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul><?php endif; ?> <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?></div>
 <!-- /子导航 --></div>
<!-- /边栏 -->

<!-- 内容区 -->
<div id="main-content">
<div id="top-alert" class="fixed alert alert-error"
	style="display: none;">
<button class="close fixed" style="margin-top: 4px;">&times;</button>
<div class="alert-content">这是内容</div>
</div>
<div id="main" class="main"> <!-- nav -->
<?php if(!empty($_show_nav)): ?><div class="breadcrumb"><span>您的位置:</span> <?php $i = '1'; ?> <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span> <?php else: ?> <span><a
	href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?> <?php $i = $i+1; endforeach; endif; ?></div><?php endif; ?> <!-- nav -->  
	<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
	<div class="main-title">
		<h2><?php echo isset($info['id'])?'编辑':'新增';?>游戏</h2>
	</div>
	<div class="tab-wrap">
		<ul class="tab-nav nav">
			<li data-tab="tab1" class="current"><a href="javascript:void(0);">基 础</a></li>
			<li data-tab="tab2"><a href="javascript:void(0);">高 级</a></li>
		</ul>
		<div class="tab-content">
			<form action="<?php echo U();?>" method="post" class="form-horizontal">
				<!-- 基础 -->
				<div id="tab1" class="tab-pane in tab1">
					<div class="form-item">
						<label class="item-label">上级游戏<span class="check-tips"></span></label>
						<div class="controls">
							<input type="text" class="text input-large" disabled="disabled" value="<?php echo ((isset($category['title']) && ($category['title'] !== ""))?($category['title']):'无'); ?>"/>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							游戏名称<span class="check-tips">（名称不能为空）</span>
						</label>
						<div class="controls">
							<input type="text" name="title" class="text input-large" value="<?php echo ((isset($info["title"]) && ($info["title"] !== ""))?($info["title"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							游戏标识<span class="check-tips">（英文字母）</span>
						</label>
						<div class="controls">
							<input type="text" name="name" class="text input-large" value="<?php echo ((isset($info["name"]) && ($info["name"] !== ""))?($info["name"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							发布内容<span class="check-tips">（是否允许发布内容）</span>
						</label>
						<div class="controls">
							<label class="inline radio"><input type="radio" name="allow_publish" value="0">不允许</label>
							<label class="inline radio"><input type="radio" name="allow_publish" value="1" checked>仅允许后台</label>
							<label class="inline radio"><input type="radio" name="allow_publish" value="2" >允许前后台</label>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							是否审核<span class="check-tips">（在该游戏下发布的内容是否需要审核）</span>
						</label>
						<div class="controls">
							<label class="inline radio"><input type="radio" name="check" value="0" checked>不需要</label>
							<label class="inline radio"><input type="radio" name="check" value="1">需要</label>
						</div>
					</div>
			 
					<div class="form-item">
						<label class="item-label">允许文档类型</label>
						<div class="controls">
							<?php $_result=C('DOCUMENT_MODEL_TYPE');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><label class="checkbox">
									<input type="checkbox" name="type[]" value="<?php echo ($key); ?>"><?php echo ($type); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
					<div class="controls">
						<label class="item-label">游戏图标</label>
						<input type="file" id="upload_picture">
						<input type="hidden" name="cover" id="cover" value="<?php echo ((isset($info['cover']) && ($info['cover'] !== ""))?($info['cover']):''); ?>"/>
						<div class="upload-img-box">
						<?php if(!empty($info['cover'])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($info["cover"],'url')); ?>"/></div><?php endif; ?>
						</div>
					</div>
					<script type="text/javascript">
					//上传图片
				    /* 初始化上传插件 */
					$("#upload_picture").uploadify({
				        "height"          : 30,
				        "swf"             : "/Public/static/uploadify/uploadify.swf",
				        "fileObjName"     : "download",
				        "buttonText"      : "上传图片",
				        "uploader"        : "<?php echo U('File/uploadGamePic',array('session_id'=>session_id()));?>",
				        "width"           : 120,
				        'removeTimeout'	  : 1,
				        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
				        "onUploadSuccess" : uploadGamePic,
				        'onFallback' : function() {
				            alert('未检测到兼容版本的Flash.');
				        }
				    });
					function uploadGamePic(file, data){
				    	var data = $.parseJSON(data);
				    	var src = '';
				        if(data.status){
				        	$("#cover").val(data.id);
				        	src = data.url;
				        	$("#cover").parent().find('.upload-img-box').html(
				        		'<div class="upload-pre-item"><img src="' + src + '"/></div>'
				        	);
				        } else {
				      
				        	updateAlert(data.info);
				        	setTimeout(function(){
				                $('#top-alert').find('button').click();
				                $(that).removeClass('disabled').prop('disabled',false);
				            },1500);
				        }
				    }
					</script>
				</div>

				<!-- 高级 -->
				<div id="tab2" class="tab-pane tab2">
					<div class="form-item">
						<label class="item-label">可见性<span class="check-tips">（是否对用户可见，针对前台）</span></label>
						<div class="controls">
							<select name="display">
								<option value="1">所有人可见</option>
								<option value="0">不可见</option>
								<option value="2">管理员可见</option>
							</select>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							回复<span class="check-tips">（是否允许对内容进行回复，需要详情页模板支持回复显示与提交）</span>
						</label>
						<div class="controls">
							<label class="inline radio"><input type="radio" name="reply" value="1" checked>允许</label>
							<label class="inline radio"><input type="radio" name="reply" value="0">不允许</label>
						</div>
					</div>
					<!-- <div class="form-item reply hidden">
						<label class="item-label">回复绑定的文档模型</label>
						<div class="controls">
							<?php $_result=get_document_model();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><label class="checkbox">
									<input type="checkbox" name="reply_model[]" value="<?php echo ($list["id"]); ?>"><?php echo ($list["title"]); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div> -->
					<div class="form-item">
						<label class="item-label">
							排序<span class="check-tips">（仅对当前层级游戏有效）</span>
						</label>
						<div class="controls">
							<input type="text" name="sort" class="text input-small" value="<?php echo ((isset($info["sort"]) && ($info["sort"] !== ""))?($info["sort"]):0); ?>">
						</div>
					</div>
				</div>

				<!-- 高级 -->
				<div id="tab2" class="tab-pane tab2">
					<div class="form-item">
						<label class="item-label">网页标题</label>
						<div class="controls">
							<input type="text" name="meta_title" class="text input-large" value="<?php echo ((isset($info["meta_title"]) && ($info["meta_title"] !== ""))?($info["meta_title"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">关键字</label>
						<div class="controls">
							<label class="textarea input-large">
								<textarea name="keywords"><?php echo ((isset($info["keywords"]) && ($info["keywords"] !== ""))?($info["keywords"]):''); ?></textarea>
							</label>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">描述</label>
						<div class="controls">
							<label class="textarea input-large">
								<textarea name="description"><?php echo ((isset($info["description"]) && ($info["description"] !== ""))?($info["description"]):''); ?></textarea>
							</label>
						</div>
					</div>
				</div>

				<div class="form-item">
					<input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
					<input type="hidden" name="pid" value="<?php echo isset($category['id'])?$category['id']:$info['pid'];?>">
					<button type="submit" id="submit" class="btn submit-btn ajax-post" target-form="form-horizontal">确 定</button>
					<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="cont-ft">
<div class="copyright">
<div class="fl">感谢使用<a href="http://www.quntiao.com/"
	target="_blank">群挑网</a>管理平台</div>
<div class="fr">V<?php echo (QUNTIAO_VERSION); ?></div>
</div>
</div>
</div>
<!-- /内容区 -->
<script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/index.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
<script type="text/javascript" src="/Public/static/think.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>

	<script type="text/javascript">
		highlight_subnav('<?php echo U('Game/index');?>');
	</script>

</body>
</html>