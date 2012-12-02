<?php defined( '_VALID_MOS' ) or die( 'Restricted access' ); ?>

<div id="informacion">
	<a href="javascript:$.hideInfo();"><img src="images/img/btn-cerrar.png" /></a>
    <img src="images/img/img-informate.png" />
</div>

	<div id="gracias" class="gracias" style="display:none">
		<a href="javascript:$.graciasClose();" id="btn_cerrar">Cerrar</a>
		<h2>¡Muchas Gracias!</h2>
		<p>Con tu ayuda podemos mejorar al sistema</p>
		<div class="redes_sociales">
		<h4 class="fLeft">Compartir:</h4>
		<ul class="box_social fRight">
		<li class="tw"><a href="javascript:void(0);" title="Twitter">Twitter</a></li>
		<li class="fb"><a href="javascript:void(0);" title="Facebook">Facebook</a></li>
		</ul>
		</div>
	</div>

<div id="header">
	<div class="container_12">
		<h1 class="grid"><a href="/" title="Hopper - Sáltate la cola">Hopper</a></h1>
		<h2 class="grid alpha"><?=($JConfig->alias);?></h2>
		<div class="box grid_5">
			<?php /*?> <a href="javascript:void(0);" class="fRight btn_registrate">Regístrate</a><?php */?> 
			<a href="javascript:$.showInfo();" class="fRight btn_informate">Infórmate</a> 
		</div>
	</div>
</div>