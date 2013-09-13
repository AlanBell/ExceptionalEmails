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
    <label for="AlertName">Alert Subject</label>
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
    <label for="goodregex">Good words</label>
    <input type="text" class="form-control" name="goodregex" placeholder="Success">
    <label for="badregex">Bad words</label>
    <input type="text" class="form-control" name="badregex"  placeholder="Fail">
    <span class="help-block">You might want to search for words like "Success" or "Done" and you might not want to see "Fail" or "Error".
    If you want to search for any of several words you can use | as a separator, e.g. bad words "fail|error" it isn't case sensitive.
    You can use full regular expression syntax if you want to.</span>
    <label for="worrytime">Worry Time</label>
    <input type="time" class="form-control" name="worrytime"  placeholder="09:00" value="09:00">
    <span class="help-block">Give it some leeway, sometimes things take a bit longer than normal. Time is in UTC at the moment.</span>
    <label>Days expected</label><br/>

<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox1" value="Every Day" name="days[]"> Every Day
</label><br/>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox1" value="Monday" name="days[]"> Monday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox2" value="Tuesday"  name="days[]"> Tuesday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox3" value="Wednesday"  name="days[]"> Wednesday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox4" value="Thursday"  name="days[]"> Thursday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox5" value="Friday"  name="days[]"> Friday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox6" value="Saturday"  name="days[]"> Saturday
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox7" value="Sunday"  name="days[]"> Sunday
</label>
<br>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox9" value="First day of the month"  name="days[]"> First day of the month
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="inlineCheckbox10" value="Last day of the month"  name="days[]"> Last day of the month
</label>

  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
</div>
