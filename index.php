<?php
session_start();
header('Content-Type: text/html; charset=en_GB');
define("_EXCEPTIONAL",1);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Exceptional Emails</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="jquery.sparkline.min.js"></script>
</head>
<body>
<div style="position:absolute;right:20px;z-index:1;pointer-events: none;">
<img src="beta.png" width="200px"/>
</div>
    <div class="container">



<?php
//the exceptional emails UI attempt without a framework or CMS to get in the way
include "utils.php";
include "header.php";
global $mdb;
$m = new MongoClient(); // connect to the back end database
$mdb = $m->selectDB("exceptionalemails");
//bit of error handling if the database is MIA

//is there a session open?
//if there isn't we display welcome and registration page
//we get the user id associated with the session
global $userid;
global $userRef;

include "login.php";
include "logout.php";

include "menu.php";//the menu is different for logged in users

//what command has been passed on the query string?
//

$action = '';
if(isset($_REQUEST['action']))
{
        $action = $_REQUEST['action'];
}

switch($action){
	case "dashboard":
		include "dashboard.php";
		break;
	case "expected":
		include "expectedemails.php";
		break;
	case "received":
		include "receivedemails.php";
		break;
	case "register":
		include "register.php";
		break;
	case "registersave":
		include "registersave.php";
		break;
	case "alertsave":
		include "alertsave.php";
		break;
	case "login":
		break;
	case "logout":
		include "logout.php";
		break;
	default:
		include "welcome.php";
}



?>
    </div> <!-- /container -->
<?php include "footer.php"; ?>
</body>
</html>
