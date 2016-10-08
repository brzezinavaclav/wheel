<?php
/*
 *  © CoinWheel 
 *  Demo: http://www.btcircle.com
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/

if (!isset($included)) exit();

if (isset($_POST['s_title'])) {
  if (!empty($_POST['s_title']) && !empty($_POST['active_theme']) && !empty($_POST['s_url'])  && !empty($_POST['cur']) || !empty($_POST['cur_s'])) {
    echo '<div class="zpravagreen"><b>Success!</b> Data was successfuly saved.</div>';
  }
  else {
    echo '<div class="zpravared"><b>Error!</b> One of fields is empty.</div>';
  }
}

?>

<h1>Settings</h1>
<br>
<form action="./?p=settings" method="post">
  <table>
    <tr>
      <td>Active Theme:</td>
      <td>
        <select name="active_theme">
          <?php
          $tdir=opendir('../themes/');
          while (false!==($ctheme=readdir($tdir))) {
            $ifselected='';
            if ($ctheme=='.' || $ctheme=='..') continue;
            if (file_exists('../themes/'.$ctheme.'/main.css') && file_exists('../themes/'.$ctheme.'/frontpage.php'))
              if ($ctheme==$settings['active_theme']) $ifselected=' selected="selected"';
            echo '<option value="'.$ctheme.'"'.$ifselected.'>'.$ctheme."\r\n";
          }
          ?>
        </select>
      </td>
    </tr>
    <?php if($settings['active_theme']=="Modern"): ?>
    <tr>
      <td>Wheel image:</td>
      <td>
        <select  name="s_wheel">
          <option value="wheel1.png" <?php if($settings['wheel'] == 'wheel1.png') echo 'selected'; ?>>Wheel 1</option>
          <option value="wheel2.png" <?php if($settings['wheel'] == 'wheel2.png') echo 'selected'; ?>>Wheel 2</option>
        </select>
      </td>
    </tr>
    <?php else: ?>
    <input type="hidden" name="s_wheel" value="wheel1.png">
    <?php endif; ?>
    <tr>
      <td>Site Title:</td>
      <td><input type="text" name="s_title" value="<?php echo $settings['title']; ?>"></td>
    </tr>
    <tr>
      <td>Site URL:</td>
      <td><input type="text" name="s_url" value="<?php echo $settings['url']; ?>"></td>
      <td><small><i>without <b>http://</b></i></small></td>
    </tr>
    <tr>
      <td>Site Description:</td>
      <td><input type="text" name="s_desc" value="<?php echo $settings['description']; ?>"></td>
    </tr>
    <tr>
      <td>Currency:</td>
      <td><input type="text" name="cur" value="<?php echo $settings['currency']; ?>"></td>
    </tr>
    <tr>
      <td>Currency Sign:</td>
      <td><input type="text" name="cur_s" value="<?php echo $settings['currency_sign']; ?>"></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Save"></td>
    </tr>
  </table>
</form>
<hr>
<div class="zprava">
<b>Logo Setting</b><br>
<small>
  If you want to display your own logo at the top of the site, upload "<b>logo.png</b>" file
  at the root folder (<?php echo $settings['url']; ?>/<b>logo.png</b>). It automatically
  displays your logo image instead of Site Title. 
</small>
</div>