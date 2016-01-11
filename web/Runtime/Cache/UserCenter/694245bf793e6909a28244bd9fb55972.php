<?php if (!defined('THINK_PATH')) exit();?><!--微博内容列表部分-->
<link href="/Public/Weibo/css/weibo.css" rel="stylesheet"/>
<script src="/Public/Weibo/js/weibo.js"></script>
<div class="weibo_left">

    <div id="weibo_list">
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$weibo): $mod = ($i % 2 );++$i;?><div class="row" id="weibo_<?php echo ($weibo["id"]); ?>">
                <div class="col-xs-12">

                    <div class="col-md-2 col-sm-2 col-xs-12" style="position: relative">
                        <a class="s_avatar" href="<?php echo ($weibo["user"]["space_url"]); ?>" ucard="<?php echo ($weibo["user"]["uid"]); ?>">
                            <img src="<?php echo ($weibo["user"]["avatar64"]); ?>"
                                 class="avatar-img"
                                 style="width: 64px;"/>
                        </a>
                    </div>

                    <div class="col-md-10 col-sm-8 col-xs-12">
                        <style>
                            .weibo_content {
                                border-top: #f5f5f5 1px solid;
                            }
                        </style>
                        <div class="weibo_content" id="weibo_content1">
                            <div class="weibo_content_sj pull-left hidden-xs"></div>

                            <?php if(($weibo["is_top"]) == "1"): ?><div class="ribbion-green">

                                </div><?php endif; ?>

                            <p>
                                <a ucard="<?php echo ($weibo["user"]["uid"]); ?>"
                                   href="<?php echo ($weibo["user"]["space_url"]); ?>" class="user_name"><?php echo (htmlspecialchars($weibo["user"]["nickname"])); ?>
                                </a>
                                <?php echo ($weibo["user"]["icons_html"]); ?>
                                <?php if(is_array($weibo['user']['rank_link'])): $i = 0; $__LIST__ = $weibo['user']['rank_link'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i; if($vl['is_show']): ?><img src="<?php echo ($vl["logo_url"]); ?>" title="<?php echo ($vl["title"]); ?>" alt="<?php echo ($vl["title"]); ?>"
                                             class="rank_html"/><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                <?php if(is_administrator(is_login()) || $weibo['user']['uid'] == is_login() ){ ?>

                    <span class="pull-right" style="margin-right: 20px;">

                      <span class="ss" style="display: none">
                          <img src="/Public/Core/images/mark-aw1.png"/>
                      </span>

                        <div class="mark_box" style="display: none">
                            <ul class="nav text-center mark_aw">
                                <!--  <li><a>收藏</a></li>-->
                                <?php if($weibo['can_delete']): ?><li class="text-primary weibo-comment-del cpointer" data-weibo-id="<?php echo ($weibo["id"]); ?>"><a>删除</a>
                                    </li><?php endif; ?>
                            </ul>
                        </div>
                        </span>

                                <?php } ?>
                            </p>
                            <div class="weibo_content_p">
                                <?php echo ($weibo["fetchContent"]); ?>
                            </div>

                            <!--                <p class="word-wrap"><?php echo (parse_weibo_content($weibo["content"])); ?></p>
                                            <?php if($weibo['type'] == 'image'): ?><div class="popup-gallery"  style="width: 550px;">
                                            <?php if(is_array($weibo['weibo_data']['image'])): $i = 0; $__LIST__ = $weibo['weibo_data']['image'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["big"]); ?>" title="点击查看大图"><img src="<?php echo ($vo["small"]); ?>" width="100" height="100"></a><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div><?php endif; ?>
                                        -->


                            <div class="row weibo-comment-list" style="display: none;" data-weibo-id="<?php echo ($weibo["id"]); ?>">
                                <div class="col-xs-12">
                                    <div class="light-jumbotron" style="padding: 1em 2em;">
                                        <div class="weibo-comment-container">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="weibo_content_bottom row">
                                <!--"<?php echo U('bboard/Index/tmldetail',array('topic_id'=>$vo['topic_id']));?>"-->

                                <div class="col-md-4">
                            <span class="text-primary"><a
                                    href="<?php echo U('Weibo/Index/weiboDetail',array('id'=>$weibo['id']));?>"><?php echo (friendlydate($weibo["create_time"])); ?></a> </span>

                                </div>
                                <div class="col-md-8">
                                  <span class="pull-right text-primary" data-weibo-id="<?php echo ($weibo["id"]); ?>">
                        <?php $weiboCommentTotalCount = $weibo['comment_count']; ?>
                        <?php echo Hook('support',array('table'=>'weibo','row'=>$weibo['id'],'app'=>'Usercenter','uid'=>$weibo['uid']));?>
<?php echo Hook('repost',array('weiboId'=>$weibo['id']));?>
&nbsp;&nbsp;&nbsp;

<span class="text-primary weibo-comment-link cpointer" data-weibo-id="<?php echo ($weibo["id"]); ?>">
    评论<?php if($weiboCommentTotalCount): ?>（<?php echo ($weiboCommentTotalCount); ?>）<?php endif; ?>
</span>   </span>
                                </div>


                            </div>
                        </div>

                    </div>


                </div>

            </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

</div>

<script>
    ucard();
    bindSupport();
    bind_weibo_managment();


    var SUPPORT_URL = "<?php echo addons_url('Support://Support/doSupport');?>";
    var noMoreNextPage = false;
    var isLoadingWeibo = false;
    var currentPage = 1;
    var url = "<?php echo ($loadMoreUrl); ?>";

    $(document).ready(function () {

        $('.popup-gallery').each(function () { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: '正在载入 #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">图片 #%curr%</a> 无法被载入.',
                    titleSrc: function (item) {
                        /*           return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';*/
                        return '';
                    }
                }
            });
        });
    });

    function bind_weibo_managment() {

        $('.ss').mouseover(function () {
            if ($(this).parents('.weibo_content').find('.mark_box').css('display') == 'none') {
                $(this).find('img').attr('src', '/Public/Core/images/mark-aw2.png');

            } else
                $(this).find('img').attr('src', '/Public/Core/images/mark-aw3.png');
        });

        $('.ss').mouseleave(function () {
            if ($(this).parents('.weibo_content').find('.mark_box').css('display') == 'none') {
                $(this).find('img').attr('src', '/Public/Core/images/mark-aw1.png');

            } else

                $(this).find('img').attr('src', '/Public/Core/images/mark-aw4.png');

        });
        $('.weibo_content').mouseover(function () {


            $(this).find('.ss').show();

        });

        $('.ss').click(function () {

            $(this).parents('.weibo_content').find('.mark_box').toggle();
            if ($(this).parents('.weibo_content').find('.mark_box').css('display') == 'none') {
                $(this).find('img').attr('src', '/Public/Core/images/mark-aw2.png');


            } else
                $(this).find('img').attr('src', '/Public/Core/images/mark-aw3.png');
        });
        $('.weibo_content').mouseleave(function () {

            $(this).find('.ss').hide();
            $(this).find('.mark_box').hide();
        })
    }
</script>
<!--微博内容列表部分结束-->