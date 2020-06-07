<?php
function ValidarFecha($fecha){
	date_default_timezone_set("America/Mexico_City");
    //$fecha_actual = strtotime(date("Y-m-d H:i:s"));
    $fecha_parametro = strtotime($fecha);

    if($fecha_parametro != ""){
    	// if($fecha_actual > $fecha_parametro){
	    //     return true;
	    // } else{
	    //     return false;
	    // }
	    return true;
    }
    else{
    	return false;
    }
}
?>