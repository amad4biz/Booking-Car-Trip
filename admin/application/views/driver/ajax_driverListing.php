<?php
//	print_r($_GET);
//	die();
	$driver = $_GET['driverData'];
	print_r($driver);
	$search = $_GET['search']['value'];
	$start = $_GET['start'];
	$length = $_GET['length'];
	$column = $_GET['order'][0]['column'];
	$columnDir = $_GET['order'][0]['dir'];
	
	
?>