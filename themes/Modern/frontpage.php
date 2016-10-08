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
  <nav id="menu">
          <div class="logo"><a href="./">CoinWheel</a></div>
          <div class="nav-right">
              <div class="bal_main" style="float: left">
                  <div class="bal_title">Balance</div>
                  <div class="bal_status"><span class="balance"><?php echo number_format ($player['balance'], 8); ?></span> <?php echo $settings['currency_sign']; ?></div>
              </div>
              <a href="#" class="btn-primary" onclick="javascript:return deposit();" class="btn">Deposit</a>
              <a href="#" class="btn-primary" data-toggle="modal" data-target="#modals-withdraw" class="btn">Withdraw</a>
          </div>
  </nav>
  <div id="leftblock"></div>

<div id="page">
    <div class="leftbuttons">
        <button data-original-title="My&nbsp;Account" data-toggle="tooltip" data-placement="right" title="" onclick="javascript:leftblock('lc-profile');"><span class="glyphicon glyphicon-user"></span></button>
        <button data-original-title="Provably&nbsp;Fair" data-toggle="tooltip" data-placement="right" title="" onclick="javascript:leftblock('lc-fair');"><span class="glyphicon glyphicon-ok"></span></button>
        <button data-original-title="Stats" data-toggle="tooltip" data-placement="right" title="" onclick="javascript:leftblock('lc-stats');"><span class="glyphicon glyphicon-stats"></span></button>
        <button data-original-title="News" data-toggle="tooltip" data-placement="right" title="" onclick="javascript:leftblock('lc-news');"><span class="glyphicon glyphicon-flag"></span></button>
    </div>
  <div class="container" id="game">
          <div style="position: relative;top: -50px;">
          <img src="<?php echo $theme_folder ?>/images/arrow.png" id="arrow">
          <div id="middler"><!-- multiplier --></div>
          <img src="<?php echo $theme_folder ?>/images/<?php echo $settings['wheel'] ?>" id="wof-image">
            </div>
          <div class="spinForm">
              <input type="text" class="l downseked" onkeypress="return _runEnter(event)" id="bet_input" style="width: 122px;" value="0">
              <a href="#" onclick="javascript:return _fillPercents(10);" class="btn btn-default btn-sm">10%</a>
              <a href="#" onclick="javascript:return _fillPercents(50);" class="btn btn-default btn-sm">50%</a>
              <a href="#" onclick="javascript:return _fillPercents(100);" class="btn btn-default btn-sm">All</a>
              <a href="#" onclick="javascript:$('#bet_input').val('0');return false;" class="btn btn-default btn-sm">Clear</a>
              <br><a href="#" class="btn btn-primary btn-lg btn-block spinButton" onclick="javascript:spin();return false;">SPIN</a>
            </div>
      <div style="margin-bottom: -70px"></div>
      </div>
      <div id="stats">
          <ul id="stats-menu">
            <li><a id="stats_recent_spins" href="#" onclick="javascript:_stats_content('recent_spins');return false;">Recent Spins</a></li>
            <li><a id="stats_leaderbord" href="#" onclick="javascript:_stats_content('leaderbord');return false;">Leaderboard</a></li>
          </ul>
        <div class="stats-content">
          <div id="stats-content">
          </div>
        </div>
      </div>
      </div>

  <footer>
      &copy; <?php echo Date('Y'); ?> <b><?php echo $settings['title'].' - '.$settings['description']; ?></b><?php echo footerInfo(); ?>
      <?php include $theme_folder.'/js/includer.php'; ?>
    </footer>
<!--  BLOCKS HIDDEN BY DEFAULT  -->

<div class="modal fade" id="modals-deposit" aria-labelledby="mlabels-deposit" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mlabels-deposit">Deposit Funds</h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                Please send at least <b>0.00000001</b> <?php echo $settings['currency_sign']; ?> to this address:
                <div class="addr-p" id="_dp_addr" style="margin:15px;font-weight:bold;font-size:16px;"></div>
                <div class="addr-qr" id="fqrcode"></div>
                <div class="alert alert-infoo" style="margin: 15px;"><big><b><i>This address is only for a single use. If you want to deposit multiple times, you should generate new address.</i></b></big></div>
                <div style="margin-bottom:15px;">
                    <a href="#" class="gray_a" onclick="javascript:generateNewAddress();">New Address</a> <span class="color: lightgray">·</span> <a href="#" class="gray_a pendingbutton" id="pending_btn" onclick="javascript:viewPending();">Show Pending</a>
                </div>
                <div id="_pending_content" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modals-withdraw" aria-labelledby="mlabels-withdraw" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mlabels-withdraw">Withdraw Funds</h4>
            </div>
            <div class="modal-body">
                <div class="m_alert"></div>
                <div class="form-group">
                    <label for="input-address">Enter valid <?php echo $settings['currency_sign']; ?> address:</label>
                    <input class="form-control" id="w_valid_ltc" type="text">
                </div>
                <div class="form-group">
                    <label for="input-am">Enter amount (min. 0.001 <?php echo $settings['currency_sign']; ?>):</label>
                    <input class="form-control" id="w_amount" style="width:150px;" type="text">
                    <small>
                        Balance: <span class="balance" style="font-weight: bold;"><?php echo number_format ($player['balance'], 8); ?></span> <?php echo $settings['currency_sign']; ?></small>
                </div>
                <button class="btn btn-primary" onclick="javascript:withdraw();">Withdraw</button>
            </div>
        </div>
    </div>
</div>


<div class="leftCon" id="lc-stats">

    <div class="heading"><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;&nbsp;&nbsp;Stats</div>
    <div class="content">
        <div class="form-group">
            <label>Your spins</label><br>
            <span><?php $zsp=mysqli_fetch_array(mysqli_query($link, "SELECT `t_spins` FROM `players` WHERE `id`=$player[id] LIMIT 1")); echo $zsp['t_spins'] ?></span>
        </div>
        <div class="form-group">
            <label>Total spins</label><br>
            <span><?php echo mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `spins`")); ?></span>
        </div>

        <?php
        $system=mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `system` LIMIT 1"));
        if($system['current_winner'] != '0000-00-00 00:00:00'):
        ?>
            <p>Highest spin in last <b id="tracking_time"></b>: </p>
         <?php endif; ?>
        <p id="highest_bet"></p>
    </div>
    <div class="footer"></div>

</div>

<div class="leftCon" id="lc-profile">

    <div class="heading"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;&nbsp;My Account</div>
    <div class="content">
        <div class="form-group">
            <label>Alias</label>
            <div class="input-group">
                <input type="text" class="form-control" id="input-alias" value="<?php echo zkrat($player['alias'],15,'...'); ?>">
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" onclick="javascript:change_alias();">Save</button>
                  </span>
            </div>
        </div>

        <div class="form-group">
            <label>Password <small> (<?php if ($player['password']=='') echo 'Disabled'; else echo 'Enabled'; ?></a>)</small></label>
            <div class="input-group">
                <input type="password" class="form-control" id="input-password" value="<?php if ($player['password']!='') echo $player['password'];?>" <?php if ($player['password']!='') echo 'readonly'; ?>>
                  <span class="input-group-btn">
                    <button class="btn btn-primary" onclick="javascript:<?php if ($player['password']=='') echo 'password_protect();'; else echo 'passwd_unprotect();'; ?>" type="button"><?php if ($player['password']=='') echo 'Enable'; else echo 'Disable'; ?></a></button>
                  </span>
            </div>
        </div>

        <div class="form-group">
            <label>Unique URL</label>
                <input type="text" class="form-control" id="input-alias" value="<?php echo $settings['url']; ?>/?unique=<?php echo $unique; ?>" readonly>
        </div>


    </div>
    <div class="footer"></div>

</div>

<div class="leftCon" id="lc-news">

    <div class="heading"><span class="glyphicon glyphicon-flag"></span>&nbsp;&nbsp;&nbsp;&nbsp;News</div>
    <div class="content">
            <?php
            $query=mysqli_query($link, "SELECT * FROM `news` ORDER BY `time` DESC");
            while ($row=mysqli_fetch_array($query)) {
                echo '<div class="panel panel-default"><div class="news_single"><div class="panel-body">'.$row['content'].'</div><div class="panel-footer text-right">'.$row['time'].'</div></div></div>';
            }
            ?>

    </div>
    <div class="footer"></div>

</div>
<div class="leftCon" id="lc-fair">
    <div class="heading"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;&nbsp;Provably Fair</div>
    <div class="content">
        <h4 align="center">Next spin</h4>
        <div class="form-group">
            <label>Server seed hash</label>
                <input type="text" class="form-control" value="<?php echo hash('sha256',$player['server_seed']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Client seed</label>
            <div class="input-group">
                <input type="text" class="form-control" id="client-seed" value="<?php echo $player['client_seed']; ?>">
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="button" onclick="javascript:randomize();">Save</button>
                </div>
            </div>
        </div>
        <h4 align="center">Last spin</h4>
        <div class="form-group">
            <label>Server seed hash</label>
            <input type="text" class="form-control" value="<?php echo $player['old_server_seed']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Client seed</label>
            <input type="text" class="form-control" value="<?php echo $player['old_client_seed']; ?>" readonly>
        </div>
    </div>
    <div class="footer"></div>

</div>

</body>
</html>