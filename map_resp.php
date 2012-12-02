<!DOCTYPE HTML>
<html>
  <head>
    <title>APP SOCIAL DAL 2012</title>
		<link rel="stylesheet" href="tm/style.css" type="text/css">
		<link rel="stylesheet" href="style.css" type="text/css">
	    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
	    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
	    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
		<style>
		    .olControlAttribution {
		        bottom: 3px;
		    }
		</style>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="css/reset.css" />
<link rel="stylesheet" href="css/text.css" />
<link rel="stylesheet" href="css/960.css" />
<link rel="stylesheet" href="css/style.css" />


		<script>




		$(function() {
		    var comunas = [
		        "Macul",
		        "La Florida",
		        "San Joaquin"
		    ];
		    $( "#tags" ).autocomplete({
		        source: comunas
		    });
		});
		</script>
		<script>


         function cmdNextStep_OnClick() 
        {
//alert(id);
            //sObj = $('#Hd1').val();
            //typ = "2";
            //$.post(sObj, { U: users, T: typ }, function (result) {
            //    $('#DivGridLog').html(result);
            //});

          // $('#DivGridLog').html('<h1>prueba</h1>');



            $("#dia-log").dialog({
                modal: true,
                width: 650,
                height: 485,
                top: 290,
                //buttons: {
                //    Ok: function () {
                //        $(this).dialog("close");
                //    }
                //}
            });
        }



            function cmdStep_OnClick(Et, Ce) 
        {
              typ  = "2";
              sObj = "califica_.php";
              $.post(sObj, {IdC: Ce, Es : Et, Ti : typ }, function (result) {
                $('#dia-log').html(result);
            });

            $("#dia-log").dialog({
                modal: true,
                width: 650,
                height: 485,
                top: 290,
                //buttons: {
                //    Ok: function () {
                //        $(this).dialog("close");
                //    }
                //}
            });
        }


		function distanciaGeo(lat1,lon1,lat2,lon2){
			var radlat1 = Math.PI * lat1/180
			var radlat2 = Math.PI * lat2/180
			var radlon1 = Math.PI * lon1/180
			var radlon2 = Math.PI * lon2/180
			var theta = lon1-lon2
			var radtheta = Math.PI * theta/180
			var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
			dist = Math.acos(dist)
			dist = dist * 180/Math.PI
			dist = dist * 60 * 1.1515
			dist = dist * 1.609344 
			return dist
		}
		//distancia
		console.log(distanciaGeo(-33.446223, -70.660254, -33.421599, -70.665264))
		var imgColor = new Array('ico-geo-green.png','ico-geo-yellow.png','ico-geo-red.png');
		var map = null;
		var popup;
		var markCentros = new Array();
		layerMarkers = new OpenLayers.Layer.Markers("Markers");
		function setMarkerArray(j,lonLat,color,infoDiv){
			//icon
			var size = new OpenLayers.Size(39, 52);
			var offset = new OpenLayers.Pixel(-20, -26);
			var icon = new OpenLayers.Icon('img/icons/'+imgColor[color],size,offset);
			markCentros[j] = new OpenLayers.Marker(lonLat,icon)
		   	var feature = new OpenLayers.Feature(layerMarkers, lonLat);
		    feature.closeBox = false;
		    feature.popupClass = OpenLayers.Class(OpenLayers.Popup.AnchoredBubble, {autoSize : true, border : "1px" });
		    feature.data.popupContentHTML = infoDiv;
		    feature.data.overflow = "hidden";
			markCentros[j].feature = feature;
		    var markerClick = function(evt) {
		        if (popup == null) {
		            popup = this.createPopup(this.closeBox);
		            map.addPopup(popup);
		            popup.show();
		        } else {
		            popup.toggle();
		        }
		        OpenLayers.Event.stop(evt);
		    };
		    markCentros[j].events.register("mousedown", feature, markerClick);
		    layerMarkers.addMarker(markCentros[j]);
		    //circle
		    var epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection 
		    var projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator) 

		}
		//@ cerrar ventana popup
		function closePopUp(){
		    popup.hide();
		}
		function initAllMarkers(){
		    //json data
			$.post("services/restData.php", { "func": "getMarkersAll" },
			function(data){
				for(i=0; i<=data.markers.length-1; i++){
	var lonLat = new OpenLayers.LonLat(parseFloat(data.markers[i].longitud), parseFloat(data.markers[i].latitud)).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
	var divInfo = "<div class='spopup'><b>Tiempo de atencion :</b> "+data.markers[i].tatencion+" hrs.<br />";
	divInfo += "<b>Tiempo de espera :</b>"+data.markers[i].tespera+"<div class='botonPopup'></div>";
	divInfo += "<b>Nombre :</b>"+data.markers[i].nombre+" <input type='button' value='>>'" ;
	divInfo += " onclick='cmdNextStep_OnClick()'></div>";

	setMarkerArray(i,lonLat,(data.markers[i].estado-1),divInfo);
				}
			}, "json");
		}
		function initm(){
		var style = {
		    fillColor: '#000',
		    fillOpacity: 0.1,
		    strokeWidth: 0
		};
		map = new OpenLayers.Map('map');

		var layer = new OpenLayers.Layer.OSM( "Simple OSM Map");
		var vector = new OpenLayers.Layer.Vector('vector');
		var markerMe = null;
		map.addLayers([layer, vector]);
		map.setCenter(
		    new OpenLayers.LonLat(-70.660254, -33.446223).transform(
		        new OpenLayers.Projection("EPSG:4326"),
		        map.getProjectionObject()
		    ), 12
		);
		map.addLayer(layerMarkers);
		var geolocate = new OpenLayers.Control.Geolocate({
		    bind: false,
		    geolocationOptions: {
		        enableHighAccuracy: false,
		        maximumAge: 0,
		        timeout: 7000
		    }
		});
		map.addControl(geolocate);
		var firstGeolocation = true;
		geolocate.events.register("locationupdated",geolocate,function(e) {
		    vector.removeAllFeatures();
			//icon
			var size = new OpenLayers.Size(32, 32);
			var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
			var icon = new OpenLayers.Icon('img/green.png',size,offset);
			var lonLat = new OpenLayers.LonLat( e.position.coords.longitude,e.position.coords.latitude).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
			markerMe = new OpenLayers.Marker(lonLat,icon)
			layerMarkers.addMarker(markerMe);

		    vector.addFeatures([
		        new OpenLayers.Feature.Vector(
		            e.point,
		            {}
		        )
		    ]);
		    if (firstGeolocation) {
		        map.zoomToExtent(vector.getDataExtent());
		        firstGeolocation = false;
		        this.bind = true;
		    }
		});
		geolocate.events.register("locationfailed",this,function() {
		    OpenLayers.Console.log('Location detection failed');
		});
		//nuestra posicion
	    /*vector.removeAllFeatures();
	    geolocate.deactivate();
	    geolocate.watch = false;
	    firstGeolocation = true;
	    geolocate.activate();*/


	    //cargamos centros
		initAllMarkers()
		document.getElementById('locate').onclick = function() {
			if(markerMe != null){
				layerMarkers.removeMarker(markerMe);
			}
		    vector.removeAllFeatures();
		    geolocate.deactivate();
		    geolocate.watch = false;
		    firstGeolocation = true;
		    geolocate.activate();
		};
	}
	</script>
</head>
  <body onload="initm();">
<br><br><br><br>

        <div id="map" class="fullmap">

        </div>

 <input type="image" src="img/ico-ubicame.png" width="50" height="50" name="image" class="locate" id="locate">
 <br>
 <input type="image" src="img/ico-buscar.png" width="50" height="50" name="image" class="locateb" id="Buscar">

       <div id="dia-log" title="Sapu Santa Julia" >
<div id="pop"> 
  
  <div class="estado normal">Normal</div>
  <div class="col1"> <span class="tit">100</span> <span class="txt">personas esperando</span> </div>
  <div class="col2"><span class="tit">2 hrs</span> <span class="txt">de espera aprox</span></div>
    
  <h3>¿Cómo está el servicio ahora?</h3>

  <form id="form1" >
    <input name="normal"  type="button" value="Normal" class="btn_normal"    onclick="cmdStep_OnClick('1','1')" />
    <input name="alto"    type="button" value="Alto" class="btn_alto"          onclick="cmdStep_OnClick('2','1')"/>
    <input name="critico" type="button" value="Crítico" class="btn_critico" onclick="cmdStep_OnClick('3','1')" />
  </form >
    
    <ul class="box_social fRight">
      <li class="tw"><a href="javascript:void(0);" title="Twitter">Twitter</a></li>
      <li class="fb"><a href="javascript:void(0);" title="Facebook">Facebook</a></li>
    </ul>


</div>

       

  </body>
</html>