<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<?php
//this form is to accept a new alert from the user
//we might be charging users who make lots of them, but that is outside of this code.
?>
<div class = "panel panel-default panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Add a new email alert</h3>
  </div>

<div class="panel-body">
<form role="form" action="?action=alertsave" method="post" >
  <div class="form-group">
    <label for="AlertName">Alert subject</label>
    <input type="text" class="form-control" name="AlertName" id="AlertName" placeholder="Enter something to remind you what this alert is for">
  </div>
  <div class="form-group">
    <label for="emailslug">Email</label>
    <div class="input-group">
      <span class="input-group-addon"><?php 
global $userRef;
$user=$mdb->getDBRef($userRef);
echo $user['username'];
?>+</span>
        <input type="text" class="form-control" name="emailslug" id="emailslug" placeholder="alertname">
      <span class="input-group-addon">@exceptionalemails.com</span>

    </div>
    <span class="help-block">This is your unique email address for this alert - so make it unique and with no spaces so it forms a valid email address.</span>

    <label for="goodregex">Good words</label>
    <input type="text" class="form-control" name="goodregex">
    <label for="badregex">Bad words</label>
    <input type="text" class="form-control" name="badregex">
    <span class="help-block">You might want to search for words like "Success" or "Done" and you might not want to see "Fail" or "Error".
    If you want to search for any of several words you can use | as a separator, e.g. bad words "fail|error" it isn't case sensitive.
    You can use full regular expression syntax if you want to.</span>
    <label for="worrytime">Worry Time</label>
    <input type="time" class="form-control" name="worrytime"  placeholder="09:00" value="09:00">
    <span class="help-block">This isn't the time the email normally arrives, it is the time when you would start to be concerned if it hasn't turned up.
Give it some leeway, sometimes things take a bit longer than normal. Time is in your timezone (<?php echo $user['timezone'] ?>).</span>
    <label>Days expected</label><br/>

<label class="checkbox-inline">
  <input type="checkbox" id="frequency2" value="Monday" name="days[]"> Monday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="frequency3" value="Tuesday"  name="days[]"> Tuesday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="frequency4" value="Wednesday"  name="days[]"> Wednesday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="frequency5" value="Thursday"  name="days[]"> Thursday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="frequency6" value="Friday"  name="days[]"> Friday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="frequency7" value="Saturday"  name="days[]"> Saturday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="frequency8" value="Sunday"  name="days[]"> Sunday
</label>
<br>
<label class="checkbox-inline">
  <input type="checkbox" id="frequenc9" value="First day of the month"  name="days[]"> First day of the month
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="frequency10" value="Last day of the month"  name="days[]"> Last day of the month
</label>
    <span class="help-block">You might want to specify that this happens just on specific days of the week or around a month end. Leave all the checkboxes blank and we will
assume that it should happen every day. (This feature might not be working yet - everything is assumed to be every day)</span>

  <div class="form-group">
<label class="checkbox">
    <input type="checkbox" id="option1" value="deleteonsuccess"  name="Options[]"> Delete email body if is a successful email (has good words and doesn't have bad words)
</label>
<label class="checkbox">
    <input type="checkbox" id="option1" value="deleteonfail"  name="Options[]"> Delete body if alert is triggered (lacks good words or has bad words)
</label>
    <span class="help-block">You might want us to discard the body content of the email on arrival after checking it for the good words/bad words. If you do choose this then we will do the tests in memory on arrival of the email and never write the body to disk. It can be handy to keep the body for failed mails as there might be some diagnostic information in there.</span>

  </div>

  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
</div>
