<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
An event is what happened on a particular date that an alert covers, this shows your daily summary.
</div>

<?php
require_once("SlickGrid.php");
global $mdb;
$events= $mdb->events;
//$cursor=$emails->find(array('user'=>$userRef),array("body"=>0));//body is big and we don't need it
$cursor=$events->find(array('user'=>$userRef),array("worrytime"=>1,"date"=>1,"email"=>1,"user"=>1,"alert"=>1,"complete"=>1,"late"=>1))->sort(array("received"=>-1));//body is big and we don't need it

//here we need a *fast* scrolling huge grid widget as a reusable component
//passing in an array of columns to render (which might as well be passed to the cursor as fields we want)
$columns=array(
        array("id"=>"date",
                "name"=>"Date",
                "field"=>"date",
                "minWidth"=>100),
        array("id"=>"worrytime",
                "name"=>"Worry Time",
                "field"=>"worrytime",
                "datatype"=>"time",
                "minWidth"=>100),
        array("id"=>"alerttitle",
                "name"=>"Alert Title",
                "field"=>"alert-AlertName",
                "datatype"=>"docref-text",
                "minWidth"=>300),
        array("id"=>"complete",
                "name"=>"Completed",
                "field"=>"complete",
                "datatype"=>"boolean",
                "minWidth"=>120),
        array("id"=>"late",
                "name"=>"Late?",
                "field"=>"late",
                "datatype"=>"boolean",
                "minWidth"=>120),
        array("id"=>"received",
                "name"=>"Received",
                "field"=>"email-received",
		"datatype"=>"docref-datetime",
                "minWidth"=>200));
echo SlickGrid($cursor,$columns);
?>

