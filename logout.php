<?php
global $userRef,$mdb;
if($userRef && $_REQUEST['action']=="logout"){
	$id=$userRef['$id']->__tostring();
//	echo "id is $id <br>";
	$mdb->users->update(array("user"=>$userRef,"_id"=>$id),array('$unset'=>array("session"=>"1")));
	unset($userRef);
	// Unset all of the session variables.
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	session_destroy();
	include "welcome.php";
}

// Finally, destroy the session.
?>

