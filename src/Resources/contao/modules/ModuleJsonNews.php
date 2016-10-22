<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 13.07.14
 * Time: 19:48
 */

namespace xuad_blog;

use Contao\System;

class ModuleJsonNews extends System
{
	public function getNews()
	{
		//		if ($this->Input->post('type') == 'ajaxsimple')
		//		{
		//			$arrReturn = "contao button!";
		//			header('Content-Type: application/json');
		//			echo json_encode($arrReturn);
		//			exit;

		$result = array(
			'code' => 0,
			'success' => 1,
			'message' => "tolle sachen mit angular " . rand()
		);


		echo json_encode($result);
		exit;
	}
} 