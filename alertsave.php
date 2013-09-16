<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<?php
//
global $mdb,$userRef;
$alerts=$mdb->selectCollection("alerts");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $alert=$_POST;
  $alert['user']=$userRef;
  $alerts->insert($alert);
}else{
  //not a post, probably a get with a pause or delete request on it
  //should make this more RESTful really
  if ($_GET['delete']){
    //echo "deleting " . $_GET['delete'];
    //should probably not actually delete the alert
    //need to check to see if it is an alert owned by user
    $alerts->remove(array("user"=>$userRef,"_id"=>new MongoId($_GET['delete'])));
    echo exceptionalalert("Deleted","warning");
  }elseif($_GET['pause']){
//    echo "pausing " . $_GET['pause'];
    $alerts->update(array("user"=>$userRef,"_id"=>new MongoId($_GET['pause'])),array('$set'=>array("pause"=>"1")));
  }elseif($_GET['play']){
    $alerts->update(array("user"=>$userRef,"_id"=>new MongoId($_GET['play'])),array('$set'=>array("pause"=>"")));
  }else{
  }

}
//if something failed we can let the user know
include "expectedemails.php";
?>
