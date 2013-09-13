<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
This is a fast scrolling list of emails sorted in a few ways, for each day there will be a line for every expected alert, and every email that arrives
if an email arrives in response to an alert then those lines will merge and be a green success (unless it contains indications of a failure)
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
	array("id"=>"worrytime",
		"name"=>"Worry Time",
		"field"=>"mailto",
		"minWidth"=>150),
	array("id"=>"received",
		"name"=>"Received",
		"field"=>"received",
		"datatype"=>"datetime",
		"minWidth"=>150),
	array("id"=>"subject",
		"name"=>"Subject",
		"field"=>"subject",
		"minWidth"=>400),
	array("id"=>"mailfrom",
		"name"=>"From",
		"field"=>"mailfrom",
		"minWidth"=>300));
echo SlickGrid($cursor,$columns);
/*
echo "<table class='table table-striped table-bordered table-hover'>";
//here we iterate through days, and alerts and line them up with received items
//each row gets a success/danger class on it, with warning class on things today that are not due yet
//onclick of a row should open the corresponding email/alert combo
echo "<thead>";
echo "<tr>";
echo "<th>" ."Worry time". "</th>";
echo "<th>" ."Time Received". "</th>";
echo "<th>" ."Subject". "</th>";
echo "<th>" ."Status". "</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
foreach ($cursor as $document){
	$alert=MongoDBRef::get($mdb,$document['alert']);
	echo "<tr><td>";
        echo $alert['worrytime'];//that comes from an alert
	echo "</td><td>";
        $alertid= new MongoId($document['_id']);//that comes from the email
//	echo Date("d/m/Y H:m:s",date($document['received']));
	echo date("d/m/Y H:i:s",$document['received']->sec);
	//the user object should have timezone and date format on it.
	//we should really be writing a real field with the timestamp, not extracting it from the _id
//	$emails->update(array('_id'=>$document['_id']),array('$set'=>array("received"=> new MongoDate($alertid->getTimestamp()))));
	echo "</td><td>";
        echo $document['subject'];
	echo "<td class='success'>". $alert['AlertName'] ."</td>";
	echo "</td></tr>";
}
for($i=0;$i<100;$i++){
echo "<tr><td></td></tr>";
}
echo "</tbody>";
echo "</table>";
*/
?>
