<?php
namespace LOL\Model;

use Think\Model;
class LolHeroModel extends Model{
	
	public function update() {
		$data = $this->create ();
		if (! $data) {
			return false;
		}
		/* 添加或更新数据 */
		if (empty ( $data ['id'] )) {
			$res = $this->add ();
		} else {
			$res = $this->save ();
		}
		return $res;
	}
}
?>