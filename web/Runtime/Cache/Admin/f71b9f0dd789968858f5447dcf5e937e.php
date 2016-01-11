<?php if (!defined('THINK_PATH')) exit(); if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><dl class="cate-item">
		<dt class="cf">
			<form action="<?php echo U('edit');?>" method="post">
				<div class="btn-toolbar opt-btn cf">
					<a title="编辑" href="<?php echo U('edit?id='.$list['id'].'&pid='.$list['pid']);?>">编辑</a>
					<a title="<?php echo (show_status_op($list["status"])); ?>" href="<?php echo U('setStatus?ids='.$list['id'].'&status='.abs(1-$list['status']));?>" class="ajax-get"><?php echo (show_status_op($list["status"])); ?></a>
					<a title="删除" href="<?php echo U('remove?id='.$list['id']);?>" class="confirm ajax-get">删除</a>
					<a title="移动" href="<?php echo U('operate?type=move&from='.$list['id']);?>">移动</a>
					<a title="合并" href="<?php echo U('operate?type=merge&from='.$list['id']);?>">合并</a>
				</div>
				<div class="fold"><i></i></div>
				<div class="order"><input type="text" name="sort" class="text input-mini" value="<?php echo ($list["sort"]); ?>"></div>
				<div class="order"><?php echo ($list['allow_publish']?'是':'否'); ?></div>
				<div class="name">
					<span class="tab-sign"></span>
					<input type="hidden" name="id" value="<?php echo ($list["id"]); ?>">
					<input type="text" name="title" class="text" value="<?php echo ($list["title"]); ?>">
					<a class="add-sub-cate" title="添加子游戏" href="<?php echo U('add?pid='.$list['id']);?>">
						<i class="icon-add"></i>
					</a>
					<span class="help-inline msg"></span>
				</div>
			</form>
		</dt>
		<?php if(!empty($list['_'])): ?><dd>
				<?php echo R('Game/tree', array($list['_']));?>
			</dd><?php endif; ?>
	</dl><?php endforeach; endif; else: echo "" ;endif; ?>