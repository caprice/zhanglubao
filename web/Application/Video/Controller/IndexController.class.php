<?php
namespace Video\Controller;

class IndexController extends BaseController{
	
	public function  index()
	{
		$this->display();
	}
	public  function view($id)
	{
		$this->display();
	}
}

?>