<?php
/*
 *  © CoinWheel 
 *  Demo: http://www.btcircle.com
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/


header('X-Frame-Options: DENY'); 

session_start();
if (isset($_GET['logout'])) {
  $_SESSION['logged_']=false;
  header('Location: ./?logouted');
  exit();
}
$included=true;
include '../inc/db-conf.php';
include '../inc/functions.php';
if (!empty($_POST['hash_one']) && !empty($_POST['hash_sec']) && mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `admins` WHERE `username`='".prot($_POST['hash_one'])."' AND `passwd`='".md5($_POST['hash_sec'])."' LIMIT 1"))!=0) {
  $this_admin=mysqli_fetch_array(mysqli_query($link, "SELECT `username` FROM `admins` WHERE `username`='".prot($_POST['hash_one'])."' AND `passwd`='".md5($_POST['hash_sec'])."' LIMIT 1"));
  $_SESSION['logged_']=true;
  $_SESSION['username']=$this_admin['username'];
  header('Location: ./');
  exit();  
} 
header('Location: ./?login_error');
?>