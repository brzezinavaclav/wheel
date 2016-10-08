<?php
/*
 *  © CoinWheel 
 *  Demo: http://www.btcircle.com
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/


header('X-Frame-Options: DENY'); 

session_start();
if (isset($_SESSION['logged_']) && $_SESSION['logged_']==true)
  $logged=true;
else $logged=false;
//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//
$included=true;
include '../inc/db-conf.php';
include '../inc/wallet_driver.php';
$wallet=new jsonRPCClient($driver_login);
include '../inc/functions.php';

include './post.php';
$settings=mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `system` WHERE `id`=1 LIMIT 1"));
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $settings['title']; ?> - ADMINISTRATION</title>
    <meta charset="utf-8">
    <link href="layout.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
      function message(type,cont) {
        if (type=='error') {
          color='zpravared';
          h='Error:';
        }
        else if (type=='success') {
          color='zpravagreen';
          h='Success:';
        }
        $("div.messages").html('<div class="'+color+'"><b>'+h+'</b> '+cont+'</div>');
      }
    </script>
  </head>
  <body>
    <div class="main head">
      <div style="float: left; text-align: left; margin-left: 5px; position: relative; top: 4px;">
        <b>ADMINISTRATION - <?php echo $settings['title']; ?></b>
        <br>
        <a href="<?php echo 'http://' . $settings['url']; ?>" target="_blank" title="Opens site in new window">← go to site</a>
      </div>
      <div style="float: right; margin-right: 10px; line-height: 40px;">
        User: <?php if ($logged) echo $_SESSION['username'].' | <a href="./login.php?logout">Logout</a>'; else echo 'Unlogged'; ?>
      </div>
      <img src="imgs/rulette.png" style="width: 39px;">
    </div>
    <div class="main">
      <div class="obsah">
        <?php
        if (!$logged) { 
          if (isset($_GET['login_error'])) echo '<div class="zpravared"><b>Error: </b>Wrong login details.</div>';
          if (isset($_GET['logouted'])) echo '<div class="zpravagreen"><b>Success: </b>You have been logged out.</div>';
        ?>
          <form action="login.php" method="post">
            <table border="0">
              <tbody><tr><td>Username:</td><td><input style="width: 150px;" name="hash_one" type="text"></td></tr>
              <tr><td>Password:</td><td><input style="width: 150px;" name="hash_sec" type="password"></td></tr>
              <tr><td></td>
                <td colspan="2"><input name="prihlaseni" value="Login" type="submit"></td></tr>
              </tbody></table>
          </form>
         <?php
         }
         else {
          echo '<div class="messages"></div>';
          if (!empty($_GET['p']) && file_exists('./pages/'.$_GET['p'].'.php'))
            include './pages/'.$_GET['p'].'.php';
           else if (!isset($_GET['p'])) include './pages/home.php';
           else include '404.php';  
         }
         ?>
      </div>
      <div class="menu_">
        <ul>
          <li><a href="./">Home</a></li>
          <?php if ($logged) { ?>
          <li><a href="./?p=players">Players</a></li>
          <li><a href="./?p=spins">Spins</a></li>
          <li><a href="./?p=stats">Stats</a></li>          
          <li><a href="./?p=wallet">Wallet</a></li>
          <li><a href="./?p=news">News</a></li>
          <li><a href="./?p=admins">Admins</a></li>
          <li><a href="./?p=settings">Settings</a></li>          
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="main paticka">
      &copy; <?php echo date('Y',time()).' '; ?> | <?php echo $settings['title']; ?> Administration
    </div>
  </body>
</html>