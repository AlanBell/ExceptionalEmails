<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<div class="panel panel-info">
<div class="panel-heading">
    <h3 class="panel-title">Checking your code . . .</h3>
</div>
<?php
$confirmation=$_GET['key'];
echo "<h3>Looking up confirmation code $confirmation</h3>";
global $mdb;
$users=$mdb->selectCollection("users");
$user=$users->findone(array("confirm"=>$confirmation));
if ($user){
	echo "Yay, found you ". $user['email'];
	$users->update(array("_id"=>$user['_id']),array('$unset'=>array("confirm"=>"")));
	echo ". You should now be able to log in to the site using the form below";
	include "loginform.php";
}else{
	echo "Boo, something went wrong. You might have already confirmed, or you are using an invalid key. Try loging on with the password from your registration form, or try registering again.";
}
?>
</div>
