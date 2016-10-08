<?php
/*
 *  © CoinWheel 
 *  Demo: http://www.btcircle.com
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/

if (!isset($included)) {
  header('Location: ../');
  exit();
}     

function div($a, $b){
  if($b !=0) return $a/$b;
  else return 0;
}

function prot_mail($mail2,$max_delka=0) {
  $mail=mysql_real_escape_string(trim(chop(strip_tags($mail2))));
  if (strpos($mail,"@")==0 || strpos($mail,".")==0 || substr($mail,-1)=="@" || substr($mail,-1)==".")
    $vystup=false;
  else {
    if ($max_delka!=0) {
      if (strlen($mail)>$max_delka)  $vystup=false;
      else  $vystup=$mail;
    }
    else  $vystup=$mail;
  }
  return $vystup;
}

function prot($hodnota,$max_delka=0) {
  global $link;
  $text=mysqli_real_escape_string($link, strip_tags($hodnota));
  if ($max_delka!=0)  $vystup=substr($text,0,$max_delka);
  else  $vystup=$text;
  return $vystup;
}

function generateHash($delka_retezce,$capt=false) {
  if ($capt==true) $mozne_znaky='123456789ABCDEFGHIJKLMNPQRSTUVWXYZ'; 
  else $mozne_znaky='abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $vystup='';
  for ($i=0;$i<$delka_retezce;$i++)  $vystup.=$mozne_znaky[mt_rand(0,strlen($mozne_znaky)-1)];
  return $vystup;
}

function newPlayer($wallet) {
  global $link;
  generate_: {
    $hash=generateHash(32);
  }
  if (mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `players` WHERE `hash`='$hash' LIMIT 1"))!=0) goto generate_;
  $alias='Player_';
  $alias_i=mysqli_fetch_array(mysqli_query($link, "SELECT `autoalias_increment` AS `data` FROM `system` LIMIT 1"));
  $alias_i=$alias_i['data'];
  mysqli_query($link, "UPDATE `system` SET `autoalias_increment`=`autoalias_increment`+1 LIMIT 1");
  mysqli_query($link, "INSERT INTO `players` (`hash`,`alias`,`time_last_active`) VALUES ('$hash','".$alias.$alias_i."',NOW())");
  header('Location: ./?unique='.$hash.'# Do Not Share This URL!');
  exit();
}

function zkrat($str,$max,$iflonger) {
  if (strlen($str)>$max) {
    $str=substr($str,0,$max).$iflonger;
  }
  return $str;
}
function footerInfo() {
  return ' '.'|'.' '.'P'.'o'.'w'.'e'.'r'.'e'.'d'.' '.'b'.'y'.' '.'<'.'a'.' '.'h'.'r'.'e'.'f'.'='.'"'.'h'.'t'.'t'.'p'.':'.'/'.'/'.'w'.'w'.'w'.'.'.'c'.'o'.'i'.'n'.'t'.'o'.'l'.'i'.'.'.'c'.'o'.'m'.'/'.'p'.'r'.'o'.'d'.'u'.'c'.'t'.'/'.'d'.'e'.'t'.'a'.'i'.'l'.'/'.'3'.'1'.'"'.' '.'t'.'a'.'r'.'g'.'e'.'t'.'='.'"'.'_'.'b'.'l'.'a'.'n'.'k'.'"'.'>'.'C'.'o'.'i'.'n'.'W'.'h'.'e'.'e'.'l'.' '.'1'.'.'.'0'.'<'.'/'.'a'.'>';
}

?>