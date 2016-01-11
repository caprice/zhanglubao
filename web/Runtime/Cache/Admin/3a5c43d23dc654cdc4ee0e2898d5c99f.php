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
<h2><?php echo isset($matchgame['id'])?'编辑':'新增';?>小组赛</h2>
</div>
<link href="/Public/Static/bootstrap/css/bootstrap.css" rel="stylesheet" />
<link
	href="/Public/Static/datetimepicker/css/bootstrap-datetimepicker.css"
	rel="stylesheet" />
<script type="text/javascript"
	src="/Public/Static/datetimepicker/js/moment.js"></script>
<script
	src="/Public/Static/datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript"
	src="/Public/Static/bootstrap/js/bootstrap.min.js"></script>
<script
	src="/Public/Static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<form action="<?php echo U();?>" method="post" class="form-horizontal">



<div class="form-item"><label class="item-label">归属游戏<span
	class="check-tips">（是什么游戏的小组赛）</span></label>
<div class="controls"><select name="game_id">
	<?php if(is_array($games)): $i = 0; $__LIST__ = $games;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$game): $mod = ($i % 2 );++$i;?><option value="<?php echo ($game["id"]); ?>"<?php if(($matchgame['game_id']) == $game["id"]): ?>selected<?php endif; ?>><?php echo ($game["title_show"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select></div>
</div>
<div class="form-item"><label class="item-label">小组赛标签<span
	class="check-tips">（小组赛名称昵称）</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="tags" value="<?php echo ((isset($matchgame["tags"]) && ($matchgame["tags"] !== ""))?($matchgame["tags"]):''); ?>"></div>
</div>


<div class="form-item"><label class="item-label">蓝队<span
	class="check-tips">（蓝队）</span></label>
<div class="controls"><select name="blue_team">
<option value="0">弃权</option>
	<?php if(is_array($teams)): $i = 0; $__LIST__ = $teams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team): $mod = ($i % 2 );++$i;?><option value="<?php echo ($team["id"]); ?>"<?php if(($matchgame['blue_team']) == $team["id"]): ?>selected<?php endif; ?>><?php echo ($team["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select></div>
</div>

<div class="form-item"><label class="item-label">红队<span
	class="check-tips">（红队）</span></label>
<div class="controls"><select name="red_team">
	<option value="0">弃权</option>
	<?php if(is_array($teams)): $i = 0; $__LIST__ = $teams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team): $mod = ($i % 2 );++$i;?><option value="<?php echo ($team["id"]); ?>"<?php if(($matchgame['red_team']) == $team["id"]): ?>selected<?php endif; ?>><?php echo ($team["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select></div>
</div>
<div class="form-item"><label class="item-label">开始时间<span
	class="check-tips">（大赛开始时间）</span></label>
<div class="controls">



<div class="form-item time-item">
<div class='input-group date' id='datetimepicker'><input
	data-date-format="MM/DD/YYYY hh:mm A/PM" type='text'
	class="form-control" id="start_time" name="start_time"
	value="<?php echo date('m/d/Y H:i',$matchgame['start_time']);?>"> <span
	class="input-group-addon"><span
	class="glyphicon glyphicon-calendar"></span> </span></div>
</div>


</div>
</div>

<div class="form-item"><label class="item-label">回合<span
	class="check-tips">（第几轮）</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="round" value="<?php echo ((isset($matchgame["round"]) && ($matchgame["round"] !== ""))?($matchgame["round"]):''); ?>"></div>
</div>

<div class="form-item"><label class="item-label">游戏状态<span
	class="check-tips">游戏状态</span></label>
<div class="controls"><select name="game_status">

	<option value="0">未开始</option>
	<option value="1">正在进行</option>
	<option value="2">已经结束</option>

</select></div>
</div>

<div class="form-item"><label class="item-label">胜利队伍<span
	class="check-tips">胜利队伍</span></label>
<div class="controls"><select name="winner">
	<option value="0">未结束</option>
	<option value="0">平局</option>
	<?php if(is_array($teams)): $i = 0; $__LIST__ = $teams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team): $mod = ($i % 2 );++$i;?><option value="<?php echo ($team["id"]); ?>"<?php if(($matchgame['winner']) == $team["id"]): ?>selected<?php endif; ?>><?php echo ($team["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select></div>
</div>

<div class="form-item"><label class="item-label">蓝队结果<span
	class="check-tips">蓝队结果</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="blue_result" value="<?php echo ((isset($matchgame["blue_result"]) && ($matchgame["blue_result"] !== ""))?($matchgame["blue_result"]):'0'); ?>"></div>
</div>


<div class="form-item"><label class="item-label">红队结果<span
	class="check-tips">红队结果</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="red_result" value="<?php echo ((isset($matchgame["red_result"]) && ($matchgame["red_result"] !== ""))?($matchgame["red_result"]):'0'); ?>"></div>
</div>

<div class="form-item"><label class="item-label">分组<span
	class="check-tips">（分组）</span></label>
<div class="controls"><select name="match_group">

	<?php $__FOR_START_1794257534__=65;$__FOR_END_1794257534__=91;for($group=$__FOR_START_1794257534__;$group < $__FOR_END_1794257534__;$group+=1){ ?><option value="<?php echo chr($group);?>"<?php if(($matchgame['match_group']) == $group): ?>selected<?php endif; ?>><?php echo chr($group);?></option><?php } ?>


</select></div>
</div>


<div class="form-item"><label class="item-label">直播房间<span
	class="check-tips">（直播房间）</span></label>
<div class="controls"><input type="text" class="text input-large"
	name="live_id" value="<?php echo ((isset($matchgame["live_id"]) && ($matchgame["live_id"] !== ""))?($matchgame["live_id"]):''); ?>"></div>
</div>


<div class="form-item"><input type="hidden" name="id"
	value="<?php echo ((isset($matchgame["id"]) && ($matchgame["id"] !== ""))?($matchgame["id"]):''); ?>"> <?php if($matchgame): ?><input type="hidden" name="match_id"
	value="<?php echo ((isset($matchgame["match_id"]) && ($matchgame["match_id"] !== ""))?($matchgame["match_id"]):''); ?>"> <?php else: ?> <input
	type="hidden" name="match_id" value="<?php echo ($match_id); ?>"><?php endif; ?>
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
    $("#datetimepicker").datetimepicker({
    	 pickDate: true,
        defaultDate: "01/01/2014",
        minDate:'01/01/2014',
    });
</script>

</body>
</html>