<?php
//registration form creates a new user object in mongodb
?>
<form role="form" action="?action=registersave" method="post">

  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" name="email" id="Email" placeholder="Enter email" required="required">
    <span class="help-block">Your email address where alerts about missing emails will be sent.</span>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password" id="Password" placeholder="Password" required="required">
    <span class="help-block">This will be encrypted or hashed on the server for security. Please don't forget it as we don't have a recovery process yet.</span>
  </div>

  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" id="username" placeholder="" required="required">
    <span class="help-block">You will be sending automated emails to "username+alertname@exceptionalemails.com"</span>

  </div>
  <div class="form-group">
    <label for="timezone">Timezone</label>

    <select class="form-control" name="timezone" id="timezone" value="Europe/London">
<?php
$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
foreach ($tzlist as $zone){
    if($zone=="Europe/London"){
        echo '      <option selected>' . $zone . "</option>\n";
    }else{
        echo '      <option>' . $zone . "</option>\n";
    }
}
?>
    </select>
    <span class="help-block">This will be used to display times in your zone and to work out the position of midnight, so we know where yesterday stops and today starts.</span>
  </div>
  <div class="form-group">
    <label for="dateformat">Date Format</label>
    <input type="text" class="form-control" name="dateformat" id="dateformat" value="d/m/Y h:i:s">
    <span class="help-block">This will be used to display datetimes in the way you want to see them. <a href="http://php.net/manual/en/function.date.php">PHP date rules</a>, slightly mad, sorry.</span>
  </div>

  <div class="checkbox">
    <label>
      <input type="checkbox" name="tanc" required="required"> Terms and Conditions
    </label>
    <span class="help-block">We have some <a href="?action=tandc">Terms and Conditions</a>. They are acceptable, promise!</span>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
