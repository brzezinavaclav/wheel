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

$player=mysqli_fetch_array(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));

$pendings=array();
$n=0;
$searcher=mysqli_query($link, "SELECT * FROM `deposits` WHERE `player_id`=$player[id]");
while ($dp=mysqli_fetch_array($searcher)) {
  if ($dp['received']==0) continue;
  $pendings[]=array('amount'=>$dp['amount'],'txid'=>$dp['txid']);
}

echo json_encode($pendings);
?>
