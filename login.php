<?php
//this displays the login form or processes a login comparing the hash against the stored hash
global $userid;
global $userref;

//is there a mongo user id in the $_SESSION
//if there is then cool, that is our $userref if the session id matches that users current sessionid
//if not then have they just given us a username and password to compare against the hash?
$user=$mdb->users->findone(array("session"=>session_id()));
if ($user){
	//there is a session and we found the corresponding user
	$userRef = MongoDBRef::create("users", $user['_id']);
//	echo print_r($user);
}else{
	if ($_SERVER['REQUEST_METHOD'] == "POST" && $_REQUEST['action']=="login") {
		$email=$_POST['email'];
		$pass=$_POST['password'];
		$user=$mdb->users->findone(array("email"=>$email,"confirm"=>array('$exists'=>false)));
		//compare the provided password against the hash
		if ($user && $user['hash']==crypt($pass,$user['hash'])){
//			echo "password OK";
			//update the sessionid on the user object
			$user['session']=session_id();
			$mdb->users->save($user);
			$userRef = MongoDBRef::create("users", $user['_id']);
			include "expectedemails.php";
		}else{
			//just let the page carry on really
			?><div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			You didn't successfully log in, maybe your password is wrong or maybe you have not activated your account.
			</div>
			<?php
		}
	}
}
?>
