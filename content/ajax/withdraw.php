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


if (empty($_GET['amount']) || empty($_GET['valid_addr']) || empty($_GET['_unique']) || mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1 FOR UPDATE"))==0) exit();

$player=mysqli_fetch_array(mysqli_query($link, "SELECT `id`,`balance` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));

$validate=$wallet->validateaddress($_GET['valid_addr']);
if ($validate['isvalid']==false) {
  $error='yes';
  $con=0;
}
else {
  if (!is_numeric($_GET['amount']) || $_GET['amount']>$player['balance'] || $_GET['amount']<0.001) {
    $error='yes';
    $con=1;
  }
  else {
    $player=mysqli_fetch_array(mysqli_query($link, "SELECT `id`,`balance` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));
    $amount=(double)$_GET['amount']-0.0002;
    if ((double)$_GET['amount']<=$player['balance']) {
      mysqli_query($link, "UPDATE `players` SET `balance`=`balance`-".prot($_GET['amount'])." WHERE `id`=$player[id] LIMIT 1");
      $txid=$wallet->sendfrom('',$_GET['valid_addr'],$amount);
      $error='no';
      $con=$txid;
    }
  }
}
$return=array(
  'error' => $error,
  'content' => $con
);

echo json_encode($return);



?>