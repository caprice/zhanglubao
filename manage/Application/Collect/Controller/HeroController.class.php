<?php
namespace Collect\Controller;

use Common\Controller\BaseController;

class HeroController extends BaseController {

	public function index() {
		$json = '[{"tag4": "", "en_name": "Kindred", "magic": "2", "name": "千珏", "tag2": "法师", "tag3": "", "money": "4500", "newhero": true, "newmoney": "", "nick": "永猎双子", "attack": "8", "defense": "2", "difficulty": "4", "coin": "7800", "discount": false, "id": 203, "tag1": "射手"}]';
		 
		$heros = json_decode($json ,true);
		print_r($heros);
		foreach ( $heros as $hero ) {
			$data ['tag1'] = $hero ['tag1'];
			$data ['tag2'] = $hero ['tag2'];
			$data ['tag3'] = $hero ['tag3'];
			$data ['tag4'] = $hero ['tag4'];
			$data ['name'] = $hero ['name'];
			$data ['en_name'] = $hero ['en_name'];
			$data ['nick'] = $hero ['nick'];
			$data ['avatar'] = "http://image.lol.zhanglubao.com/lol/hero/champion/" . $hero ['en_name'] . ".png";
			$data = D ( 'LolHero' )->create ($data);
			S ( 'category_index', null );
			if (! $data) {
				return false;
			}
			 $res = D ( 'LolHero' )->add ();
		}
	}
}
?>