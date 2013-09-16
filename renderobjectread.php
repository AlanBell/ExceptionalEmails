<?php
//render an object in read mode according to a template
//collection=events&objectid=5235af52f1fd8ff86f8e0122
//the form is going to be the same name as the collection
//we might not want to render all fields on the form
//and some fields might want to be pulled in from other documents by referencing through docrefs
//the form definition is in db.design.forms
//it gets displayed as sensibly as possible in a bootstrap layout
global $mdb,$userRef;
$collection=$_REQUEST['collection'];
$objectid=$_REQUEST['objectid'];

//is the user logged in?

//optionally override the form to display something in several ways
if($_REQUEST['form']){
	$formname=$_REQUEST['form'];
}else{
	$formname=$_REQUEST['collection'];
}
require_once("renderfield.php");
$form=$mdb->design->findOne(array("type"=>"form","form"=>$formname));
//if the form is not found, that should not matter, we just render stuff sensibly
$object=$mdb->selectCollection($collection)->findOne(array('user'=>$userRef,'_id'=>new MongoID($objectid)));//should do a check for $user here, people only see their own stuff
//lets put it in a panel
if ($form){
	//but if there is a form, we render that, inserting field renders as we go
	echo render($form['readlayout'],"Layout",$object);
}else{
//below is a default rendering, just shoving things in a panel
?>
<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title"><?php echo $collection; ?></h3></div>
  <div class="panel-body">
<?php
//if there is no form, we do a straightforward rendering of fieldname/value
foreach($object as $fieldname=>$field){
	$datatype="auto";
?>
  <div class="form-group">
    <label class="col-lg-2 control-label"><?php echo $fieldname; ?></label>
    <div class="col-lg-10">
      <p class="form-control-static"><?php
	echo render($fieldname,$datatype,$object);
//echo $fieldname;
?>&nbsp;</p>
    </div>
  </div>
<?php
}

}
?>
  </div>
</div>
