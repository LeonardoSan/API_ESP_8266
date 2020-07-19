<?php

require_once("db_manager.php");

function ValidateToken($Id_Dispositivo){
	$query = "SELECT * FROM token WHERE Id_Dispositivo = '$Id_Dispositivo'";
	$respuesta = Select($query);
	return ConvertirUTF8($respuesta);
}

function GetAllData($table){
	$query = "SELECT * FROM $table ORDER BY Fecha DESC LIMIT 1000";
	$respuesta = Select($query);
	return ConvertirUTF8($respuesta);
}

function GetDataByDate($table, $idDispositivo, $initialDate, $finalDate){
	$query = "SELECT * FROM $table WHERE Fecha >= '$initialDate 00:00:00' AND Fecha <= '$finalDate 23:59:59' AND Id_Dispositivo = '$idDispositivo' ORDER BY Fecha ASC";
	$respuesta = Select($query);

	$hoursArray = array();
	foreach ($respuesta as $row) {
		$fecha = strtotime($row["Fecha"]);
		$anio = date("Y", $fecha);
		$mes = date("m", $fecha);
		$dia = date("d", $fecha);
		$hora = date("H", $fecha);
		
		if(!array_key_exists($anio.$mes.$dia.$hora, $hoursArray)){
			$hoursArray[$anio.$mes.$dia.$hora] = array();
		}
		array_push($hoursArray[$anio.$mes.$dia.$hora], array("date"=> $row["Fecha"], "value" => $row["Valor"], "key" => $anio."-".$mes."-".$dia." ".$hora));
	}

	$hoursArrayProm = array();
	$sum = 0;
	$prom = 0;
	$long = 0;
	foreach ($hoursArray as $key => $value) {
		$sum = 0;
		$long = count($hoursArray[$key]);
		$newkey = "";
		foreach ($hoursArray[$key] as $valor) {
			$sum += $valor["value"];
			$newkey = $valor["key"];
		}
		$prom = $sum / $long;
		array_push($hoursArrayProm, array("name" => $newkey, "value" => round($prom)));
	}

	return ConvertirUTF8($hoursArrayProm);
}

function GetDataById($table, $id){
	$query = "SELECT * FROM $table WHERE Id = $id";
	$respuesta = Select($query);
	return ConvertirUTF8($respuesta);
}

function SetData($table, $array){

	if(isset($array['Valor']) && isset($array['Lugar']) && isset($array['Id_Dispositivo']) && isset($array['Id_Dispositivo']) && isset($array['Red']) && isset($array['Ip']) && isset($array['Key'])){
		$Valor = $array['Valor'];
		$Lugar = $array['Lugar'];
		$Id_Dispositivo = $array['Id_Dispositivo'];
		$Red = $array['Red'];
		$Ip = $array['Ip'];
		$Key = $array['Key'];

		//Convert from UTC to TZ Colombia
		//SELECT CONVERT_TZ(NOW(),'+0:00','-5:00')
		//SELECT CONVERT_TZ(NOW(),@@session.time_zone,'-5:00')

		if($Key != "" && $Valor != "" && $Lugar != "" && $Id_Dispositivo != "" && $Red != "" && $Ip != ""){

			$token = ValidateToken($Id_Dispositivo);

			if(count($token) > 0){
				$valorToken = $token[0]["token"];

				if($Key == $valorToken){
					$query = "INSERT INTO $table (Valor, Lugar, Id_Dispositivo, Red, Ip, Fecha) VALUES ('$Valor', '$Lugar', '$Id_Dispositivo', '$Red', '$Ip', (SELECT CONVERT_TZ(NOW(),@@session.time_zone,'-5:00')))";
					Insert($query);
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	else{
		//falto algo
		return false;
	}
}

function SetLedById($array, $id){
	if(isset($array['Valor']) && isset($array['Lugar']) && isset($array['Id_Dispositivo']) && isset($array['Id_Dispositivo']) && isset($array['Red']) && isset($array['Ip']) && isset($array['Key'])){
		$Valor = $array['Valor'];
		$Lugar = $array['Lugar'];
		$Id_Dispositivo = $array['Id_Dispositivo'];
		$Red = $array['Red'];
		$Ip = $array['Ip'];
		$Key = $array['Key'];

		if($Key != "" && $Valor != "" && $Lugar != "" && $Id_Dispositivo != "" && $Red != "" && $Ip != ""){

			$token = ValidateToken($Id_Dispositivo);

					if(count($token) > 0){
						$valorToken = $token[0]["token"];

						if($Key == $valorToken){
							if($Valor == "true" || $Valor == "false" || $Valor == "1" || $Valor == "0"){
								$query = "UPDATE led SET Valor = $Valor, Lugar = '$Lugar', Id_Dispositivo = '$Id_Dispositivo', Red = '$Red', Ip = '$Ip', Fecha = (SELECT CONVERT_TZ(NOW(),@@session.time_zone,'-5:00')) WHERE Id = $id";
								// return $query;
								Insert($query);
								return true;
							}
							else{
								return false;
							}
						}
						else{
							return false;
						}
					}
					else{
						return false;
					}
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}
?>