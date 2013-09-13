<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<?php
function render($datatype,$value){
	//this allows rendering datatypes in different ways
	//should start with some guesswork
	switch($datatype){
	case "datetime":
		//this should go look up the datetime format for the current user
		$date=date($value->sec);
		return date("d/m/Y H:i:s",$date);
	default:
		//we have not been told what the datatype is, and we couldn't guess
		//if it is an array lets return it with commas, otherwise just return it
		return $value;
	}
}
function SlickGrid($cursor,$columns){
	$htmlout = '';
//	$htmlout = 'grid size is ' . $cursor->count();
	$htmlout .= '<div id="myGrid" style="height:600px;" class="panel panel-default"></div>';
        $htmlout .= '<link rel="stylesheet" href="SlickGrid/slick.grid.css" type="text/css"/>';
        $htmlout .= '<link rel="stylesheet" href="slickbootstrap.css" type="text/css"/>';
        $htmlout .= '<link rel="stylesheet" href="SlickGrid/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>';
        $htmlout .= '<script src="SlickGrid/lib/jquery.event.drag-2.2.js"></script>';
        $htmlout .= '<script src="SlickGrid/slick.core.js"></script>';
        $htmlout .= '<script src="SlickGrid/slick.grid.js"></script>';
//now we put in the HTML for populating the grid from the cursor
//this isn't ajaxy at the moment, we fling *all* the data in the cursor to the browser
//but use slickgrid to render it without exploding

       $htmlout .= '<script>
  var grid;
  var columns = '.json_encode($columns).'
  var options = {
    enableCellNavigation: true,
    enableColumnReorder: false
  };

  $(function () {
    var data = [];
';
//back to php
$i=0;
foreach($cursor as $row){
	//iterate through the columns of this row
	$htmlout.="data[$i]={";
	foreach($columns as $col){
		$field=$col['field'];
		$value=render($col['datatype'],$row[$field]);
		$htmlout.="$field : \"".$value . "\",";
	}
	$htmlout.="}\n";
	$i++;
}
//and resuming javascript
//slightly funky sequence, we make the grid in a div then attach it to the DOM
//this means the column headings line up with the contents
//due to some conflict with bootstrap perhaps?
	$htmlout .='
  var options = {
    enableCellNavigation: true,
    enableColumnReorder: false,
  };
//automatically expand it relative to something? or to a parameter passed in?
//  $("#myGrid").css({"height":(($(document).height())-180)+"px"});
  grid = new Slick.Grid("#myGrid", data, columns,options);

  })
</script>';

	return "$htmlout";
}
?>
