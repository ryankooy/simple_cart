<?php
$currency = '$';
$db_username = 'root';
$db_password = '';
$db_name = 'sh_cart';
$db_host = 'localhost';
$shipping_cost = 1.50;
$taxes = array('VAT' => 12, 'Service Tax' => 5);
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
if ($mysqli->connect_error) {
	die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>