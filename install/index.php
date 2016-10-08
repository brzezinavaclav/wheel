<?php
/*
 *  © CoinWheel 
 *  Demo: http://www.btcircle.com
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/




$ver = '1.4';




if (isset($_GET['checkCons'])) {
  if (@!$link=mysqli_connect($_POST['db_host'],$_POST['db_user'],$_POST['db_pass'], $_POST['db_name'])) {
    header('Location: ./?step=3&db');
    exit();
  }
  include 'driver_test.php';
  $test=new jsonRPCClient('http://'.$_POST['w_user'].':'.$_POST['w_pass'].'@'.$_POST['w_host'].':'.$_POST['w_port'].'/');
  @$test_call=$test->getbalance();

  $included_=true;
  include 'db_data.php';

  $db_file=fopen('../inc/db-conf.php','wb');
  fwrite($db_file,"<?php \n");
  fwrite($db_file,'$link = mysqli_connect(\''.$_POST['db_host'].'\',\''.$_POST['db_user'].'\',\''.$_POST['db_pass'].'\',\''.$_POST['db_name'].'\');'."\n");
  fwrite($db_file,'mysqli_query($link, "SET NAMES utf8");'."\n");
  fwrite($db_file,'mysqli_query($link, "SET SESSION sql_mode = \'\'");'."\n");
  fwrite($db_file,"?>");      ?><?php
  fclose($db_file);

  $w_file=fopen('../inc/driver-conf.php','wb');
  fwrite($w_file,"<?php \n");
  fwrite($w_file,'$driver_login=\'http://'.$_POST['w_user'].':'.$_POST['w_pass'].'@'.$_POST['w_host'].':'.$_POST['w_port'].'/\';'."\n");
  fwrite($w_file,"?>");      ?><?php
  fclose($w_file);

  header('Location: ./?step=4');
  exit();
}

if (isset($_GET['saveB'])) {
  include '../inc/db-conf.php';
  mysqli_query($link, "UPDATE `system` SET `title`='$_POST[s_title]',`url`='$_POST[s_url]',`currency`='$_POST[s_cur]',`currency_sign`='$_POST[s_cur_sign]',`description`='$_POST[s_desc]' WHERE `id`=1");
  header('Location: ./?step=5');
  exit();
}

if (empty($_GET['step']) || ($_GET['step']!=1 && $_GET['step']!=2 && $_GET['step']!=3 && $_GET['step']!=4 && $_GET['step']!=5 && $_GET['step']!=6)) {
  header('Location: ./?step=1');
  exit();
}
else $step=$_GET['step'];

if ($step==3 && (!is_writable('../inc/db-conf.php') || !is_writable('../inc/driver-conf.php'))) {
  header('Location: ./?step=2');
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>CoinWheel <?php echo $ver; ?> - Installation</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./install_page.css">
</head>
<body>
<div class="allbody">
  <div class="alls" style="text-align: center;">
    <h1>CoinWheel <?php echo $ver; ?> Installation</h1>
  </div>
</div>
<?php
switch ($step) {
case 1:
  ?>
  <script type="text/javascript">
    function next() {
      window.location.href='./?step=2';
    }
  </script>
  <div class="allbody">
    <div class="alls">
      <h3>Welcome!</h3>
      This is an automatic installation script. Please, follow the instructions on the following screens.
    </div>
  </div>
<?php
break;
case 2:
?>
  <script type="text/javascript">
    function next() {
      window.location.href='./?step=3';
    }
  </script>
  <div class="allbody">
    <div class="alls">
      <h3>File Permissions</h3>
      Please make sure that following files are writable (chmod 777):
      <br>
      <table>
        <tr>
          <td><i>inc/db-conf.php</i></td>
          <td>&nbsp;&nbsp;</td>
          <td><?php if (is_writable('../inc/db-conf.php')) { echo '<span style="color: green;"><b>Yes</b></span>'; } else { echo '<span style="color: red;"><b>No</b></span>'; } ?></td>
        </tr>
        <tr>
          <td><i>inc/driver-conf.php</i></td>
          <td>&nbsp;&nbsp;</td>
          <td><?php if (is_writable('../inc/driver-conf.php')) { echo '<span style="color: green;"><b>Yes</b></span>'; } else { echo '<span style="color: red;"><b>No</b></span>'; } ?></td>
        </tr>
      </table>
      <br>
      The above files should be writable, otherwise the installation will not continue!
    </div>
  </div>
<?php
break;
case 3:
?>
  <script type="text/javascript">
    function next() {
      document.getElementById('mform').submit();
    }
  </script>
  <div class="allbody">
    <div class="alls">
      <form id="mform" method="post" action="./?checkCons">
        <h3>Database Info</h3>
        <i>Please fill in correct database info:</i>
        <br>
        <table>
          <tr>
            <td>Host:</td>
            <td><input type="text" name="db_host" value="localhost"></td>
          </tr>
          <tr>
            <td>Username:</td>
            <td><input type="text" name="db_user" placeholder="DB user"></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="text" name="db_pass" placeholder="DB pass"></td>
          </tr>
          <tr>
            <td>Database:</td>
            <td><input type="text" name="db_name" placeholder="DB name"></td>
          </tr>
        </table>

        <h3>Wallet Info</h3>
        <i>Please fill in correct wallet info:</i>
        <br>
        <table>
          <tr>
            <td>Host:</td>
            <td><input type="text" name="w_host" value="localhost"></td>
          </tr>
          <tr>
            <td>Login:</td>
            <td><input type="text" name="w_user" placeholder="Wallet user"></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="text" name="w_pass" placeholder="Wallet password"></td>
          </tr>
          <tr>
            <td>Port:</td>
            <td><input type="text" name="w_port" placeholder="Wallet port"></td>
          </tr>
        </table>
        <i><b>Note:</b> If some of the wallet data isn't correct, you'll see an error at the next screen. In that case please go back by your browser button and try to correct informations.</i>
      </form>
    </div>
  </div>
<?php
if (isset($_GET['db'])) echo '<script type="text/javascript">alert("Can\'t connect to database! Please check entered informations.");</script>';
break;
case 4:
?>
  <script type="text/javascript">
    function next() {
      document.getElementById('mform').submit();
    }
  </script>
  <div class="allbody">
    <div class="alls">
      <h3>Basic Settings</h3>
      <br>
      <form id="mform" action="./?saveB" method="post">
        <table>
          <tr>
            <td>Site title:</td>
            <td><input type="text" name="s_title"></td>
          </tr>
          <tr>
            <td>Site description:</td>
            <td><input type="text" name="s_desc"></td>
          </tr>
          <tr>
            <td>URL:</td>
            <td><input type="text" name="s_url"></td>
            <td>(<b>without <i>http://</i></b>)</td>
          </tr>
          <tr>
            <td>Currency:</td>
            <td><input type="text" name="s_cur" placeholder="e.g. Bitcoin, Litecoin, etc."></td>
          </tr>
          <tr>
            <td>Currency sign:</td>
            <td><input type="text" name="s_cur_sign" placeholder="e.g. BTC, LTC, etc."></td>
          </tr>
        </table>
      </form>
    </div>
  </div>

<?php
break;
case 5:
?>
  <div class="allbody">
    <div class="alls">
      <h3>Thank You!</h3>
      <br>
      Your installation is done! You can login to administration or try your luck at your own gambling site :-)
      <br>
      <br>
      Admin details:<br>
      &nbsp;Username: <b>admin</b><br>
      &nbsp;Password: <b>admin</b>
      <br>
      <br>
      <i>Don't forget to change this info after first login!</i><br>
      <b>Warning!!! Delete the "/install" folder now!</b>
    </div>
  </div>
  <?php
  break;
}
?>
<div class="allbody">
  <div class="alls" style="padding: 5px; height: 30px;">
    <div style="float: left; font-style: italic;">
      <h2>Step: <?php echo $step; ?></h2>
    </div>
    <div style="float: right;">
      <?php
      if ($step==5) echo '<input id="next" type="button" onclick="javascript:window.location.href=\'../admin/\';" value="Go to Admin!" style="padding: 5px;">';
      else echo '<input id="next" type="button" onclick="javascript:next();" value="Next ->" style="padding: 5px;">';
      ?>
    </div>
  </div>
</div>
</body>
</html>