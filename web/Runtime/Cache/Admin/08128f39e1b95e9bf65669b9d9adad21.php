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
<div class="main-title">
<h2><?php echo isset($match['id'])?'编辑':'新增';?>大赛</h2>
</div>
<link href="/Public/Static/bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="/Public/Static/bootstrap/css/datepicker.css" rel="stylesheet" />
<script src="/Public/Static/bootstrap/js/bootstrap-datepicker.js"></script>


<script type="text/javascript"
	src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
<form action="<?php echo U();?>" method="post" class="form-horizontal">
<div class="form-item"><label class="item-label">大赛名称<span
	class="check-tips">（大赛名称昵称）</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="title" value="<?php echo ((isset($match["title"]) && ($match["title"] !== ""))?($match["title"]):''); ?>"></div>
</div>

<div class="form-item"><label class="item-label">归属游戏<span
	class="check-tips">（是什么游戏的大赛）</span></label>
<div class="controls"><select name="game_id">
	<?php if(is_array($games)): $i = 0; $__LIST__ = $games;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$game): $mod = ($i % 2 );++$i;?><option value="<?php echo ($game["id"]); ?>"<?php if(($match['game_id']) == $game["id"]): ?>selected<?php endif; ?>><?php echo ($game["title_show"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select></div>
</div>
 
<div class="form-item"><label class="item-label">游戏状态<span
	class="check-tips">（游戏状态）</span></label>
<div class="controls"><select name="match_status">
	<option value="0" <?php if(($match['match_status']) == "0"): ?>selected<?php endif; ?>>未开始</option>
	<option value="1" <?php if(($match['match_status']) == "1"): ?>selected<?php endif; ?>>正在进行</option>
	<option value="2" <?php if(($match['match_status']) == "2"): ?>selected<?php endif; ?>>已经结束</option>
</select></div>
</div>


<div class="form-item"><label class="item-label">大赛标签<span
	class="check-tips">（大赛标签）</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="tags" value="<?php echo ((isset($match["tags"]) && ($match["tags"] !== ""))?($match["tags"]):''); ?>"></div>
</div>

<div class="form-item"><label class="item-label">子游戏标签<span
	class="check-tips">（大赛标签）</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="game_tags" value="<?php echo ((isset($match["game_tags"]) && ($match["game_tags"] !== ""))?($match["game_tags"]):''); ?>"></div>
</div>

<div class="form-item"><label class="item-label">直播房间号<span
	class="check-tips">（直播房间号）</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="live_id" value="<?php echo ((isset($match["live_id"]) && ($match["live_id"] !== ""))?($match["live_id"]):''); ?>"></div>
</div>


<div class="form-item"><label class="item-label">开始时间<span
	class="check-tips">（大赛开始时间）</span></label>
<div class="controls"><input type="text" class="text input-large"
	id="start_time" name="start_time"
	value="<?php echo date('Y-m-d',$match['start_time']);?>"></div>
</div>


<div class="form-item"><label class="item-label">结束时间<span
	class="check-tips">（大赛结束时间）</span></label>
<div class="controls"><input type="text" class="text input-large"
	id="end_time" name="end_time"
	value="<?php echo date('Y-m-d',$match['end_time']);?>">
	</div>
</div>

<div class="form-item"><label class="item-label">大赛封面</label> <input
	type="file" id="upload_picture"> <input type="hidden"
	name="cover" id="cover" value="<?php echo ((isset($match['cover']) && ($match['cover'] !== ""))?($match['cover']):''); ?>" />
<div class="upload-img-box"><?php if(!empty($match['cover'])): ?><div class="upload-pre-item"><img
	src="<?php echo (get_cover($match["cover"],'url')); ?>" /></div><?php endif; ?></div>
</div>
<script type="text/javascript">
					//上传图片
				    /* 初始化上传插件 */
					$("#upload_picture").uploadify({
				        "height"          : 30,
				        "swf"             : "/Public/static/uploadify/uploadify.swf",
				        "fileObjName"     : "download",
				        "buttonText"      : "上传图片",
				        "uploader"        : "<?php echo U('File/uploadMatchPic',array('session_id'=>session_id()));?>",
				        "width"           : 120,
				        'removeTimeout'	  : 1,
				        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
				        "onUploadSuccess" : uploadMatchPic,
				        'onFallback' : function() {
				            alert('未检测到兼容版本的Flash.');
				        }
				    });
					function uploadMatchPic(file, data){
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


<div class="form-item"><label class="item-label">大赛介绍<span
	class="check-tips">（大赛介绍）</span></label>
<div class="controls"><label class="textarea input-large">
<textarea name="description"><?php echo ((isset($match["description"]) && ($match["description"] !== ""))?($match["description"]):''); ?></textarea>
</label></div>
</div>
<div class="form-item"><input type="hidden" name="id"
	value="<?php echo ((isset($match["id"]) && ($match["id"] !== ""))?($match["id"]):''); ?>">
	
	<input type="hidden" name="series_id"
	value="<?php echo ((isset($match["series_id"]) && ($match["series_id"] !== ""))?($match["series_id"]):''); ?>">
	
<button class="btn submit-btn ajax-post" id="submit" type="submit"
	target-form="form-horizontal">确 定</button>
<button class="btn btn-return"
	onclick="javascript:history.back(-1);return false;">返 回</button>
</div>
</form>
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
        //导航高亮
        highlight_subnav('<?php echo U('User/index');?>');
    </script>

<script type="text/javascript">
$('#start_time').datepicker({ 
    language: 'zh-CN',
    autoclose: true, 
    format: 'yyyy-mm-dd', 
    inputMask: true
});
$('#end_time').datepicker({ 
    language: 'zh-CN',
    autoclose: true, 
    format: 'yyyy-mm-dd', 
    inputMask: true
});
</script>





</body>
</html>