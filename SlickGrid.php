<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<?php
require_once("renderfield.php");
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
$collectioninfo=$cursor->info();
$collection=explode(".",$collectioninfo["ns"]);
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
	$htmlout.="\"_id\" : \"" . $row['_id'] . "\",";

	foreach($columns as $col){
		$field=$col['field'];
		$datatype=$col['datatype'];
		$value=render($field,$datatype,$row);
		$htmlout.="\"$field\" : \"".$value . "\",";
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
    forceFitColumns:true,
  };
//automatically expand it relative to something? or to a parameter passed in?
//  $("#myGrid").css({"height":(($(document).height())-180)+"px"});
  grid = new Slick.Grid("#myGrid", data, columns,options);
  grid.onDblClick.subscribe(function (e) {
      var cell = grid.getCellFromEvent(e);
      //window.alert(data[cell.row]["_id"]);
      var objid=data[cell.row]["_id"];
      window.location="?action=object&collection=' . $collection[1] . '&objectid=" + objid;
      e.stopPropagation();
    });

  })
</script>';

	return "$htmlout";
}
?>
