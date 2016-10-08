<?php
/*
 *  © CoinWheel 
 *  Demo: http://www.btcircle.com
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/

$included=true;
include './inc/db-conf.php';
include './inc/functions.php';

if (empty($_GET['_unique']) || mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
$player=mysqli_fetch_array(mysqli_query($link, "SELECT `password` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));

if (empty($_GET['pass']) || md5($_GET['pass'])!=$player['password']) {
  header('Location: ./?unique='.$_GET['_unique'].'&bad_');
  exit();
}
else {
  setcookie('protected_',md5($_GET['pass']),0);
  header('Location: ./?unique='.$_GET['_unique'].'# Do Not Share This URL!');
  exit();
}

?>