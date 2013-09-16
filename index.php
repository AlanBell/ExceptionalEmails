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
        <script src="Socialite/socialite.min.js"></script>
	<link rel="stylesheet" href="Socialite/demo/demo.css">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="jquery.sparkline.min.js"></script>
<!-- Update your html tag to include the itemscope and itemtype attributes. -->
<html itemscope itemtype="http://schema.org/Article">

<!-- Add the following three tags inside head. -->
<meta itemprop="name" content="Exceptional Emails">
<meta itemprop="description" content="Alerts you about the emails you didn't get">
<meta itemprop="image" content="http://libertus.co.uk/images/medium-logo.png">
</head>
<body>
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
	case "confirm":
		include "registerconfirm.php";
		break;
	case "events":
		include "events.php";
		break;
	case "object":
		include "renderobjectread.php";
		break;
	case "tandc":
		include "tandc.php";
		break;
	case "login":
		break;
	case "logout":
		include "logout.php";
		break;
	case "faq":
		include "faq.php";
		break;
	default:
		include "welcome.php";
}



?>
    </div> <!-- /container -->
<?php include "footer.php"; ?>
</body>
</html>
