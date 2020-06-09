<?php

require_once('api_controller.php');
require_once('functions.php');

if(isset($_GET['url'])){
	$var = $_GET['url'];
	//print_r($var);

	header('Cache-Control: no-cache, must-revalidate');
	//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	// headers to tell that result is JSON
	header('Content-type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		//echo "GET";

		$id = intval(preg_replace('/[^0-9]+/','', $var),10);
		//print_r($id);

		$filtroFecha = false;
		$fechaInicio = empty ($_GET['fechaInicio']) ? NULL : $_GET['fechaInicio'];
		$fechaFinal = empty ($_GET['fechaFinal']) ? NULL : $_GET['fechaFinal'];
		if($fechaInicio && $fechaFinal){
			if(ValidarFecha($fechaInicio) && ValidarFecha($fechaFinal)){
				$filtroFecha = true;
			}
		}

		switch($var){
			case "temperature";
				if($filtroFecha){
					$resp = GetTemperatureByDate($fechaInicio, $fechaFinal);
					print_r(json_encode($resp));
					http_response_code(200);
				}
				else{
					$resp = GetAllTemperature();
					print_r(json_encode($resp));
					http_response_code(200);
				}
			break;
			case "temperature/$id";
				$resp = GetTemperatureById($id);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "humidity";
				if($filtroFecha){
					$resp = GetHumidityByDate($fechaInicio, $fechaFinal);
					print_r(json_encode($resp));
					http_response_code(200);
				}
				else{
					$resp = GetAllHumidity();
					print_r(json_encode($resp));
					http_response_code(200);
				}
			break;
			case "temperature/$id";
				$resp = GetHumidityById($id);
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "led";
				$resp = GetAllLeds();
				print_r(json_encode($resp));
				http_response_code(200);
				break;
			case "led/$id";
				$resp = GetLedById($id);
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
			switch ($var) {
				case "temperature";
					$estado = SetTemperature($conver);
					if($estado == true){
						print_r("{'OK': 'OK'}");
					}
					else{
						print_r("{'OK': 'Not OK'}");
					}
					http_response_code(200);
					break;
				case "humidity";
					$estado = SetHumidity($conver);
					if($estado == true){
						print_r("{'OK': 'OK'}");
					}
					else{
						print_r("{'OK': 'Not OK'}");
					}
					http_response_code(200);
					break;
				case "led";
					$estado = SetLed($conver);
					if($estado == true){
						print_r("{'OK': 'OK'}");
					}
					else{
						print_r("{'OK': 'Not OK'}");
					}
					http_response_code(200);
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
					POST /temperature
				</code>
				<code>
					<br>
					GET /temperature
					<br>
					GET /temperature/$id
				</code>
			</div>
			<div class="divbody">
				<p>Sensor de Humedad</p>
				<code>
					POST /humidity
				</code>
				<code>
					<br>
					GET /humidity
					<br>
					GET /humidity/$id
				</code>
			</div>
			<div class="divbody">
				<p>LED</p>
				<code>
					POST /led
				</code>
				<code>
					<br>
					GET /led
					<br>
					GET /led/$id
				</code>
			</div>

		</div>
	</body>

<?php
}
?>