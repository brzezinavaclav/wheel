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

if (empty($_GET['pass']) || empty($_GET['_unique']) || mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
$player=mysqli_fetch_array(mysqli_query($link, "SELECT `id`,`password` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));

if ($player['password']=='') {
  mysqli_query($link, "UPDATE `players` SET `password`='".md5($_GET['pass'])."' WHERE `id`=$player[id] LIMIT 1");
  echo json_encode(array('status'=>true));
}
else echo json_encode(array('status'=>false));
?>