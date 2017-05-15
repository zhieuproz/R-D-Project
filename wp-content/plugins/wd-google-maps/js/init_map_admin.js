////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var map;
var transitLayer;
var bikeLayer;
var trafficLayer;
var georssLayer;
var ctaLayer;
var fusionTablesLayer;
////////////////////////////////////////////////////////////////////////////////////////
// Constructor & Destructor                                                           //
////////////////////////////////////////////////////////////////////////////////////////

function gmwdInitMainMap(el, excludeOverlays){

	map = new google.maps.Map(document.getElementById(el), {
		center: {lat: centerLat, lng: centerLng},
		zoom: zoom,
		maxZoom: maxZoom,
		minZoom: minZoom,
		scrollwheel: mapWhellScrolling,
		draggable: mapDragable,
		disableDoubleClickZoom: mapDbClickZoom,
		zoomControl: enableZoomControl,
		mapTypeControl: enableMapTypeControl,
		scaleControl: enableScaleControl,
		streetViewControl: enableStreetViewControl,
		fullscreenControl: enableFullscreenControl,
		rotateControl: enableRotateControl,
        zoomControlOptions:{
            position: zoomControlPosition
        },
        mapTypeControlOptions:{
            position: mapTypeControlPosition,
            style: mapTypeControlStyle
        },
        fullscreenControlOptions:{
            position: fullscreenControlPosition
        },
        streetViewControlOptions:{
            position: streetViewControlPosition
        }
	});
    map.setTilt(45);

	gmwdSetMapTypeId();

	//themes
	jQuery("#wd-map3, #wd-map").css("border-radius", mapBorderRadius + "px");

	//layers
	gmwdSetLayers("bike");
	gmwdSetLayers("traffic");
	gmwdSetLayers("transit");

	if(excludeOverlays == false){
		infoWindowInfo = jQuery("[name=info_window_info]").length > 0 ? jQuery("[name=info_window_info]").val() : infoWindowInfo;
        // overlays
        gmwdSetMapMarkers();
        gmwdSetMapPolygons();
        gmwdSetMapPolylines();
    }
     if(el == "wd-map3" || el == "wd-map"){
        // map events
        google.maps.event.addListener(map, 'drag', function(event) {
           var mapCenter = map.getCenter();
           jQuery("#center_lat").val(mapCenter.lat());
           jQuery("#center_lng").val(mapCenter.lng());
           getAddressFromLatLng(mapCenter.lat(), mapCenter.lng(), "address", false);
          // map.setCenter({lat:Number(mapCenter.lat()), lng:Number(mapCenter.lng())});
        });

        google.maps.event.addListener(map, 'zoom_changed', function(event) {
           zoom = map.getZoom();
           jQuery("#zoom_level").val(zoom);
          // map.setZoom(zoom);
        });
    }
    if(el == "wd-map3"){
        google.maps.event.addListener(map, 'rightclick', function(event) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                latLng: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
            },
            function(responses) {
               if (responses && responses.length > 0) {
                   jQuery("#address").val(responses[0].formatted_address);
                   jQuery("#center_lat").val( event.latLng.lat());
                   jQuery("#center_lng").val( event.latLng.lng());
                   map.setCenter(event.latLng);
               }
            });

        });

    }


}


var allMarkers = [];
var infoWindows = [];
function gmwdSetMapMarkers(){
	var mapMarker;

	for(var key in mapMarkers){
		mapMarker = mapMarkers[key];
        if(mapMarker.published == 0){
            continue;
        }
		var marker = new google.maps.Marker({
			map: map,
			position: {lat: Number(mapMarker.lat), lng: Number(mapMarker.lng)}
		});

		allMarkers.push(marker);
        var infoWindow;
        if(mapMarker.enable_info_window == 1){
            //var infoWindowInfo = jQuery("[name=info_window_info]").val() ;
            contentString = "";
            if(infoWindowInfo.indexOf("title") != -1){
                contentString += mapMarker.title;
            }
            if(infoWindowInfo.indexOf("address") != -1){
                if(infoWindowInfo.indexOf("title") != -1){
                    contentString += "<br>" ;
                }
                contentString +=  mapMarker.address;
            } 
            infoWindow = new google.maps.InfoWindow({
                content: contentString,
                disableAutoPan: false
            });
            if(mapMarker.info_window_open == 1){
                infoWindow.open(map, marker);
            }
            infoWindows.push(infoWindow)
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
		(function(overlay, row, overlayWindow, map, overlayWindows) {

			google.maps.event.addListener(overlay, 'click', function() {
				if(jQuery("#info_window_open_on :selected").val() == "click"){
					if(overlayWindow && row.enable_info_window == 1){
                        for(var j=0; j < overlayWindows.length; j++){
                            overlayWindows[j].open(null, null);
                        }
						overlayWindow.open(map, overlay);
					}
				}
			});
			google.maps.event.addListener(overlay, 'mouseover', function() {
				if(jQuery("#info_window_open_on :selected").val() == "hover"){
					if(overlayWindow && row.enable_info_window == 1){
                        for(var j=0; j < overlayWindows.length; j++){
                            overlayWindows[j].open(null, null);
                        }
						overlayWindow.open(map, overlay);
					}
				}
			});

		}(marker, mapMarker, infoWindow, map, infoWindows));

	}

}


var allPolygons = [];
var allPolygonMarkers = [];
function gmwdSetMapPolygons(){
	var mapPolygon, polygon;
    var polygonsByAreas = {};
    var polygonsAreas = [];
	for(var key in mapPolygons){
		var polygonCoord = [];
		mapPolygon = mapPolygons[key];
        if(mapPolygon.published == 0){
            continue;
        }
		polygonData = mapPolygon.data.substr(1, mapPolygon.data.length-4).split("),(");
		for(var j=0; j<polygonData.length; j++){
			var polygonMarker = polygonData[j].split(",");
			if(mapPolygon.show_markers == 1){
                var marker = new google.maps.Marker({
                    map: map,
                    position: {lat: Number(polygonMarker[0]), lng: Number(polygonMarker[1]) }
                });

                allPolygonMarkers.push(marker);
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

		allPolygons.push(polygon);
        var polygonArea = google.maps.geometry.spherical.computeArea(polygon.getPath());
        polygonsByAreas[polygonArea] = [polygon];
        polygonsAreas.push(polygonArea);
		//polygon.setMap(map);

 		(function(overlay, row, map) {

			google.maps.event.addListener(overlay,"mouseover",function(){
                if(row.title){
                    this.getMap().getDiv().setAttribute('title',row.title);
                 }
			});
            google.maps.event.addListener(overlay,"mouseout",function(){
                this.getMap().getDiv().removeAttribute('title');
            });

		}(polygon, mapPolygon, map));

	}
    polygonsAreas.sort(function(a,b){return b - a});

    for(var i=0; i< polygonsAreas.length ; i++){
        polygonsByAreas[polygonsAreas[i]][0].setMap(map);
        polygonsByAreas[polygonsAreas[i]][0].setOptions({zIndex: i+1});
    }

}


var allPolylines = [];
var allPolylineMarkers = [];
function gmwdSetMapPolylines(){
	var mapPolyline, polyline;

	for(var key in mapPolylines){
		var polylineCoord = [];
		mapPolyline = mapPolylines[key];
        if(mapPolyline.published == 0){
            continue;
        }
		polylineData = mapPolyline.data.substr(1, mapPolyline.data.length-4).split("),(");
		for(var j=0; j<polylineData.length; j++){
			var polylineMarker = polylineData[j].split(",");
			if(mapPolyline.show_markers == 1){
                var marker = new google.maps.Marker({
                    map: map,
                    position: {lat: Number(polylineMarker[0]), lng: Number(polylineMarker[1]) }
                });
                allPolylineMarkers.push(marker);

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

		allPolylines.push(polyline);
		polyline.setMap(map);

        (function(overlay, row, map) {

			google.maps.event.addListener(overlay,"mouseover",function(){
                if(row.title){
                    this.getMap().getDiv().setAttribute('title',row.title);
                 }
			});
            google.maps.event.addListener(overlay,"mouseout",function(){
                this.getMap().getDiv().removeAttribute('title');
            });

		}(polyline, mapPolyline, map));


	}

}


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////


function gmwdSetMapTypeId(){
	switch(mapType){
		case "0" :
			map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
			break;
		case "1" :
			map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
			break;
		case "2":
			map.setMapTypeId(google.maps.MapTypeId.HYBRID);
			break;
		case "3":
			map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
			break;
	}
}


function gmwdSetLayers(type){
	switch(type){
		case "bike" :
			if(enableBykeLayer == 1){
				 bikeLayer = new google.maps.BicyclingLayer();
				 bikeLayer.setMap(map);
			 }
			 else{
				if(bikeLayer){
					bikeLayer.setMap(null);
				}
			 }
			 break;
		case "traffic" :
			if(enableTrafficLayer == 1){
				trafficLayer = new google.maps.TrafficLayer();
				trafficLayer.setMap(map);
			 }
			 else{
				if(trafficLayer){
					trafficLayer.setMap(null);
				}
			 }
			 break;
		case "transit" :
			if(enableTransitLayer == 1){
				transitLayer = new google.maps.TransitLayer();
				transitLayer.setMap(map);
			 }
			 else{
				if(transitLayer){
					transitLayer.setMap(null);
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
