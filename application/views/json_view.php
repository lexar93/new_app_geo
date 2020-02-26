<?php
	/*
	VISTA QUE RETORNA UN OBJETO JSON CON LOS DATOS QUE CONTIENE LA VARIABLE $data;
	*/
	header('Content-type: application/json');
	echo json_encode($data);
?>