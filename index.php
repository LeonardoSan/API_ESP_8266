<?php

require_once('api_controller.php');
require_once('functions.php');

if(isset($_GET['url'])){
	$resource = $_GET['url'];

	header('Cache-Control: no-cache, must-revalidate');
	//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	// headers to tell that result is JSON
	header('Content-type: application/json; charset=utf-8');
	// header('Access-Control-Allow-Origin: *');
	// header("Access-Control-Allow-Headers: *");
	// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	$id = intval(preg_replace('/[^0-9]+/','', $resource),10);

	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		//echo "GET";
		//print_r($id);

		$filtroFecha = false;
		$fechaInicio = empty ($_GET['fechaInicio']) ? NULL : $_GET['fechaInicio'];
		$fechaFinal = empty ($_GET['fechaFinal']) ? NULL : $_GET['fechaFinal'];
		$idDispositivo = empty($_GET['idDispositivo']) ? NULL: $_GET['idDispositivo'];
		if($fechaInicio && $fechaFinal){
			if(ValidarFecha($fechaInicio) && ValidarFecha($fechaFinal)){
				$filtroFecha = true;
			}
		}

		switch($resource){
			case "temperatura";
				if($filtroFecha && $idDispositivo != NULL){
					$resp = GetDataByDate($resource, $idDispositivo, $fechaInicio, $fechaFinal);
					print_r(json_encode($resp));
					http_response_code(200);
				}
				else{
					$resp = GetAllData($resource);
					print_r(json_encode($resp));
					http_response_code(200);
				}
			break;
			case "temperatura/$id";
				$resp = GetDataById($resource, $id);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "humedad";
				if($filtroFecha){
					$resp = GetDataByDate($resource, $fechaInicio, $fechaFinal);
					print_r(json_encode($resp));
					http_response_code(200);
				}
				else{
					$resp = GetAllData($resource);
					print_r(json_encode($resp));
					http_response_code(200);
				}
			break;
			case "humedad/$id";
				$resp = GetDataById($resource, $id);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "calor";
				if($filtroFecha){
					$resp = GetDataByDate($resource, $fechaInicio, $fechaFinal);
					print_r(json_encode($resp));
					http_response_code(200);
				}
				else{
					$resp = GetAllData($resource);
					print_r(json_encode($resp));
					http_response_code(200);
				}
			break;
			case "calor/$id";
				$resp = GetDataById($resource, $id);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "humedad_terrestre";
				if($filtroFecha){
					$resp = GetDataByDate($resource, $fechaInicio, $fechaFinal);
					print_r(json_encode($resp));
					http_response_code(200);
				}
				else{
					$resp = GetAllData($resource);
					print_r(json_encode($resp));
					http_response_code(200);
				}
			break;
			case "humedad_terrestre/$id";
				$resp = GetDataById($resource, $id);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "fotoresistencia";
				if($filtroFecha){
					$resp = GetDataByDate($resource, $fechaInicio, $fechaFinal);
					print_r(json_encode($resp));
					http_response_code(200);
				}
				else{
					$resp = GetAllData($resource);
					print_r(json_encode($resp));
					http_response_code(200);
				}
			break;
			case "fotoresistencia/$id";
				$resp = GetDataById($resource, $id);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "led";
				$resp = GetAllData($resource);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "led/$id";
				$resp = GetDataById($resource, $id);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			default;
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$postBody = file_get_contents("php://input");

		$conver = json_decode($postBody, true);

		if(json_last_error() == 0){
			switch ($resource) {
				case "temperatura";
					$estado = SetData($resource, $conver);
					if($estado == true){
						$resp = array("OK" => "OK");
						print_r(json_encode($resp));
					}
					else{
						$resp = array("OK" => "Not OK");
						print_r(json_encode($resp));
					}
					http_response_code(200);
					break;
				case "humedad";
					$estado = SetData($resource, $conver);
					if($estado == true){
						$resp = array("OK" => "OK");
						print_r(json_encode($resp));
					}
					else{
						$resp = array("OK" => "Not OK");
						print_r(json_encode($resp));
					}
					http_response_code(200);
					break;
				case "calor";
					$estado = SetData($resource, $conver);
					if($estado == true){
						$resp = array("OK" => "OK");
						print_r(json_encode($resp));
					}
					else{
						$resp = array("OK" => "Not OK");
						print_r(json_encode($resp));
					}
					http_response_code(200);
					break;
				case "humedad_terrestre";
					$estado = SetData($resource, $conver);
					if($estado == true){
						$resp = array("OK" => "OK");
						print_r(json_encode($resp));
					}
					else{
						$resp = array("OK" => "Not OK");
						print_r(json_encode($resp));
					}
					http_response_code(200);
					break;
				case "fotoresistencia";
					$estado = SetData($resource, $conver);
					if($estado == true){
						$resp = array("OK" => "OK");
						print_r(json_encode($resp));
					}
					else{
						$resp = array("OK" => "Not OK");
						print_r(json_encode($resp));
					}
					http_response_code(200);
					break;
				case "led";
					$estado = SetData($resource, $conver);
					if($estado == true){
						$resp = array("OK" => "OK");
						print_r(json_encode($resp));
					}
					else{
						$resp = array("OK" => "Not OK");
						print_r(json_encode($resp));
					}
					http_response_code(200);
					break;
				case "led/$id";
					$estado = SetLedById($conver, $id);
					if($estado == true){
						$resp = array("OK" => "OK");
						print_r(json_encode($resp));
					}
					else{
						$resp = array("OK" => "Not OK");
						print_r(json_encode($resp));
					}
					http_response_code(200);
					break;
					break;
				default;
			}

		}
		else{
			http_response_code(400);
		}
	}
	else{
		http_response_code(405);
	}
}
else{?>
	<head>
	</head>
	<body>
		<div class="container">
			<h1>API DomoSoft IoT</h1>
			<div class="divbody">
				<p>Sensor de Temperatura</p>
				<code>
					<br>
					GET /temperatura
					<br>
					GET /temperatura/$id
				</code>
				<br>
				<code>
					POST /temperatura
				</code>
			</div>
			<div class="divbody">
				<p>Sensor de Humedad</p>
				<code>
					<br>
					GET /humedad
					<br>
					GET /humedad/$id
				</code>
				<br>
				<code>
					POST /humedad
				</code>
			</div>
			<div class="divbody">
				<p>Sensor de Sensación de Calor</p>
				<code>
					<br>
					GET /calor
					<br>
					GET /calor/$id
				</code>
				<br>
				<code>
					POST /calor
				</code>
			</div>
			<div class="divbody">
				<p>Sensor de Humedad Terrestre</p>
				<code>
					<br>
					GET /humedad_terrestre
					<br>
					GET /humedad_terrestre/$id
				</code>
				<br>
				<code>
					POST /humedad_terrestre
				</code>
			</div>
			<div class="divbody">
				<p>Sensor de Fotoresistencia</p>
				<code>
					<br>
					GET /fotoresistencia
					<br>
					GET /fotoresistencia/$id
				</code>
				<br>
				<code>
					POST /fotoresistencia
				</code>
			</div>
			<div class="divbody">
				<p>LED</p>
				<code>
					<br>
					GET /led
					<br>
					GET /led/$id
				</code>
				<br>
				<code>
					POST /led
					<br>
					POST /led/$id
				</code>
			</div>

		</div>
	</body>

<?php
}
?>