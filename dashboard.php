<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
This page will give you an overview of your email alerts and the status they were in
last time they were expected. We will probably add pretty graphs of past performance here.
Maybe some sparklines.
</div>
<table class="table">
<?php
global $mdb;
$alerts= $mdb->alerts;
//$cursor=$alerts->find(array('mailto'=>array('$regex' => 'alanbell\+flondon')),array("body"=>0));//body is big and we don't need it
$cursor=$alerts->find(array('user'=>$userRef),array());
echo "<table class='table table-striped table-bordered table-hover'>";
//here we iterate through days, and alerts and line them up with received items
//each row gets a success/danger class on it, with warning class on things today that are not due yet
//onclick of a row should open the corresponding email/alert combo
echo "<thead>";
echo "<tr>";
echo "<th>" ."Alert". "</th>";
echo "<th>" ."Last time". "</th>";
echo "<th>" ."Status". "</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
foreach ($cursor as $document){
        echo "<tr><td>";
        echo $document['AlertName'];
        echo "</td><td>";
        echo $document['worrytime'];
        echo '</td><td>';
        echo $document['subject'];
        echo '<span class="sparkbar">-3,1,2,0,3,-1</span>';
        echo "</td></tr>";
}
echo "</tbody>";

echo "</table>";

?>
