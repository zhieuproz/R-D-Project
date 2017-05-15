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
var polyline;
var polylineCoord = [];
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
	// styles
	jQuery("#line_color").blur(function(){
		if(jQuery(this).val() && polyline){
			polyline.setOptions({strokeColor: "#" + jQuery(this).val()});
		}
	});
	
	
	jQuery("#line_width").bind("slider:ready slider:changed", function (event, data) { 
		if (polyline){
			polyline.setOptions({strokeWeight: data.value.toFixed(1)});
		}			
	});
	
	jQuery("#line_opacity").bind("slider:ready slider:changed", function (event, data) { 
		if (polyline){
			polyline.setOptions({strokeOpacity: data.value.toFixed(1)});
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
        polylineCoord = [];
        gmwdRemoveMarkersFromMap();
        markers = [];
        if(polyline ){
            polyline.setMap(null);
        }
         if(jQuery(this).val().length != 0){
            gmwdSetPolyline();
         }       
    }); 
      
});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function gmwdSetPolyline(){
	var polylineMarkers = jQuery("#data").val();  
	jQuery("#data").val("");
	polylineMarkers = polylineMarkers.substr(1, polylineMarkers.length-4).split("),(");
	var polylineMarker;
   
    for(var i = 0; i<polylineMarkers.length; i++){
        if(polylineMarkers[i] == "0, Na"){
            return false;
        }
        polylineMarker = polylineMarkers[i].split(",");		
        
        gmwdAddNewMarker(new google.maps.LatLng( Number(polylineMarker[0]), Number(polylineMarker[1])));	
        polylineCoord.push(new google.maps.LatLng( Number(polylineMarker[0]), Number(polylineMarker[1])));
    }
    gmwdAddMarkersToMap();
    gmwdDrawPolyline(polylineCoord);
    if(rightclick == false){
        var centerCoord = polylineMarkers[parseInt(i/2)];
        centerCoord = centerCoord.split(",");
        map.setCenter(new google.maps.LatLng( Number(centerCoord[0]), Number(centerCoord[1])));
    }
    gmwdPolylineEvents();
    
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


function gmwdAddPolyline(){
    polylineCoord = [];
	for(var i=0; i<markers.length; i++){
		var gMarker = markers[i];
		var gMarkerPosition = gMarker.getPosition();
		var coord = {};
		coord.lat = gMarkerPosition.lat();
		coord.lng = gMarkerPosition.lng();
		polylineCoord.push(coord);
	}

	gmwdDrawPolyline(polylineCoord);

}

function gmwdDrawPolyline(polylineCoord){
	// Construct the polyline.
	 polyline = new google.maps.Polyline({
		path: polylineCoord,
		strokeWeight:Number(jQuery("#line_width").val()),
		strokeColor: "#" + jQuery("#line_color").val(),
		strokeOpacity: Number(jQuery("#line_opacity").val()),
		geodesic: true,
	});
	
	polyline.setMap(map);
	gmwdPolylineEvents();
}
function gmwdPolylineMapEvents(){
	google.maps.event.addListener(map, 'rightclick', function(event) {
        gmwdRemoveMarkersFromMap();
        if(polyline){
            polyline.setMap(null);
        }
       gmwdAddNewMarker(event.latLng);
       gmwdAddMarkersToMap();  
       gmwdAddPolyline();	  	   
    });
}
function gmwdPolylineEvents(){
    //events

	google.maps.event.addListener(polyline,"mouseout",function(){
		this.getMap().getDiv().removeAttribute('title');			
	}); 
	google.maps.event.addListener(polyline,'mouseover',function(){
		if(jQuery("#title").val()){
			this.getMap().getDiv().setAttribute('title',jQuery("#title").val());
		 }
	 }); 
	 
	for(var i = 0; i<markers.length; i++){
		marker = markers[i];
		
		google.maps.event.addListener(marker, 'dragstart', function (event) {
			var position = this.getPosition();
			jQuery("#selected_marker").val("(" + position.lat() + ", " + position.lng() + "),");						
		});
		google.maps.event.addListener(marker, 'dragend', function (event) {
			var position = this.getPosition();
			var newPosition = "(" + position.lat() + ", " + position.lng() + "),";		
            gmwdChangeData(jQuery("#selected_marker").val(), newPosition);
		});	
		google.maps.event.addListener(marker, 'rightclick', function (event) {
			var position = this.getPosition();	
			position = "(" + position.lat() + ", " + position.lng() + "),";	
            gmwdChangeData(position, "");
		});			
	
	}	
}
function gmwdChangeData(position, newPosition){
    rightclick = true;
    jQuery("#data").val(jQuery("#data").val().replace(position,newPosition));  
    gmwdRemoveMarkersFromMap();
    markers = [];		
    polylineCoord = [];	
    polyline.setMap(null);
    gmwdSetPolyline();
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