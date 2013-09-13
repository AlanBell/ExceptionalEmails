<?php
//registration form creates a new user object in mongodb
?>
<form role="form" action="?action=registersave" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name="email" id="Email" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="Username">Username</label>
    <input type="text" class="form-control" name="username" id="username" placeholder="username">
    <span class="help-block">You will be sending automated emails to "username+alertname@exceptionalemails.com"</span>

  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="Password" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="timezone">Timezone</label>
    <input type="text" class="form-control" name="timezone" id="timezone" placeholder="Europe/London">
    <span class="help-block">This will be used to display times in your zone, and for the position of midnight, so we know which day an email arrives on</span>
  </div>
  <div class="form-group">
    <label for="dateformat">Date Format</label>
    <input type="text" class="form-control" name="dateformat" id="dateformat" placeholder="'d/M/Y h:i:s'">
    <span class="help-block">This will be used to display datetimes in the way you want to see them. <a href="http://php.net/manual/en/function.date.php">PHP date rules</a>, slightly mad, sorry.</span>
  </div>

  <div class="checkbox">
    <label>
      <input type="checkbox" name="tanc" required="required"> Terms and Conditions
    </label>
    <span class="help-block">We totally should have some Terms and Conditions. They will be acceptable, promise!</span>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
<br>
<div class="panel panel-primary">
<div class="panel-heading">Help</div>
Registering here will give you an email address @exceptionalemails, for example "alan@exceptionalemails.com" and you can then start directing
emails at virtual addresses, such as "alan+backup@exceptionalemails.com"

</div>
