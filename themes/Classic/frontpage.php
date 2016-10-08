<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $settings['title'].' - '.$settings['description']; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_folder ?>/main.css">
    <script type="text/javascript" src="<?php echo $theme_folder ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $theme_folder ?>/js/rotate.js"></script>
</head>
<body>
  <?php include $theme_folder.'/js/includer.php'; ?>
  <script type="text/javascript" src="./themes/<?php echo $settings['active_theme']?>/js/jquery.msgBox.js"></script>
  <link rel="stylesheet" type="text/css" href="./themes/<?php echo $settings['active_theme']?>/css/msgBoxLight.css">
  <audio id="audio-spinning">
    <source src="./content/sounds/spinning/spinning.mp3" type="audio/mpeg">
    <source src="./content/sounds/spinning/spinning.ogg" type="audio/ogg">
  </audio>
  <audio id="audio-success">
    <source src="./content/sounds/success/success.mp3" type="audio/mpeg">
    <source src="./content/sounds/success/success.ogg" type="audio/ogg">
  </audio>
  <audio id="audio-lose">
    <source src="./content/sounds/lose/lose.mp3" type="audio/mpeg">
    <source src="./content/sounds/lose/lose.ogg" type="audio/ogg">
  </audio>
  <div id="allbody">
    <div id="ab-content">
      <div class="nahore">
        <a href="./" id="logo"><?php echo (file_exists('./themes/'.$settings['active_theme'].'/logo.png'))?'<img src="./themes/'.$settings['active_theme'].'/logo.png">':'<span style="position: relative; top: 8px;">'.$settings['title'].'</span>'; ?></a><br>
        <div id="alt-menu"><a href="#" onclick="javascript:return deposit();" class="deposit">Deposit</a><a href="#" onclick="javascript:return withdraw();" class="withdraw">Withdraw</a> • <a href="https://www.cointoli.com/?product=12" target="_blank" class="third">CoinWheel 1.0</a></div>
        <table id="wof">
          <tr>
            <td valign="top" align="right"><div style="margin-top: 208px;"><big><big><big><big><b><img src="./themes/<?php echo $settings['active_theme']?>/images/arrow.png" id="arrow"></b></big</big></big></big></div></td>
            <td valign="top" align="left" style="height: 500px;">
              <div id="middler"><!-- multiplier --></div>
              <img src="./themes/<?php echo $settings['active_theme']?>/images/wof.png" id="wof-image">
              <img src="./themes/<?php echo $settings['active_theme']?>/images/wof_center.png" id="wof-image" class="wfcenter">
            </td>
          </tr>
        </table><br><br><br><br><br>
        <div id="left-content">
          <div style="width: 420px; padding-left: 23px;"><span onclick="javascript:getElementById('unique').select();" style="cursor: pointer; cursor: hand;"><b>Your unique URL</b></span><br><input id="unique" readonly="readonly" type="text" class="l unique" title="Click to select all" onclick="javascript:this.select();" value="<?php echo $settings['url']; ?>/?unique=<?php echo $unique; ?>"></div>
          <div id="balance" style="margin-top: 25px;"><big>Your Balance: <b><span id="balance_"><?php echo number_format($player['balance'],6); ?></span></b> <?php echo $settings['currency_sign']; ?> &nbsp;&nbsp;<a href="./" onclick="javascript:return refreshbalance();"><img id="_refresh" src="./themes/<?php echo $settings['active_theme']?>/images/refresh.png" style="position: relative; top: 4px; width: 18px; height: 18px;" title="Refresh balance"></a></big></div>
          <table cellspacing="0" width="250px;" id="bet_table">
            <tr>
              <td></td>
              <td id="fillPercents">
                <a href="#" onclick="javascript:return _fillPercents(10);">10%</a>
                <a href="#" onclick="javascript:return _fillPercents(50);">50%</a>
                <a href="#" onclick="javascript:return _fillPercents(100);">All</a>
                <a href="#" onclick="javascript:$('#bet_input').val('0');return false;" class="longer">Clear</a>
              </td>
            </tr>
            <tr>
              <td><b>Bet: &nbsp;</b></td>
              <td><input type="text" class="l downseked" onkeypress="return _runEnter(event)" id="bet_input" style="width: 186px;" value="0"></td>
            </tr>
            <tr>
              <td></td>
              <td><a href="#" class="spinButton" onclick="javascript:spin();return false;">SPIN</a></td>
            </tr>          
          </table>
          <div style="height: 40px;"></div>

          <div id="balance">
            <a href="#" class="randomize options" onclick="javascript:<?php if ($player['password']=='') echo 'passwd_protect();'; else echo 'passwd_unprotect();'; ?>return false;"><?php if ($player['password']=='') echo 'Set Pass'; else echo 'Remove Pass'; ?></a> |
            <a href="#" onclick="javascript:_changeAlias(prompt('Type in your alias:'));return false;" class="randomize options"><?php echo zkrat($player['alias'],15,'...'); ?></a> |
            <a href="#" onclick="javascript:return deposit();" class="randomize options">Deposit</a> |
            <a href="#" onclick="javascript:return withdraw();" class="randomize options">Withdraw</a>            
          </div>

          <div id="placer_">
            <br><br>
            <table style="margin-left: auto; margin-right: auto; text-align: center;"><tr>            
              <td class="spins_s"><i>Your spins:</i><br><big><span id="yspins"><?php $zsp=mysqli_fetch_array(mysqli_query($link, "SELECT `t_spins` FROM `players` WHERE `id`=$player[id] LIMIT 1")); echo $zsp['t_spins'] ?></span></big></td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td class="spins_s"><i>Total spins:</i><br><big><span id="tspins"><?php echo mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `spins`")); ?></span></big></td>
            </tr></table>
          </div>
        </div>
      </div>      
      <div class="dole">
      <div id="centerer">
        <ul id="stats-menu">
          <li><a id="stats_recent_spins" href="#" onclick="javascript:_stats_content('recent_spins');return false;">Recent Spins</a></li>
          <li><a id="stats_leaderbord" href="#" onclick="javascript:_stats_content('leaderbord');return false;">Leaderbord</a></li>
          <li><a id="stats_news" href="#" onclick="javascript:_stats_content('news');return false;">News</a></li>
          <li><a id="stats_fair" href="#" onclick="javascript:_stats_content('fair');return false;">Fair?</a></li>
        </ul>
      </div>
      <div id="stats-content">
        
      </div>
      <script type="text/javascript">
        _stats_content('recent_spins');
      </script>
      </div>
    </div>
    <div style="width: 100%; text-align: center; margin-top: 12px; padding-top: 12px; border-top: 1px solid #666699;">
      &copy; <?php echo Date('Y'); ?> <b><?php echo $settings['title'].' - '.$settings['description']; ?></b><?php echo footerInfo(); ?>   
    </div>
    <div style="height: 20px;"></div>
  </div>
  
</body>
</html>