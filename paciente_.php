<?
			include 'conex_.php';

			$IdCentro   = $_POST['IdU'];
			$Estado	    = $_POST['Es'];
			$Box	    = $_POST['Bo'];
			$GenteEsp	= $_POST['Ge'];
			$TiempoEs	= $_POST['Te'];

			$IdPaciente = 1;

 


 $query  = "select * from  Centro where IdCentro = $IdCentro";

 $result = mysql_db_query($dbname, $query, $link);
 $row    = mysql_fetch_array ($result);
 




 //mysql_free_result($result);

if($row[1]=="1")
{
 $est="Normal";
} 

if($row[1]=="2")
{
 $est="Alto";
} 


if($row[1]=="3")
{
 $est="Critico";
} 


  $h .= "<a href='#' id='btn_cerrar' onclick='javascript:cmdCerrar(0);'>Cerrar</a>";
  $h .= "<h2>$row[8]</h2>";
  $h .= "<div class='estado $est'>$est</div>";
  $h .= "<div class='col1'> <span class='tit'>$row[14]</span> <span class='txt'>personas esperando</span> </div>";
  $h .= "<div class='col2'><span class='tit'>$row[15] hrs</span> <span class='txt'>de espera aprox</span></div>";
  $h .= "<div class='clear'></div>";
  $h .= "<hr />";
  $h .= "<h3>¿Cómo está el servicio ahora?</h3>";
  $h .= "<form action='' method='get'>";
  $h .= "  <input name='normal' type='button' value='Normal' class='btn_normal' onclick='cmdCerrar(1);'/>";
  $h .= "  <input name='alto' type='button' value='Alto' class='btn_alto' onclick='cmdCerrar(1);'/>";
  $h .= "  <input name='critico' type='button' value='Crítico' class='btn_critico' onclick='cmdCerrar(1);'/>";
  $h .= "</form>";
  $h .= "<div class='redes_sociales'>";
  $h .="  <h4 class='fLeft'>Compartir:</h4>";
  $h .= "  <ul class='box_social fRight'>";
  $h .= "    <li class='tw'><a href='javascript:void(0);' title='Twitter'>Twitter</a></li>";
  $h .= "    <li class='fb'><a href='javascript:void(0);' title='Facebook'>Facebook</a></li>";
  $h .= "  </ul>";
  $h .= "</div>";


   echo($h);
?>