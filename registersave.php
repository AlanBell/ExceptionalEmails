<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<?php
//
if ($_SERVER['REQUEST_METHOD'] == "POST") {
//we will use password_hash, but not yet on 5.5 server
//echo password_hash($_POST['password']);
$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
$hash=crypt($_POST['password'],'$2y$12$'.$salt);
   //we now need to save a user object to mongodb
/*   foreach ($_POST as $key => $value) { 
      echo ucfirst ($key) ." : ". $value . "<br>"; 
   }
*/
global $mdb;
$users=$mdb->selectCollection("users");
    $user=array(
        'email' => $_POST['email'],
        'username'=> $_POST['username'],
        'hash' => $hash,
        'maxalerts'=>3,
        'confirm'=>substr(md5(uniqid()), 0, 8)
    );
try{
	$users->insert($user);
$to=$_POST['email'];
$subject="Confirm your registration at Exceptionalemails.com";
$message="Thanks for registering, please ";
$message .= 'click here http://exceptionalemails.com/?action=confirm&key=' . $user['confirm'] . ' to activate your acccount.';
$headers = 'From: exceptional@exceptionalemails.com' . "\r\n" .
    'Reply-To: nobody' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
mail ( $to , $subject , $message,$headers );

echo '<div class="alert alert-success">';

echo "Thanks for registering, we just sent an email to ";
echo $_POST['email'];
echo ", there is a link in the mail that you need to click to activate your account.";
echo "You know the drill.";
echo "</div>";

}catch(MongoCursorException $e){
?>
<div class="alert alert-danger">
Registration failed, maybe that email address or username has already been used, do try again.
</div>
<?php
include "registerform.php";
}
//now send them a magic link to click to activate their account


}
?>
