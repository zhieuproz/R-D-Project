////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var markers = [];
var infoWindows = [];
var polygon;
var polygonCoord = [];
var rightclick = false;
////////////////////////////////////////////////////////////////////////////////////////
// Constructor & Destructor                                                           //
////////////////////////////////////////////////////////////////////////////////////////
jQuery( document ).ready(function() {	
    if(jQuery(".pois_table").length>0){
        jQuery(".pois_table").tooltip();
    }
    jQuery("input[type=text], input[type=number]").keypress(function(event){
        event = event || window.event;
        if(event.keyCode == 13){           
            return false;
        }   
    });
	//styles
	jQuery("#line_color").blur(function(){
		if(jQuery(this).val() && polygon){
			polygon.setOptions({strokeColor: "#" + jQuery(this).val()});
		}
	});
	jQuery("#fill_color").blur(function(){
		if(jQuery(this).val() && polygon){
			polygon.setOptions({fillColor: "#" + jQuery(this).val()});
		}
	});
	
	
	jQuery("#line_width").bind("slider:ready slider:changed", function (event, data) { 
		if (polygon){
			polygon.setOptions({strokeWeight: data.value.toFixed(1)});
		}			
	});
	jQuery("#line_opacity").bind("slider:ready slider:changed", function (event, data) { 
		if (polygon){
			polygon.setOptions({strokeOpacity: data.value.toFixed(1)});
		}			
	});
	jQuery("#fill_opacity").bind("slider:ready slider:changed", function (event, data) { 
		if (polygon){
			polygon.setOptions({fillOpacity: data.value.toFixed(1)});
		}			
	});


	// show markers
	jQuery("[name=show_markers]").change(function(){
		var markervisibilaty = jQuery(this).val() == 1 ? true : false;
		for(var i = 0; i<markers.length; i++){
			markers[i].setVisible(markervisibilaty);
		}
	});

     // data
    jQuery("#data").blur(function(){
       
        polygonCoord = [];
        gmwdRemoveMarkersFromMap();
        markers = [];
        infoWindows = [];
        if(polygon){
            polygon.setMap(null);
        }

        if(jQuery(this).val().length != 0){
           gmwdSetPolygon();
        }
    });     

});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////

function gmwdSetPolygon(){
	var polygonMarkers = jQuery("#data").val();
	jQuery("#data").val("");
	polygonMarkers = polygonMarkers.substr(1, polygonMarkers.length-4).split("),(");
	var polygonMarker;
   
	for(var i = 0; i<polygonMarkers.length; i++){

        if(polygonMarkers[i] == "0, Na"){
            return false;
        }
		polygonMarker = polygonMarkers[i].split(",");
		gmwdAddNewMarker(new google.maps.LatLng( Number(polygonMarker[0]), Number(polygonMarker[1])));		
		polygonCoord.push(new google.maps.LatLng( Number(polygonMarker[0]), Number(polygonMarker[1])));
	}
	gmwdAddMarkersToMap();
	gmwdDrawPolygon(polygonCoord);
	
	// set map center polygon center
	google.maps.Polygon.prototype.gmwdgetBounds=function(){
		var bounds = new google.maps.LatLngBounds()
		this.getPath().forEach(function(element,index){bounds.extend(element)})
		return bounds;
	}
	if(rightclick == false){
		map.setOptions({center: polygon.gmwdgetBounds().getCenter()});
	}	
	gmwdPolygonEvents();
}

function gmwdAddNewMarker(location){

    var marker = new google.maps.Marker({
        position: location,
		draggable:true
		
    });

	var markervisibilaty = jQuery("[name=show_markers]:checked").val() == 1 ? true : false;
	marker.setVisible(markervisibilaty);
    	
	markers.push(marker);
	jQuery("#data").val(jQuery("#data").val() + location + ",");
}
  
function gmwdAddMarkersToMap(){
	for(var i = 0; i<markers.length; i++){		
		markers[i].setMap(map);
	}
}

function gmwdRemoveMarkersFromMap(){
	for(var i = 0; i<markers.length; i++){		
		markers[i].setMap(null);
	}
}

function gmwdAddPolygon(){
    polygonCoord = [];
	for(var i=0; i<markers.length; i++){
		var gMarker = markers[i];
		var gMarkerPosition = gMarker.getPosition();
		var coord = {};
		coord.lat = gMarkerPosition.lat();
		coord.lng = gMarkerPosition.lng();
		polygonCoord.push(coord);
	}
	gmwdDrawPolygon(polygonCoord);
}

function gmwdDrawPolygon(polygonCoord){
	// Construct the polygon.
	 polygon = new google.maps.Polygon({
		paths: polygonCoord,
		strokeWeight:Number(jQuery("#line_width").val()),
		strokeColor: "#" + jQuery("#line_color").val(),
		strokeOpacity: Number(jQuery("#line_opacity").val()),
		fillColor: "#" + jQuery("#fill_color").val(),
		fillOpacity: Number(jQuery("#fill_opacity").val()),
		draggable:true
	});
	

	polygon.setMap(map);
	gmwdPolygonEvents();
}

function gmwdPolygonMapEvents(){
	google.maps.event.addListener(map, 'rightclick', function(event) {
        gmwdRemoveMarkersFromMap();
        if(polygon){			
            polygon.setMap(null);
        }
       gmwdAddNewMarker(event.latLng); 
       gmwdAddMarkersToMap();  
       gmwdAddPolygon();	   
    });
}
function gmwdPolygonEvents(){	
    //events 
	google.maps.event.addListener(polygon, 'dragend', function (event) {

		jQuery("#data").val("");
		this.getPath().forEach(function(element,index){
			jQuery("#data").val(jQuery("#data").val() + "(" + element.lat() + "," + element.lng() + "),");			
		});
		gmwdRemoveMarkersFromMap();
		polygon.setMap(null);
		polygonCoord = [];
		markers = [];
		infoWindows = [];
		rightclick = true;
		gmwdSetPolygon();
	
	}); 
	

	google.maps.event.addListener(polygon,"mouseout",function(){
		this.getMap().getDiv().removeAttribute('title');			
	}); 
	google.maps.event.addListener(polygon,'mouseover',function(){
		if(jQuery("#title").val()){
			this.getMap().getDiv().setAttribute('title',jQuery("#title").val());
		 }
	 });
	
	
	for(var i = 0; i<markers.length; i++){
		marker = markers[i];
		
		google.maps.event.addListener(marker, 'dragstart', function (event) {
			var position = this.getPosition();
			jQuery("#dragged_marker").val("(" + position.lat() + ", " + position.lng() + "),");						
		});
		google.maps.event.addListener(marker, 'dragend', function (event) {
			var position = this.getPosition();
			var newPosition = "(" + position.lat() + ", " + position.lng() + "),";
            gmwdChangeData(jQuery("#dragged_marker").val(), newPosition);

		});	

		google.maps.event.addListener(marker, 'rightclick', function (event) {
			var position = this.getPosition();	
			position = "(" + position.lat() + ", " + position.lng() + "),";	
            gmwdChangeData(position, "")
		});			
	
	}

}
function gmwdChangeData(position, newPosition){
    rightclick = true;
    jQuery("#data").val(jQuery("#data").val().replace(position,newPosition));
    gmwdRemoveMarkersFromMap();
    markers = [];	
    infoWindows = [];	
    polygonCoord = [];	
    polygon.setMap(null);
    gmwdSetPolygon();
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