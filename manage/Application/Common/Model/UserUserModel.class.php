<?php

namespace Common\Model;

use Think\Model;
class UserUserModel extends Model{
	
	
	public function info($uid=null)
	{
		return    $this->find($uid);
	}
}

?>