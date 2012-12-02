
<?php 
	
			include 'conex_.php';

			$IdCentro   = $_GET['IdC'];
			$Estado	    = $_GET['Es'];
			$Box	    = $_GET['Bo'];
			$GenteEsp	= $_GET['Ge'];
			$TiempoEs	= $_GET['Te'];

			$IdPaciente = 1;




			 $query  = "";

			if($Estado != Null && $Estado=="1")
			{
				   $query  = "INSERT INTO `ocl_hopper`.`Atencion_Paciente` (`IdUsuario`, `IdCentro`, `Estado`, `Registro`) VALUES ('$IdPaciente', '$IdCentro', '$Estado', NOW());";
				   $result=mysql_db_query($dbname, $query, $link);
				   // $row = mysql_fetch_array ($result)
					//mysql_free_result($result);

					echo($query);
			}

			if($Estado != Null && $Estado=="2")
			{
					$query  += "INSERT INTO `ocl_hopper`.`Atencion_Prestador` ( ";
					$query  += "`IdUsuario` , ";
					$query  += "`IdCentro` , ";
					$query  += "`Estado` , ";
					$query  += "`Registro` , ";
					$query  += "`Box` , ";
					$query  += "`GenteEspera` , ";
					$query  += "`TiempoEspera` ";
					$query  += ") ";
					$query  += "VALUES ( ";
					$query  += "'$IdPaciente', '$IdCentro','$Estado', 'now()', '$Box', '$GenteEsp', '$TiempoEs'); ";

				    $result=mysql_db_query($dbname, $query, $link);
					


					
					$query   = " SELECT sum( box ) , sum( GenteEspera ) , tiempoEspera "
					$query  += " FROM `Atencion_Prestador` "
					$query  += " WHERE DATE_SUB( CURDATE( ) , INTERVAL 3 "
					$query  += " DAY ) <= registro "
					$query  += " AND idcentro =1 "

					$result=mysql_db_query($dbname, $query, $link);
					echo($query);

			}


?>



?>