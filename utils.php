<?php
function renderfield($value){
  //makes a good effort to display a field value, imploding arrays if neccessary
  //other formatting could be added here
  if (is_array($value)){
    return implode($value,",");
  }
  return $value;
}
function exceptionalalert($alert,$type="success"){
  return '<div class="alert alert-'.$type.'"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$alert.'</div>';
}
?>
