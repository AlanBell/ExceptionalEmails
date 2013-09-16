<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
This is a simple chronological list of all emails you got to valid alert addresses. Double click to see the details.
</div>

<?php
require_once("SlickGrid.php");
global $mdb;
$emails= $mdb->emails;
//$cursor=$emails->find(array('user'=>$userRef),array("body"=>0));//body is big and we don't need it
$cursor=$emails->find(array('user'=>$userRef),array("mailto"=>1,"mailfrom"=>1,"subject"=>1,"received"=>1))->sort(array("received"=>-1));//body is big and we don't need it

//here we need a *fast* scrolling huge grid widget as a reusable component
//passing in an array of columns to render (which might as well be passed to the cursor as fields we want)
$columns=array(
	array("id"=>"received",
		"name"=>"Received",
		"field"=>"received",
		"datatype"=>"datetime",
		"minWidth"=>200),
	array("id"=>"subject",
		"name"=>"Subject",
		"field"=>"subject",
		"minWidth"=>400),
	array("id"=>"mailfrom",
		"name"=>"From",
		"field"=>"mailfrom",
		"minWidth"=>300));
echo SlickGrid($cursor,$columns);
?>
