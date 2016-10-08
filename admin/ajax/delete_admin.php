<?php
/*
 *  © CoinWheel 
 *  Demo: http://www.btcircle.com
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/


header('X-Frame-Options: DENY'); 

session_start();
if (!isset($_SESSION['logged_']) || $_SESSION['logged_']!==true) exit();

$included=true;
include '../../inc/db-conf.php';
include '../../inc/functions.php';

if (empty($_GET['_admin']) || mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `admins` WHERE `id`='".prot($_GET['_admin'])."' LIMIT 1"))==0) exit();

mysqli_query($link, "DELETE FROM `admins` WHERE `id`='".prot($_GET['_admin'])."' LIMIT 1");
echo json_encode(array('error'=>'no'));
?>