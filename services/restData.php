<?php
include 'config.php';
//config response request
$func = $_POST['func'];
$response =  array();
//functions
if($func == 'getMarkersAll'){



	$query = mysql_query("SELECT IdCentro, Latitud, Longitud, Nombre, Comuna, TiempoAtencion, TiempoEspera, Estado FROM  `Centro`");
	$marks = array();
	$i = 0;
	while($fila = mysql_fetch_array($query)){

		$marks[$i]['IdCentro'] = $fila['IdCentro'];
		$marks[$i]['latitud'] = $fila['Latitud'];
		$marks[$i]['longitud'] = $fila['Longitud'];
		$marks[$i]['nombre'] = $fila['Nombre'];
		$marks[$i]['comuna'] = $fila['Comuna'];
		$marks[$i]['tatencion'] = $fila['TiempoAtencion'];
		$marks[$i]['tespera'] = $fila['TiempoEspera'];
		$marks[$i++]['estado'] = $fila['Estado'];
	}
	$response['markers'] = $marks;
}
//final response
echo json_encode($response); 
?>