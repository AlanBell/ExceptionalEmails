<?php
global $mdb;
$m = new MongoClient(); // connect to the back end database
$mdb = $m->selectDB("exceptionalemails");
$emails=$mdb->emails;
$cursor=$emails->find();
echo $cursor->count();

for($i=0;$i<1000000;$i++){
$email=array( "mailfrom" => "alanbell@fgermany.libertus.co.uk",
"mailto" => "alanbell+fgermany@exceptionalemails.com",
"subject" => "findme",
 "user" => MongoDBRef::create("users", new MongoId("522fa201efa7b229793eadbe")) );
	$emails->insert($email);
}


?>
