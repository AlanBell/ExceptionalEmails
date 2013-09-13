<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<?php
echo "thanks for registering . . . ";
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
        'hash' => $hash
    );
$users->insert($user);
}
?>
