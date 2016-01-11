<?php
namespace Home\Controller;

use Think\Controller;
class TestController extends Controller {
	public function index()
	{
		S("test_test",1111,4000);
		$test=S("test_test");
		dump($test);
		if(empty($test))
		{
			 echo "yes";
		}else 
		{
			echo "no";
		}
	}
}
?>