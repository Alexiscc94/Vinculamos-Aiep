<?php
	require_once("Medoo.php");

	use Medoo\Medoo;

	if(!isset($db)) {

		$db = new Medoo(array(
			'database_type' => 'mysql',
			'database_name' => 'vinculam_vinculamos_v6_aiep',
			'server' => 'localhost',
			//'server' => 'mysql',
			'username' => 'vinculam_vinculamos_user_aiep',
			'password' => '+vUTSb!P&VXh',
			'charset' => 'utf8',
		));
	}
?>
