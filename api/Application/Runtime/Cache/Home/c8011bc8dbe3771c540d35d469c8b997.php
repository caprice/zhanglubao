<?php if (!defined('THINK_PATH')) exit();?><div class="col4 mod_board">
	<div class="col2">
		<div class="pack_focus">
			<div class="pic">
				<a href="<?php echo ($foucs["rec_url"]); ?>" title="<?php echo ($foucs["rec_title"]); ?>" target="new"></a><i
					class="bg"></i><img class="quic"
					src="/Public/Static/images/placeholder.png" 
					lazy-src="<?php echo ($foucs["rec_picture"]); ?>" title="<?php echo ($foucs["rec_title"]); ?>">
			</div>
		 
		</div>
		<div class="col1 ">
			<div class="pack packs">

				<div class="pic">
					<a href="<?php echo ($rec_eight['rec_url']); ?>"
						title="<?php echo ($rec_eight['rec_title']); ?>" target="new"></a><i class="bg"></i><img
						class="quic" src="/Public/Static/images/placeholder.png"
						lazy-src="<?php echo ($rec_eight["rec_picture"]); ?>">
				</div>
			 
			</div>
		</div>
		<div class="col1  col0">
			<div class="pack packs">

				<div class="pic">
					<a href="<?php echo ($rec_seven['rec_url']); ?>"
						title="<?php echo ($rec_seven['rec_title']); ?>" target="new"></a><i class="bg"></i><img
						class="quic" src="/Public/Static/images/placeholder.png"
						lazy-src="<?php echo ($rec_seven["rec_picture"]); ?>">
				</div>
			 
			</div>
		</div>
	</div>
	<div class="col1">

		<?php if(is_array($rec_row_ones)): $i = 0; $__LIST__ = $rec_row_ones;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rec): $mod = ($i % 2 );++$i;?><div class="pack packs">

			<div class="pic">
				<a href="<?php echo ($rec['rec_url']); ?>" title="<?php echo ($rec['rec_title']); ?>"
					target="new"></a><i class="bg"></i><img class="quic"
					src="/Public/Static/images/placeholder.png"
					lazy-src="<?php echo ($rec["rec_picture"]); ?>">
			</div>
		 
		</div><?php endforeach; endif; else: echo "" ;endif; ?>

	</div>
	<div class="col1 colx">
		 
		<?php if(is_array($rec_row_secs)): $i = 0; $__LIST__ = $rec_row_secs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rec): $mod = ($i % 2 );++$i;?><div class="pack packs">

			<div class="pic">
				<a href="<?php echo ($rec['rec_url']); ?>" title="<?php echo ($rec['rec_title']); ?>"
					target="new"></a><i class="bg"></i><img class="quic"
					src="/Public/Static/images/placeholder.png"
					lazy-src="<?php echo ($rec["rec_picture"]); ?>">
			</div>
	 
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>

</div>