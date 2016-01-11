<?php if (!defined('THINK_PATH')) exit();?>
<div class="friendlinks">

<ul>

<li>友情链接：</li>
<?php if(is_array($friendlinks)): $i = 0; $__LIST__ = $friendlinks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($link["url"]); ?>"><?php echo ($link["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>

</div>