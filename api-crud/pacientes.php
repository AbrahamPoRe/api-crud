<?php
	require_once 'clases/respuestas.class.php';
	require_once 'clases/pacientes.class.php';

	$_respuestas = new respuestas;
	$_pacientes = new pacientes;

	// GET equivale a READ pero en 
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		if(isset($_GET["page"]))
		{
			$pagina = $_GET["page"];
			$listaPacientes = $_pacientes->listaPacientes($pagina);
			header('Content-Type: application/json');
			echo json_encode($listaPacientes, JSON_PRETTY_PRINT);
			http_response_code(200);
		}
		else if (isset($_GET["id"]))
		{
			$pacienteid = $_GET["id"];
			$datosPaciente = $_pacientes->obtenerPaciente($pacienteid);
			header('Content-Type: application/json');
			echo json_encode($datosPaciente, JSON_PRETTY_PRINT);
			http_response_code(200);
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == "POST") 
	{
		// Se recibe los datos enviados
		$postBody = file_get_contents("php://input");
		// Se envia los datos al manejador
		$datosArray = $_pacientes->post($postBody);
		// Devolvemos una respuesta
		header('Content-Type: application/json');
		if (isset($datosArray["result"]["error_id"]))
		{
			$responseCode = $datosArray["result"]["error_id"];
			http_response_code($responseCode);
		}
		else
		{
			http_response_code(200);
		}
		echo json_encode($datosArray, JSON_PRETTY_PRINT);
	}
	else if($_SERVER['REQUEST_METHOD'] == "PUT")
	{
		// Se recibe los datos enviados
		$postBody = file_get_contents("php://input");
		// Se envia los datos al manejador
		$datosArray = $_pacientes->put($postBody);
		// Devolvemos una respuesta
		header('Content-Type: application/json');
		if (isset($datosArray["result"]["error_id"]))
		{
			$responseCode = $datosArray["result"]["error_id"];
			http_response_code($responseCode);
		}
		else
		{
			http_response_code(200);
		}
		echo json_encode($datosArray, JSON_PRETTY_PRINT);
	}
	else if($_SERVER['REQUEST_METHOD'] == "DELETE")
	{
		// Se recibe los datos enviados
		$postBody = file_get_contents("php://input");
		// Se envia los datos al manejador
		$datosArray = $_pacientes->delete($postBody);
		// Devolvemos una respuesta
		header('Content-Type: application/json');
		if (isset($datosArray["result"]["error_id"]))
		{
			$responseCode = $datosArray["result"]["error_id"];
			http_response_code($responseCode);
		}
		else
		{
			http_response_code(200);
		}
		echo json_encode($datosArray, JSON_PRETTY_PRINT);
	}
	else
	{
		header('Content-Type: application/json');
		$datosArray = $_respuestas->error_405();
		echo json_encode($datosArray, JSON_PRETTY_PRINT);
	}
?>