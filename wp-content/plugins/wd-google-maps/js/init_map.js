////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var gmwdmapDataOptions = [];

////////////////////////////////////////////////////////////////////////////////////////
// Constructor & Destructor                                                           //
////////////////////////////////////////////////////////////////////////////////////////

function gmwdInitMainMap(el, excludeOverlays, key){

	gmwdmapData["main_map" + key] = new google.maps.Map(document.getElementById(el), {
		center: {lat: gmwdmapData["centerLat" + key], lng: gmwdmapData["centerLng" + key]},
		zoom: gmwdmapData["zoom" + key],
		maxZoom: gmwdmapData["maxZoom" + key],
		minZoom: gmwdmapData["minZoom" + key],
		scrollwheel: gmwdmapData["mapWhellScrolling" + key],
		draggable: gmwdmapData["mapDragable" + key],
        disableDoubleClickZoom: gmwdmapData["mapDbClickZoom" + key],
		zoomControl: gmwdmapData["enableZoomControl" + key],
		mapTypeControl: gmwdmapData["enableMapTypeControl" + key],
		scaleControl: gmwdmapData["enableScaleControl" + key],
		streetViewControl: gmwdmapData["enableStreetViewControl" + key],
		fullscreenControl: gmwdmapData["enableFullscreenControl" + key],
		rotateControl: gmwdmapData["enableRotateControl" + key],
        zoomControlOptions:{
            position: gmwdmapData["zoomControlPosition" + key]
        },
        mapTypeControlOptions:{
            position: gmwdmapData["mapTypeControlPosition" + key],
            style: gmwdmapData["mapTypeControlStyle" + key]
        },
        fullscreenControlOptions:{
            position: gmwdmapData["fullscreenControlPosition" + key]
        },
        streetViewControlOptions:{
            position: gmwdmapData["streetViewControlPosition" + key]
        },

	});
    gmwdmapData["main_map" + key].setTilt(45);
	gmwdSetMapTypeId(key);


	//themes
    jQuery("#wd-map" + key).css("border-radius", gmwdmapData["mapBorderRadius" + key] + "px");


	//layers
	gmwdSetLayers("bike", key);
	gmwdSetLayers("traffic", key);
	gmwdSetLayers("transit", key);

	if(excludeOverlays == false){
        // overlays
        gmwdSetMapMarkers(key);
        gmwdSetMapPolygons(key);
        gmwdSetMapPolylines(key);
    }

    jQuery(document).on("click",".gm-fullscreen-control",function(){
        setTimeout(function(){ 
            gmwdmapData["main_map" + key].setCenter({lat: Number(gmwdmapData["centerLat" + key]), lng: Number(gmwdmapData["centerLng" + key])});
            gmwdmapData["main_map" + key].setZoom(gmwdmapData["zoom" + key]);
        }, 300);

    });  

}

function gmwdSetMapMarkers(_key){
	var mapMarker;
    if(Object.keys(gmwdmapData["mapMarkers" + _key]).length > 0){
        for(var key in gmwdmapData["mapMarkers" + _key]){
            mapMarker = gmwdmapData["mapMarkers" + _key][key];
            var marker = new google.maps.Marker({
                map: gmwdmapData["main_map" + _key],
                position: {lat: Number(mapMarker.lat), lng: Number(mapMarker.lng)}
            });
            gmwdmapData["allMarkers" + _key].push(marker);

            var infoWindow;
            if(mapMarker.enable_info_window == 1){
                contentString = '';

                if(gmwdmapData["infoWindowInfo" + _key].indexOf("title") != -1){
                    contentString += '<div class="gmwd-infowindow-title">' + mapMarker.title + '</div>';
                }
                if(gmwdmapData["infoWindowInfo" + _key].indexOf("address") != -1){
                    contentString += '<div class="gmwd-infowindow-address">' +  mapMarker.address + '</div>';
                } 

                infoWindow = new google.maps.InfoWindow({
                    content: contentString,
                    disableAutoPan: false
                });
                if(mapMarker.info_window_open == 1){
                    infoWindow.open(gmwdmapData["main_map" + _key], marker);
                }
                gmwdmapData["infoWindows" + _key].push(infoWindow);
            }

            if(mapMarker.title){
                marker.setTitle(mapMarker.title);
            }

            if(mapMarker.animation == "BOUNCE"){
                marker.setAnimation(google.maps.Animation.BOUNCE)
              }
              else if(mapMarker.animation == "DROP"){
                marker.setAnimation(google.maps.Animation.DROP)
              }
              else{
                marker.setAnimation(null);
              }

            //events
            (function(overlay, row, overlayWindow, map, openEvent, overlayWindows) {

                google.maps.event.addListener(overlay, 'click', function() {
                    if(row.link_url){
                        window.open(row.link_url);
                    }
                    if(openEvent == "click"){
                        if(overlayWindow && row.enable_info_window == 1){
                            for(var j=0; j < overlayWindows.length; j++){
                                overlayWindows[j].open(null, null);
                            }
                            overlayWindow.open(map, overlay);
                        }
                    }
                });
                google.maps.event.addListener(overlay, 'mouseover', function() {
                    if(openEvent == "hover"){
                        if(overlayWindow && row.enable_info_window == 1){
                            for(var j=0; j < overlayWindows.length; j++){
                                overlayWindows[j].open(null, null);
                            }
                            overlayWindow.open(map, overlay);
                        }
                    }
                });

            }(marker, mapMarker, infoWindow, gmwdmapData["main_map" + _key], gmwdmapData["infoWindowOpenOn" + _key], gmwdmapData["infoWindows" + _key]));

        }
    }

}


function gmwdSetMapPolygons(_key){
	var mapPolygon, polygon;
    var polygonsByAreas = {};
    var polygonsAreas = [];
    if(Object.keys(gmwdmapData["mapPolygons" + _key]).length > 0){
        for(var key in gmwdmapData["mapPolygons" + _key]){
            var polygonCoord = [];
            mapPolygon = gmwdmapData["mapPolygons" + _key][key];
            polygonData = mapPolygon.data.substr(1, mapPolygon.data.length-4).split("),(");
            for(var j=0; j<polygonData.length; j++){
                var polygonMarker = polygonData[j].split(",");
                if(mapPolygon.show_markers == 1){
                    var marker = new google.maps.Marker({
                        map: gmwdmapData["main_map" + _key],
                        position: {lat: Number(polygonMarker[0]), lng: Number(polygonMarker[1]) }
                    });
                    marker.setMap(gmwdmapData["main_map" + _key]);
                    gmwdmapData["allPolygonMarkers" + _key].push(marker);
                }
                polygonCoord.push(new google.maps.LatLng( Number(polygonMarker[0]), Number(polygonMarker[1])));
            }

            polygon = new google.maps.Polygon({
                strokeWeight:Number(mapPolygon.line_width),
                strokeColor: "#" + mapPolygon.line_color,
                strokeOpacity: Number(mapPolygon.line_opacity),
                fillColor: "#" + mapPolygon.fill_color,
                fillOpacity: Number(mapPolygon.fill_opacity),
                paths: polygonCoord,
            });

            gmwdmapData["allPolygons" + _key].push(polygon);
            //polygon.setMap(gmwdmapData["main_map" + _key]);
            var polygonArea = google.maps.geometry.spherical.computeArea(polygon.getPath());
            polygonsByAreas[polygonArea] = [polygon];
            polygonsAreas.push(polygonArea);
            (function(overlay, row, map) {

                google.maps.event.addListener(overlay,"mouseover",function(){
                    if(row.title){
                        this.getMap().getDiv().setAttribute('title',row.title);
                     }
                });
                google.maps.event.addListener(overlay,"mouseout",function(){
                    this.getMap().getDiv().removeAttribute('title');
                });

            }(polygon, mapPolygon, gmwdmapData["main_map" + _key]));

        }
    }
    polygonsAreas.sort(function(a,b){return b - a});

    for(var i=0; i< polygonsAreas.length ; i++){
        polygonsByAreas[polygonsAreas[i]][0].setMap(gmwdmapData["main_map" + _key]);
        polygonsByAreas[polygonsAreas[i]][0].setOptions({zIndex: i+1});

    }

}

function gmwdSetMapPolylines(_key){
	var mapPolyline, polyline;
	if(Object.keys(gmwdmapData["mapPolylines" + _key]).length > 0){
        for(var key in gmwdmapData["mapPolylines" + _key]){
            var polylineCoord = [];
            mapPolyline = gmwdmapData["mapPolylines" + _key][key];
            polylineData = mapPolyline.data.substr(1, mapPolyline.data.length-4).split("),(");
            for(var j=0; j<polylineData.length; j++){
                var polylineMarker = polylineData[j].split(",");
                if(mapPolyline.show_markers == 1){
                    var marker = new google.maps.Marker({
                        map: gmwdmapData["main_map" + _key],
                        position: {lat: Number(polylineMarker[0]), lng: Number(polylineMarker[1]) }
                    });
                    gmwdmapData["allPolylineMarkers" + _key].push(marker);
                    marker.setMap(gmwdmapData["main_map" + _key]);
                }
                polylineCoord.push(new google.maps.LatLng( Number(polylineMarker[0]), Number(polylineMarker[1])));
            }

            polyline = new google.maps.Polyline({
                strokeWeight:Number(mapPolyline.line_width),
                strokeColor: "#" + mapPolyline.line_color,
                strokeOpacity: Number(mapPolyline.line_opacity),
                path: polylineCoord,
                geodesic: true,
            });
            gmwdmapData["allPolylines" + _key].push(polyline);
            polyline.setMap(gmwdmapData["main_map" + _key]);

            (function(overlay, row, map) {
                google.maps.event.addListener(overlay,"mouseover",function(){
                    if(row.title){
                        this.getMap().getDiv().setAttribute('title',row.title);
                     }
                });
                google.maps.event.addListener(overlay,"mouseout",function(){
                    this.getMap().getDiv().removeAttribute('title');
                });

            }(polyline,  mapPolyline, gmwdmapData["main_map" + _key]));


        }
    }

}


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////


function gmwdSetMapTypeId(key){
	switch(gmwdmapData["mapType" + key]){
		case "0" :
			gmwdmapData["main_map" + key].setMapTypeId(google.maps.MapTypeId.ROADMAP);
			break;
		case "1" :
			gmwdmapData["main_map" + key].setMapTypeId(google.maps.MapTypeId.SATELLITE);
			break;
		case "2":
			gmwdmapData["main_map" + key].setMapTypeId(google.maps.MapTypeId.HYBRID);
			break;
		case "3":
			gmwdmapData["main_map" + key].setMapTypeId(google.maps.MapTypeId.TERRAIN);
			break;
	}
}


function gmwdSetLayers(type, key){
	switch(type){
		case "bike" :
			if(gmwdmapData["enableBykeLayer" + key] == 1){
				 gmwdmapDataOptions["bikeLayer" + key] = new google.maps.BicyclingLayer();
				 gmwdmapDataOptions["bikeLayer" + key].setMap(gmwdmapData["main_map" + key]);
			 }
			 else{
				if(gmwdmapDataOptions["bikeLayer" + key]){
					gmwdmapDataOptions["bikeLayer" + key].setMap(null);
				}
			 }
			 break;
		case "traffic" :
			if(gmwdmapData["enableTrafficLayer" + key] == 1){
				gmwdmapDataOptions["trafficLayer" + key] = new google.maps.TrafficLayer();
				gmwdmapDataOptions["trafficLayer" + key].setMap(gmwdmapData["main_map" + key]);
			 }
			 else{
				if(gmwdmapDataOptions["trafficLayer" + key]){
					gmwdmapDataOptions["trafficLayer" + key].setMap(null);
				}
			 }
			 break;
		case "transit" :
			if(gmwdmapData["enableTransitLayer" + key] == 1){
				gmwdmapDataOptions["transitLayer" + key] = new google.maps.TransitLayer();
				gmwdmapDataOptions["transitLayer" + key].setMap(gmwdmapData["main_map" + key]);
			 }
			 else{
				if(gmwdmapDataOptions["transitLayer" + key]){
					gmwdmapDataOptions["transitLayer" + key].setMap(null);
				}
			 }
			 break;
	}
}






////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
