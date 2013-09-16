<?php
function render($fieldname,$datatype,$object){
        global $mdb;
	global $userRef;
        //this allows rendering datatypes in different ways
        //should start with some guesswork
        //we can go off-record using dbref dereferencing, but that can be slow
	if($datatype=="Layout"){
		//probably shouldn't abuse the fieldname to do this, but here we are
		//$datatype is a complex array
		//we recurse down it, leaf nodes may be fields
		//$datatype may be an array, in which case we itterate through it
		//if $datatype is an object then we render it
		$html="";//this will be returned, we might have to build it up a bit first
		if(is_array($fieldname) && ! (bool)count(array_filter(array_keys($fieldname), 'is_string'))){
			//this is not an associative array, we need to render the component parts in sequence
			//this is used for lists of layouts, like fields
			foreach($fieldname as $subunit){
				$html .= render($subunit,"Layout",$object);
			}
		}else{
			//we are working with a layout object
			switch($fieldname['type']){
			case "panel":
				$html .='<div class="panel panel-default">
				  <div class="panel-heading"><h3 class="panel-title">' . render($fieldname['title'],"Layout",$object) .' </h3></div>
				  <div class="panel-body form-horizontal">'. render($fieldname['body'],"Layout",$object).'</div></div>';
				break;
			case "string":
				$html .= $fieldname['content'];
				break;
			default:
				//this is probably some kind of field
				//do we want to render layout fields as bootstrap fields by default?
				//probably not so that we can have unlabled body fields
				switch($fieldname['fieldtype']){
				case "raw":
					$html .= render($fieldname['content'],$fieldname['type'],$object);
					break;
				default:
					$html .= '<div class="form-group"><label class="col-lg-2 control-label">';
					$html .= $fieldname['title'] ? $fieldname['title'] : $fieldname['content'];//should allow for a separate field title to be defined
					$html .= '</label><div class="col-lg-10"><p class="form-control-static">';
					$html .= render($fieldname['content'],$fieldname['type'],$object);
					$html .= '</p></div></div>';
				}
				break;
			}
		}
		return $html;
	}

	//we are not rendering a layout, so it must be a field
        $types=explode("-",$datatype,2);
        $names=explode("-",$fieldname,2);
        if (!$object || ! array_key_exists($names[0],$object)){
                return "~";
        }

        $value=$object[$names[0]];
        switch($types[0]){
        case "datetime":
                //this should go look up the datetime format for the current user
                $date=date($value->sec);
		$user=MongoDBRef::get ( $mdb , $userRef );
                return date($user['dateformat'],$date);
        case "docref":
	        $reldoc=MongoDBRef::get ( $mdb , $value );
		if ($types[1]){
			return render($names[1],$types[1],$reldoc);
                	//this gets the field off the related document and will recursively follow a sequence of document jumps
		}else{
			//this instance the type ends with a docref so we do a link
			return '<a href="?action=object&collection=' .$value['$ref'] . '&objectid=' . $value['$id'] . '">' .$reldoc[$names[1]] . '</a>';
		}
        case "boolean":
        case "booleanYN":
                if($value){
                        return "Yes";
                }else{
                        return "No";
                }
        case "booleanTF":
                if($value){
                        return "True";
                }else{
                        return "False";
                }
	case "email":
		//this is an email body field, which could be multipart mime
		//or a single part mime either html or plain
		if( !(bool)count(array_filter(array_keys($value), 'is_string'))){
			$n=0;
			foreach($value as $partno=>$part){
				//here we go through the parts looking for a text/html one
				//if there isn't one then it will display part[0]
				if ($part['text/html']){$n=$partno;}
			}
			return $value[$n]['text/html'] ?  $value[$n]['text/html'] : '<pre>'. $value[$n]['text/plain'] . '</pre>';
		}else{
			//this is a single part mail, probably text/plain we don't have much alternative but to display whatever it is
			return $value['text/html'] ?  $value['text/html'] : '<pre>' . $value['text/plain'] . '</pre>';
		}
        default:
                //we have not been told what the datatype is, and we couldn't guess
                //if it is an array lets return it with commas, otherwise just return it
                return $value;
        }
}

?>
