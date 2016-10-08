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

if (empty($_GET['_unique']) || mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
$balance=mysqli_fetch_array(mysqli_query($link, "SELECT `balance` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));
$balance_=$balance['balance'];
$return=array(
  'balance' => $balance_
);
echo json_encode($return);
?>