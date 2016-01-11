<?php
/**
 * 获取文档封面图片
 *
 * @param int $cover_id
 * @param string $field
 * @return 完整的数据 或者 指定的$field字段值
 * @author Rocks
 */
function get_article_cover($cover_id, $field = null) {
	if (empty ( $cover_id )) {
		return false;
	}
	$picture = M ( 'DcPicture' )->find($cover_id);
	return empty ( $field ) ? $picture : $picture [$field];
}
