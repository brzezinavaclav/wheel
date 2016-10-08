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
include '../../inc/wallet_driver.php';
$wallet=new jsonRPCClient($driver_login);
include '../../inc/functions.php';

if (empty($_GET['_unique']) || mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
$player=mysqli_fetch_array(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));

$new_addr=$wallet->getnewaddress();
mysqli_query($link, "INSERT INTO `deposits` (`player_id`,`address`) VALUES ($player[id],'$new_addr')");

echo json_encode(array('confirmed'=>$new_addr));
?>