<?php
	include('vendor/autoload.php');

	$response = new \Alexa\Response\Response;
	$response->respond('Cooool. I\'ll lower the temperature a bit for you!')
    		->withCard('Temperature decreased by 2 degrees');

	header('Content-Type: application/json');
	echo json_encode($response->render());
	exit;
