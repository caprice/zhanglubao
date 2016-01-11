<?php

namespace Space\Controller;

use Common\Controller\BaseController;


class BaseSpaceController extends BaseController{
	
	
	
	protected function listalbums($model, $where = array(), $order = '', $base = array('status'=>array('egt',0)), $field = true) {
		$options = array ();
		$REQUEST = ( array ) I ( 'request.' );
		if (is_string ( $model )) {
			$model = M ( $model );
		}
	
		$OPT = new \ReflectionProperty ( $model, 'options' );
		$OPT->setAccessible ( true );
	
		$pk = $model->getPk ();
		if ($order === null) {
		} else if (isset ( $REQUEST ['_order'] ) && isset ( $REQUEST ['_field'] ) && in_array ( strtolower ( $REQUEST ['_order'] ), array (
				'desc',
				'asc'
		) )) {
			$options ['order'] = '`' . $REQUEST ['_field'] . '` ' . $REQUEST ['_order'];
		} elseif ($order === '' && empty ( $options ['order'] ) && ! empty ( $pk )) {
			$options ['order'] = $pk . ' desc';
		} elseif ($order) {
			$options ['order'] = $order;
		}
		unset ( $REQUEST ['_order'], $REQUEST ['_field'] );
	
		$options ['where'] = array_filter ( array_merge ( ( array ) $base, ( array ) $where ), function ($val) {
			if ($val === '' || $val === null) {
				return false;
			} else {
				return true;
			}
		} );
		if (empty ( $options ['where'] )) {
			unset ( $options ['where'] );
		}
		$options = array_merge ( ( array ) $OPT->getValue ( $model ), $options );
		$total = $model->where ( $options ['where'] )->count ();
	
		if (isset ( $REQUEST ['r'] )) {
			$listRows = ( int ) $REQUEST ['r'];
		} else {
			$listRows = C ( 'LIST_ROWS' ) > 0 ? C ( 'LIST_ROWS' ) : 60;
		}
		$page = new \Think\Page ( $total, $listRows, $REQUEST );
		if ($total > $listRows) {
			$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		}
		$p = $page->show ();
		$this->assign ( '_page', $p ? $p : '' );
		$this->assign ( '_total', $total );
		$options ['limit'] = $page->firstRow . ',' . $page->listRows;
	
		return $model->getAlbumsInfo ( $options ['where'], $options ['limit'], $options ['order'] );
	}
	
	protected function listuservs($model, $where = array(), $order = 'video_id desc', $base = array('status'=>array('egt',0)), $field = true) {
		$options = array ();
		$REQUEST = ( array ) I ( 'request.' );
		if (is_string ( $model )) {
			$model = M ( $model );
		}
	
		$OPT = new \ReflectionProperty ( $model, 'options' );
		$OPT->setAccessible ( true );
	
		$pk = $model->getPk ();
		if ($order === null) {
		} else if (isset ( $REQUEST ['_order'] ) && isset ( $REQUEST ['_field'] ) && in_array ( strtolower ( $REQUEST ['_order'] ), array (
				'desc',
				'asc'
		) )) {
			$options ['order'] = '`' . $REQUEST ['_field'] . '` ' . $REQUEST ['_order'];
		} elseif ($order === '' && empty ( $options ['order'] ) && ! empty ( $pk )) {
			$options ['order'] = $pk . ' desc';
		} elseif ($order) {
			$options ['order'] = $order;
		}
		unset ( $REQUEST ['_order'], $REQUEST ['_field'] );
	
		$options ['where'] = array_filter ( array_merge ( ( array ) $base, ( array ) $where ), function ($val) {
			if ($val === '' || $val === null) {
				return false;
			} else {
				return true;
			}
		} );
		if (empty ( $options ['where'] )) {
			unset ( $options ['where'] );
		}
		$options = array_merge ( ( array ) $OPT->getValue ( $model ), $options );
		$total = $model->where ( $options ['where'] )->count ();
	
		if (isset ( $REQUEST ['r'] )) {
			$listRows = ( int ) $REQUEST ['r'];
		} else {
			$listRows = C ( 'LIST_ROWS' ) > 0 ? C ( 'LIST_ROWS' ) : 60;
		}
		$page = new \Think\Page ( $total, $listRows, $REQUEST );
		if ($total > $listRows) {
			$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		}
		$p = $page->show ();
		$this->assign ( '_page', $p ? $p : '' );
		$this->assign ( '_total', $total );
		$options ['limit'] = $page->firstRow . ',' . $page->listRows;
		return $model->getVideosInfo ( $options ['where'], $options ['limit'], $options ['order'] );
	}
	
	
	protected function listus($model, $where = array(), $order = '', $base = array('status'=>array('egt',0)), $field = true) {
		$options = array ();
		$REQUEST = ( array ) I ( 'request.' );
		if (is_string ( $model )) {
			$model = M ( $model );
		}
	
		$OPT = new \ReflectionProperty ( $model, 'options' );
		$OPT->setAccessible ( true );
	
		$pk = $model->getPk ();
		if ($order === null) {
		} else if (isset ( $REQUEST ['_order'] ) && isset ( $REQUEST ['_field'] ) && in_array ( strtolower ( $REQUEST ['_order'] ), array (
				'desc',
				'asc'
		) )) {
			$options ['order'] = '`' . $REQUEST ['_field'] . '` ' . $REQUEST ['_order'];
		} elseif ($order === '' && empty ( $options ['order'] ) && ! empty ( $pk )) {
			$options ['order'] = $pk . ' desc';
		} elseif ($order) {
			$options ['order'] = $order;
		}
		unset ( $REQUEST ['_order'], $REQUEST ['_field'] );
	
		$options ['where'] = array_filter ( array_merge ( ( array ) $base, ( array ) $where ), function ($val) {
			if ($val === '' || $val === null) {
				return false;
			} else {
				return true;
			}
		} );
		if (empty ( $options ['where'] )) {
			unset ( $options ['where'] );
		}
		$options = array_merge ( ( array ) $OPT->getValue ( $model ), $options );
		$total = $model->where ( $options ['where'] )->count ();
	
		if (isset ( $REQUEST ['r'] )) {
			$listRows = ( int ) $REQUEST ['r'];
		} else {
			$listRows = C ( 'LIST_ROWS' ) > 0 ? C ( 'LIST_ROWS' ) : 80;
		}
		$page = new \Think\Page ( $total, $listRows, $REQUEST );
		if ($total > $listRows) {
			$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		}
		$p = $page->show ();
		$this->assign ( '_page', $p ? $p : '' );
		$this->assign ( '_total', $total );
		$options ['limit'] = $page->firstRow . ',' . $page->listRows;
	
		return $model->getUsersInfo ( $options ['where'], $options ['limit'], $options ['order'] );
	}
}

?>