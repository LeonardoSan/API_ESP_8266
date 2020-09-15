<?php

// $server = "127.0.0.1";
// $user = "root";
// $pswd = "";
// $database = "domosoft";
// $port = "3306";

$server = "localhost";
$user = "u762870467_domosoft";
$pswd = "/cNh#z_yj4w=unza";
$database = "u762870467_domosoft";
$port = "3306";


//String de conexión

$conexion = new mysqli($server, $user, $pswd, $database, $port);

if($conexion -> connect_errno){
	die($conexion -> connect_error);
}

//Guardar, modificar, eliminar

function Insert($sqlstr, &$conexion = null){
	if(!$conexion)global $conexion;

	$result = $conexion -> query($sqlstr);
	return $conexion -> affected_rows;
}


//Select

function Select($sqlstr, &$conexion = null){
	if(!$conexion)global $conexion;

	$result = $conexion -> query($sqlstr);
	$resultArray = array();
	foreach ($result as $registros) {
		$resultArray[] = $registros;
	}
	return $resultArray;
}

//UTF-8

function ConvertirUTF8($array){
	array_walk_recursive($array, function(&$item, $key){
		if(!mb_detect_encoding($item, 'utf-8', true)){
			$item = utf8_encode($item);
		}
	});
	return $array;
}

?>