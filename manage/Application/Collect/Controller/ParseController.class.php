<?php
namespace Collect\Controller;

use Common\Controller\BaseController;
class ParseController extends BaseController{
	
	public function index()
	{
 
	 echo fetch_youku_flv("http://v.youku.com/v_show/id_XOTUzMTIzMTQw.html?from=y1.4-4");
		
	}
}
?>