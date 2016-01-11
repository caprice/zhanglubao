<?php if (!defined('THINK_PATH')) exit();?><div class="col-xs-8   main-carousel-wrapper">

<div id="focus">
<ul>
	<?php if(is_array($scrolls)): $scroll_k = 0; $__LIST__ = $scrolls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$scroll): $mod = ($scroll_k % 2 );++$scroll_k;?><li><a herf="<?php echo ($scroll['url']); ?>"><img
		style="width: 597px; height: 232px"
		src="/Public/Core/images/placeholder.png"
		lazy-src="<?php echo query_picture('url',$scroll['cover']);?>"
		alt="<?php echo ($scroll['title']); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>

</div>


<div class="col-xs-4 index-ad-right-box">

<ul>
	<?php if(is_array($recads)): $k = 0; $__LIST__ = $recads;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$recad): $mod = ($k % 2 );++$k;?><li><a href="<?php echo ($recad['url']); ?>"><img
		style="height: 114px; width: 292px;"
		src="/Public/Core/images/placeholder.png"
		lazy-src="<?php echo query_picture('url',$recad['cover']);?>"
		alt="<?php echo ($recad['title']); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>