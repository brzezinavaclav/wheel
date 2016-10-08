<?php
$included=true;
include '../../inc/db-conf.php';
include '../../inc/functions.php';
$time = mysqli_fetch_assoc(mysqli_query($link, "SELECT `current_winner` FROM `system` WHERE `id` = 1"));
if($time['current_winner'] != '0000-00-00 00:00:00'){
    $time = time() - strtotime($time['current_winner']);
    echo json_encode(array('error' => 'no', 'time' => $time));
}
else{
    echo json_encode(array('tracking' => 'no'));
}