<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
Here you can define what emails you expect to get each day, what days they should come on, what time you would be worried if they don't turn up and what to do
about it if they are wrong or don't arrive.
</div>

<script language="javascript">
function alertpause(id){
	//window.alert(id);
	location.search="action=alertsave"+"&pause=" +id;
}
function alertplay(id){
	//window.alert(id);
	location.search="action=alertsave"+"&play=" +id;
}
function alertdelete(id){
	//window.alert(id);
	location.search="action=alertsave"+"&delete=" +id;
}
</script>
<?php
global $mdb,$userRef;
$alerts= $mdb->alerts;



$cursor=$alerts->find(array('user'=>$userRef),array());
echo "<table class='table table-striped table-bordered table-hover'>";
//here we iterate through days, and alerts and line them up with received items
//each row gets a success/danger class on it, with warning class on things today that are not due yet
//onclick of a row should open the corresponding email/alert combo
echo "<thead>";
echo "<tr>";
echo "<th>" ."Alert". "</th>";
echo "<th>" ."Worry time". "</th>";
echo "<th>" ."Subject". "</th>";
echo "<th>" ."Good Words". "</th>";
echo "<th>" ."Bad Words". "</th>";
echo "<th>" ."Days". "</th>";
echo "<th>" ."Action". "</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
foreach ($cursor as $alert){
	$id=$alert['_id'];
        $paused=$alert['pause'];
        if ($paused){
		echo "<tr class='warning'>";
	}else{
		echo"<tr>";
	}
	echo "<td>";
        echo $alert['emailslug'];
        echo "</td><td>";
        echo $alert['worrytime'];
        echo "</td><td>";
        echo $alert['AlertName'];
        echo "</td><td>";
        echo $alert['goodregex'];
        echo "</td><td>";
        echo $alert['badregex'];
        echo "</td><td>";
        echo renderfield($alert['days']);
        echo "</td><td>";
        if ($paused){
	        echo '<button type="button" class="btn btn-default btn-xs" onclick="alertplay(\''.$id.'\');"><span class="glyphicon glyphicon-play"></span>Play</button>';
	}else{
	        echo '<button type="button" class="btn btn-default btn-xs" onclick="alertpause(\''.$id.'\');"><span class="glyphicon glyphicon-pause"></span>Pause</button>';
	}

        echo '<button type="button" class="btn btn-default btn-xs" onclick="alertdelete(\''.$id.'\');"><span class="glyphicon glyphicon-trash"></span>Delete</button>';
        echo "</td></tr>\n";
}

echo "</tbody>";
echo "</table>";
?>
<div class="row">
<div class="col-md-10 col-md-offset-1">
<?php include "alertform.php";?>
</div>
</div>


