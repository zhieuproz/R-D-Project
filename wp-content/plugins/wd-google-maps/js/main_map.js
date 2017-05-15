////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var autocomplete;
var searchBox;
////////////////////////////////////////////////////////////////////////////////////////
// Constructor & Destructor                                                           //
////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////


function geocodeAddress(showMarkers, callback, elementlatId, elementlngId, withoutMap ) {
    if(typeof withoutMap == 'undefined') {
        withoutMap = false;
    }
    if(showMarkers == true){
       if(marker){
            marker.setMap(null);
       }
       marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });	
        marker.setVisible(false);
        if(typeof gmwdSetMarkerIcon == "function"){
            gmwdSetMarkerIcon();
        } 
        else if(markerDefaultIcon){
            marker.setIcon(markerDefaultIcon);
        }
	}	
	var place = autocomplete.getPlace();

	if (!place.geometry) {
		//window.alert("Autocomplete's returned place contains no geometry");
		return;
	}
    
    if(withoutMap == false || withoutMap == undefined){
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } 
        else {
            map.setCenter(place.geometry.location);
            
            //map.setZoom(17);  
        }
    }
	if(showMarkers == true){
		marker.setPosition(place.geometry.location);	
		marker.setVisible(true);
	}
	jQuery("#" + elementlatId ).val(place.geometry.location.lat());
	jQuery("#" + elementlngId ).val(place.geometry.location.lng());

	if(callback != false){		
		callback();
	}
}

function initAutocomplete(showMarkers,callback, elementId, elementlatId, elementlngId, withoutMap ) {
    if(typeof withoutMap == 'undefined') {
        withoutMap = false;
    }
	var input = /** @type {!HTMLInputElement} */(
	  document.getElementById(elementId));

    autocomplete = new google.maps.places.Autocomplete(input);
    if(withoutMap == false){
        autocomplete.bindTo('bounds', map);
    }
    
	autocomplete.addListener('place_changed', function() {
		geocodeAddress(showMarkers, callback, elementlatId, elementlngId, withoutMap );
	});

}

function initSearchBox(elementId){
    if(jQuery("#" + elementId).length>0){
       jQuery("#" + elementId).remove(); 
    }

    var input = document.createElement("input");
    input.id = elementId;
    input.type = "text";
    //input.placeholder = "Search Box";
    input.style.cssText = "width:400px;";
    input.setAttribute("onkeypress", "if(event.keyCode == 13) return false;") ;
    
    searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
    
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });
 
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
       

    
}

function getLatLngFromAddress(inputAddress, elementlatId, elementlngId, callback){
    
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        "address": inputAddress
    }, function(results) {
        jQuery("#" + elementlatId).val(results[0].geometry.location.lat());
        jQuery("#" + elementlngId).val(results[0].geometry.location.lng());
        if(callback){
            callback();
        }       
    });
}

function getAddressFromLatLng(lat, lng, elementAddressId, callback){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({       
        latLng: new google.maps.LatLng(lat, lng)     
    }, 
    function(responses) {  
       if (responses && responses.length > 0) {        
           jQuery("#" + elementAddressId).val(responses[0].formatted_address); 
           if(callback){
                callback();
            }              
       }  
    });
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