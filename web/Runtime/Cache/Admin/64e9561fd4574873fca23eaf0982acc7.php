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
        <h2><?php echo ($title); ?></h2>
    </div>
    <script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
    <form action="<?php echo ($savePostUrl); ?>" method="post" class="form-horizontal">
        <?php if(is_array($keyList)): $i = 0; $__LIST__ = $keyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;?><label class="item-label"><?php echo (htmlspecialchars($field["title"])); ?>
                <?php if($field['subtitle']): ?><span class="check-tips">（<?php echo (htmlspecialchars($field["subtitle"])); ?>）</span><?php endif; ?>
            </label>
            <?php if($field['name'] == 'action'): ?><p style="color: #f00;">开发人员注意：你使用了一个名称为action的字段，由于这个字段名称会与form[action]冲突，导致无法提交表单，请换用另外一个名字。</p><?php endif; ?>
            <div class="controls">
                <?php switch($field["type"]): case "text": ?><input type="text" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>" class="text input-large"/><?php break;?>
                    <?php case "hidden": ?><input type="hidden" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>" class="text input-large"/><?php break;?>
                    <?php case "readonly": ?><input type="text" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>" class="text input-large" placeholder="无需填写" readonly/><?php break;?>
                    <?php case "integer": ?><input type="text" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>" class="text input-large"/><?php break;?>
                    <?php case "uid": ?><input type="text" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>" class="text input-large"/><?php break;?>
                    <?php case "select": ?><select name="<?php echo ($field["name"]); ?>">
                            <?php if(is_array($field["opt"])): $i = 0; $__LIST__ = $field["opt"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i; $selected = $field['value']==$key ? 'selected' : ''; ?>
                                <option value="<?php echo ($key); ?>" <?php echo ($selected); ?>><?php echo (htmlspecialchars($option)); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select><?php break;?>
                    <?php case "radio": if(is_array($field["opt"])): $i = 0; $__LIST__ = $field["opt"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i; $checked = $field['value']==$key ? 'checked' : ''; $inputId = "id_$field[name]_$key"; ?>
                            <input id="<?php echo ($inputId); ?>" name="<?php echo ($field["name"]); ?>" value="<?php echo ($key); ?>" type="radio" <?php echo ($checked); ?>/>
                            <label for="<?php echo ($inputId); ?>"><?php echo (htmlspecialchars($option)); ?></label><?php endforeach; endif; else: echo "" ;endif; break;?>
                    <?php case "image": ?><div class="controls">
                            <input type="file" id="upload_picture_<?php echo ($field["name"]); ?>">
                            <input type="hidden" name="<?php echo ($field["name"]); ?>" id="cover_id_<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"/>
                            <div class="upload-img-box">
                                <?php if(!empty($field["value"])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($field["value"],'path')); ?>"/></div><?php endif; ?>
                            </div>
                        </div>
                        <script type="text/javascript">
                            //上传图片
                            /* 初始化上传插件 */
                            $("#upload_picture_<?php echo ($field["name"]); ?>").uploadify({
                                "height"          : 30,
                                "swf"             : "/Public/static/uploadify/uploadify.swf",
                                "fileObjName"     : "download",
                                "buttonText"      : "上传图片",
                                "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
                                "width"           : 120,
                                'removeTimeout'	  : 1,
                                'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
                                "onUploadSuccess" : uploadPicture<?php echo ($field["name"]); ?>,
                            'onFallback' : function() {
                                alert('未检测到兼容版本的Flash.');
                            }
                            });
                            function uploadPicture<?php echo ($field["name"]); ?>(file, data){
                                var data = $.parseJSON(data);
                                var src = '';
                                if(data.status){
                                    $("#cover_id_<?php echo ($field["name"]); ?>").val(data.id);
                                    src = data.url || '' + data.path
                                    $("#cover_id_<?php echo ($field["name"]); ?>").parent().find('.upload-img-box').html(
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
                        </script><?php break;?>
                    <?php case "checkbox": $importCheckBox = true; ?>
                        <?php $field['value_array'] = explode(',', $field['value']); ?>
                        <?php if(is_array($field["opt"])): $i = 0; $__LIST__ = $field["opt"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i; $checked = in_array($key,$field['value_array']) ? 'checked' : ''; $inputId = "id_$field[name]_$key"; ?>
                            <input type="checkbox" value="<?php echo ($key); ?>" id="<?php echo ($inputId); ?>" class="oneplus-checkbox" data-field-name="<?php echo ($field["name"]); ?>" <?php echo ($checked); ?>/>
                            <label for="<?php echo ($inputId); ?>"><?php echo (htmlspecialchars($option)); ?></label>
                            <input type="hidden" name="<?php echo ($field["name"]); ?>" class="oneplus-checkbox-hidden" data-field-name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>"/><?php endforeach; endif; else: echo "" ;endif; break;?>
                    <?php case "editor": ?><label class="textarea">
                            <textarea name="<?php echo ($field["name"]); ?>"><?php echo (htmlspecialchars($field["value"])); ?></textarea>
                            <?php echo hook('adminArticleEdit', array('name'=>$field['name'],'value'=>$field['value']));?>
                        </label><?php break;?>
                    <?php case "textarea": ?><textarea name="<?php echo ($field["name"]); ?>" class="text input-large" style="height: 8em;"><?php echo (htmlspecialchars($field["value"])); ?></textarea><?php break;?>
                    <?php case "time": $importDatetimePicker = true; if(!$field['value']){ $field['value'] = time(); } ?>
                        <input type="hidden" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>"/>
                        <input type="text" data-field-name="<?php echo ($field["name"]); ?>" class="text input-large time" value="<?php echo (time_format($field["value"])); ?>" placeholder="请选择时间" /><?php break;?>
                    <?php default: ?>
                    <span style="color: #f00;">错误：未知字段类型 <?php echo ($field["type"]); ?></span>
                    <input type="hidden" name="<?php echo ($field["name"]); ?>" value="<?php echo (htmlspecialchars($field["value"])); ?>"/><?php endswitch;?>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>

        <br/>
        <div class="form-item">
            <?php if(is_array($buttonList)): $i = 0; $__LIST__ = $buttonList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$button): $mod = ($i % 2 );++$i;?><button <?php echo ($button["attr"]); ?>><?php echo ($button["title"]); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
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

    <?php if($importDatetimePicker): ?><link href="/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
        <?php if(C('COLOR_STYLE')=='blue_color') echo '<link href="/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">'; ?>
        <link href="/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

        <script>
            $('.time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language:"zh-CN",
                minView:2,
                autoclose:true
            });

            $('.time').change(function(){
                var fieldName = $(this).attr('data-field-name');
                var dateString = $(this).val();
                var date = new Date(dateString);
                var timestamp = date.getTime();
                $('[name='+fieldName+']').val(Math.floor(timestamp/1000));
            });
        </script><?php endif; ?>

    <?php if($importCheckBox): ?><script>
            $(function(){
                function implode(x, list) {
                    var result = "";
                    for(var i=0;i<list.length;i++){
                        if(result == "") {
                            result += list[i];
                        } else {
                            result += ',' + list[i];
                        }
                    }
                    return result;
                }

                $('.oneplus-checkbox').change(function(e){
                    var fieldName = $(this).attr('data-field-name');
                    var checked = $('.oneplus-checkbox[data-field-name='+fieldName+']:checked');
                    var result = [];
                    for(var i=0;i<checked.length;i++) {
                        var checkbox = $(checked.get(i));
                        result.push(checkbox.attr('value'));
                    }
                    result = implode(',', result);
                    $('.oneplus-checkbox-hidden[data-field-name='+fieldName+']').val(result);
                });
            })
        </script><?php endif; ?>

    <script type="text/javascript">
        Think.setValue("type", <?php echo ((isset($info["type"]) && ($info["type"] !== ""))?($info["type"]):0); ?>);
        Think.setValue("group", <?php echo ((isset($info["group"]) && ($info["group"] !== ""))?($info["group"]):0); ?>);
        //导航高亮
        highlight_subnav('<?php echo U('Config/index');?>');
    </script>


</body>
</html>