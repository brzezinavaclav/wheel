<?php

header('X-Frame-Options: DENY');

$included=true;
include '../../inc/db-conf.php';
include '../../inc/functions.php';

$system = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `system` LIMIT 1"));
if($system['current_winner'] != '0000-00-00 00:00:00'){
    $query = mysqli_query($link, "SELECT * FROM `spins` WHERE `time` > " . $system['current_winner'] . " ORDER BY `multiplier` DESC, `wager` DESC LIMIT 1");
    if ($query != false && mysqli_num_rows($query) == 1) {
        $spin = mysqli_fetch_assoc($query);
        mysqli_query($link, "UPDATE `system` SET `last_winner`=" . $spin['player']);
        $player = mysqli_fetch_array(mysqli_query($link, "SELECT `alias` FROM `players` WHERE `id`=" . $spin['player'] . " LIMIT 1"));
        echo json_encode(array('error' => 'no', 'player' => $player['alias'], 'won' => $spin['multiplier'] * $spin['wager']));
    }
    else echo json_encode(array('error' => 'yes', 'message' => 'No records found'));
}
else{
    if(mysqli_num_rows(mysqli_query($link, "SELECT `alias` FROM `players` WHERE `id`=" . $system['last_winner'] . " LIMIT 1")) !=0) {
        $player = mysqli_fetch_array(mysqli_query($link, "SELECT `alias` FROM `players` WHERE `id`=" . $system['last_winner'] . " LIMIT 1"));
    }
    else $player['alias'] = '[Unknown]';
    echo json_encode(array('error' => 'no', 'tracking' => 'no', 'player' => $player['alias']));
}