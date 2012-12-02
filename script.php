	
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


         function cmdCerrar(tipo)
         {

                  $.closeInfo();
         }

         function cmdNextStep_OnClick(id) 
        {

            
            $.post("paciente_.php", { IdU: id, T: "2" }, function (result) {
               $.loadInfo(result,id);
infoHide();
            });
			
/*

    h="";
         h += "<a href='#' id='btn_cerrar' onclick='javascript:cmdCerrar(0);'>Cerrar</a>";
  h += "<h2>Sapu Santa Julia</h2>";
  h += "<div class='estado normal'>Normal</div>";
  h += "<div class='col1'> <span class='tit'>100</span> <span class='txt'>personas esperando</span> </div>";
  h += "<div class='col2'><span class='tit'>2 hrs</span> <span class='txt'>de espera aprox</span></div>";
  h += "<div class='clear'></div>";
  h += "<hr />";
  h += "<h3>¿Cómo está el servicio ahora?</h3>";
  h += "<form action='' method='get'>";
  h += "  <input name='normal' type='button' value='Normal' class='btn_normal' onclick='cmdCerrar(1);'/>";
  h += "  <input name='alto' type='button' value='Alto' class='btn_alto' onclick='cmdCerrar(1);'/>";
  h += "  <input name='critico' type='button' value='Crítico' class='btn_critico' onclick='cmdCerrar(1);'/>";
  h += "</form>";
  h += "<div class='redes_sociales'>";
  h +="  <h4 class='fLeft'>Compartir:</h4>";
  h += "  <ul class='box_social fRight'>";
  h += "    <li class='tw'><a href='javascript:void(0);' title='Twitter'>Twitter</a></li>";
  h += "    <li class='fb'><a href='javascript:void(0);' title='Facebook'>Facebook</a></li>";
  h += "  </ul>";
  h += "</div>";
  */

           
        }
         
	function infoHide(){
for(var i=0;i<featureCentros.length;i++){
if(featureCentros[i].popup)
featureCentros[i].popup.hide()
}
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
		
		var imgColor = new Array('ico-geo-green.png','ico-geo-yellow.png','ico-geo-red.png');
		var map = null;
		var popup = new Array();
		var markCentros = new Array();
		var featureCentros = new Array();
		var markerClick = new Array();
		layerMarkers = new OpenLayers.Layer.Markers("Markers");
		var markColorCentros = new Array();



		function filterMarks(c){
		for(var i=0;i<markColorCentros.length;i++){
				if(c!=markColorCentros[i] && c!=3)
						markCentros[i].display(false);
		else
				markCentros[i].display(true);
		}
		}



		function setMarkerArray(j,lonLat,color,infoDiv){
			//icon
			var size = new OpenLayers.Size(39, 52);
			var offset = new OpenLayers.Pixel(-20, -26);
			var icon = new OpenLayers.Icon('img/icons/'+imgColor[color],size,offset);
			markColorCentros[j] = color;
			markCentros[j] = new OpenLayers.Marker(lonLat,icon)


			featureCentros[j] = new OpenLayers.Feature(layerMarkers, lonLat);

		    featureCentros[j].closeBox = false;
		    featureCentros[j].popupClass = OpenLayers.Class(OpenLayers.Popup.AnchoredBubble, {autoSize : true, border : "1px" });
		    featureCentros[j].data.popupContentHTML = infoDiv;
		    featureCentros[j].data.overflow = "hidden";
			markCentros[j].feature = featureCentros[j];
		    markerClick[j] = function(evt) {
		        if (popup[j] == null) {
		            popup[j]  = this.createPopup(this.closeBox);
		            map.addPopup(popup[j] );
		            popup[j].show();
		        } else {
		            popup[j] .toggle();
		        }
		    	for(var k=0;k<featureCentros.length;k++){
		    		if(featureCentros[k].popup && j!=k){
		    			if(popup[k] && popup[k].map){
		    				popup[k].hide()
		    			}
		    		}
		    	}
		        OpenLayers.Event.stop(evt);
		    };
		    markCentros[j].events.register("mousedown", featureCentros[j], markerClick[j]);
		    layerMarkers.addMarker(markCentros[j]);
		    //circle
		    var epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection 
		    var projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator) 

		}
		//@ cerrar ventana popup
		function closePopUp(r){
			//console.log(r)
		    //popup.hide();
		}
		function initAllMarkers(){
		    //json data
			$.post("services/restData.php", { "func": "getMarkersAll" },
			function(data){
				for(i=0; i<=data.markers.length-1; i++){
					//console.log(data.markers[i]);
					var lonLat = new OpenLayers.LonLat(parseFloat(data.markers[i].longitud), parseFloat(data.markers[i].latitud)).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
					var divInfo = "<h5>"+data.markers[i].nombre+"</h5><ul><li><strong>"+data.markers[i].tatencion+" </strong> pers. esperando</li>";
					divInfo =divInfo + "<li><strong>"+data.markers[i].tespera+"</strong> min. espera apróx.<div class='botonPopup'></div></li></ul> <input type='button' value='>>'  onclick=\"cmdNextStep_OnClick('"+data.markers[i].IdCentro+"');\" ><div class='clear'><div class='flecha'></div></div></div>"
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

		var cloudmade = new OpenLayers.Layer.CloudMade("CloudMade", {
		    key: '761827ad7d5f420fac1db9f4b78e92f5',
		    styleId: 44094
		});
		map.addLayer(cloudmade);

		var layer = new OpenLayers.Layer.OSM( "Simple OSM Map");
		var vector = new OpenLayers.Layer.Vector('vector');
		var markerMe = null;
		map.addLayers([layer, vector]);
		map.setCenter(
		    new OpenLayers.LonLat(-70.570254, -33.526223).transform(
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
		   // OpenLayers.Console.log('Location detection failed');
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