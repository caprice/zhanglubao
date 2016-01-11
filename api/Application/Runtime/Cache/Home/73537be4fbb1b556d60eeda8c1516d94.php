<?php if (!defined('THINK_PATH')) exit();?><div class="h">
	<h2>热门栏目</h2>
</div>
<div class="sline"></div>
<div class="albums">

	<ul>
		<?php if(is_array($albums)): $i = 0; $__LIST__ = $albums;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$album): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/album-detail-'.$album['id'].'@v');?>" target="_blank"
			class="album-cover"><img src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($album["album_picture"]); ?>"
				title="<?php echo ($album["album_name"]); ?>"></a><a
			href="<?php echo U('/album-detail-'.$album['id'].'@v');?>" target="_blank" class="t"><?php echo ($album["album_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>