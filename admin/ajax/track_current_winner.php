<?php
header('X-Frame-Options: DENY');

$included=true;
include '../../inc/db-conf.php';
include '../../inc/functions.php';

if(isset($_GET['stop'])){
    if (mysqli_query($link, "UPDATE `system` SET `current_winner` = '0000-00-00 00:00:00' WHERE `id` = 1") === TRUE) echo json_encode(array('error' => 'no'));
}
else{
    if (mysqli_query($link, "UPDATE `system` SET `current_winner` = CURRENT_TIMESTAMP WHERE `id` = 1") === TRUE) echo json_encode(array('error' => 'no'));
}