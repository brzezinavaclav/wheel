<?php
/*
 *  © CoinWheel 
 *  Demo: http://www.btcircle.com
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/


header('X-Frame-Options: DENY'); 

$included=true;
include '../../inc/db-conf.php';
include '../../inc/functions.php';

if (empty($_GET['client_seed']) || !is_numeric($_GET['client_seed']) || !is_int((int)$_GET['client_seed']) || strlen($_GET['client_seed'])>24 || empty($_GET['_unique']) || mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
$player=mysqli_fetch_array(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));

$cseed=max((int)$_GET['client_seed'],((int)$_GET['client_seed']*-1));

mysqli_query($link, "UPDATE `players` SET `client_seed`=$cseed WHERE `id`=$player[id] LIMIT 1");

echo json_encode(array('error'=>'no'));

?>