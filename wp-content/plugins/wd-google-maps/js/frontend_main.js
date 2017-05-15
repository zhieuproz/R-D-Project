////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var frontendData = [];
var cnterLat, cnterLng;
var ajaxData = {};
 
////////////////////////////////////////////////////////////////////////////////////////
// Constructor & Destructor                                                           //
////////////////////////////////////////////////////////////////////////////////////////

function gmwdReadyFunction(key){
    // serach box
    if(gmwdmapData["enableSerchBox" + key] == 1){
        initSerachBox(key);
    }
    // geolocate user 
    if(gmwdmapData["geolocateUser" + key] == 1){     
        geoLocateUser(key);
    }

	//store locator
	if(gmwdmapData["enableStoreLocatior" + key] == 1 && gmwdmapData["widget" + key] == 0){
    
        jQuery(".gmwd_my_location_store_locator" + key).click(function(){
			var input = jQuery("#gmwd_store_locator_address"  + key);	
            getMyLocation(input);
		});
        
		var input = /** @type {!HTMLInputElement} */(
		  document.getElementById('gmwd_store_locator_address' + key));

		var autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.bindTo('bounds', gmwdmapData["main_map" + key]);
		
		/*autocomplete.addListener('place_changed', function() {
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				window.alert("Autocomplete's returned place contains no geometry");
				return;
			}           
			cnterLat = place.geometry.location.lat(); 
			cnterLng = place.geometry.location.lng();
		});*/
			
		jQuery("#gmwd_store_locator_search" + key).click(function(){
            if(jQuery(".gmwd_store_locator_address" + key).val() == ""){
                alert("Please set location.");
                return false;
            }
			if(gmwdmapDataOptions["storeLocatorCircle" + key]){
				gmwdmapDataOptions["storeLocatorCircle" + key].setMap(null);
			}
			if(gmwdmapData["storeLocatorDistanceIn" + key] == "km"){
				var radius = Number(jQuery("#gmwd_store_locator_radius" + key + " :selected").val())*1000;
			}
			else if(gmwdmapData["storeLocatorDistanceIn" + key] == "mile"){
				var radius = Number(jQuery("#gmwd_store_locator_radius" + key + " :selected").val())*1609.34;
			}
            
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                "address": jQuery(".gmwd_store_locator_address" + key).val()
            }, function(results) {
                cnterLat = results[0].geometry.location.lat();             
                cnterLng = results[0].geometry.location.lng();  

                gmwdmapData["ajaxData" + key]["map_id"] = gmwdmapData["mapId" + key];
                gmwdmapData["ajaxData" + key]["page"] = "map";
                gmwdmapData["ajaxData" + key]["action"] = "get_ajax_store_loactor";
                gmwdmapData["ajaxData" + key]["task"] = "get_ajax_store_loactor";
                gmwdmapData["ajaxData" + key]["radius"] = Number(jQuery("#gmwd_store_locator_radius" + key + " :selected").val());
                gmwdmapData["ajaxData" + key]["lat"] = cnterLat;
                gmwdmapData["ajaxData" + key]["lng"] = cnterLng;
                gmwdmapData["ajaxData" + key]["distance_in"] = gmwdmapData["storeLocatorDistanceIn" + key];
                gmwdmapData["ajaxData" + key]["categories"] = [];
     
                jQuery.post(ajaxURL, gmwdmapData["ajaxData" + key], function (response){
         
                    gmwdmapData["mapMarkers" + key] = JSON.parse(response);
                    for(var i=0; i<gmwdmapData["allMarkers" + key].length; i++){
                        gmwdmapData["allMarkers" + key][i].setMap(null);
                    }
                    gmwdmapData["allMarkers" + key] = [];
                    gmwdSetMapMarkers(key);
                    if(gmwdmapData["markerListInsideMap" + key] == 1){
                        gmwdMarkerListInsideMap(key, gmwdmapData["mapMarkers" + key]); 
                    }
                });

                gmwdmapDataOptions["storeLocatorCircle" + key] = new google.maps.Circle({
                    strokeWeight: 2,
                    strokeColor: "#000000",
                    strokeOpacity: 0.6,
                    fillColor: "#7FDF16",
                    fillOpacity: 0.3,
                    center: {lat : cnterLat, lng: cnterLng},
                    radius: radius
                });
                
                gmwdmapDataOptions["storeLocatorCircle" + key].setMap(gmwdmapData["main_map" + key]);     
               
                gmwdmapData["main_map" + key].setCenter({lat : cnterLat, lng: cnterLng});                
                gmwdmapData["main_map" + key].setZoom(Number(gmwdmapData["zoom" + key]));                
            });
   
			return false;	
		
		});
		
		jQuery("#gmwd_store_locator_reset" + key).click(function(){
			if(gmwdmapDataOptions["storeLocatorCircle" + key]){
				gmwdmapDataOptions["storeLocatorCircle" + key].setMap(null);
			}
			gmwdmapData["ajaxData" + key] = {};
			gmwdmapData["ajaxData" + key]["map_id"] = gmwdmapData["mapId" + key];
			gmwdmapData["ajaxData" + key]["page"] = "map";
			gmwdmapData["ajaxData" + key]["action"] = "get_ajax_markers";
			gmwdmapData["ajaxData" + key]["task"] = "get_ajax_markers";
            
			jQuery.post(ajaxURL, gmwdmapData["ajaxData" + key], function (data){
				gmwdmapData["mapMarkers" + key] = JSON.parse(data);
				for(var i=0; i<gmwdmapData["allMarkers" + key].length; i++){
					gmwdmapData["allMarkers" + key][i].setMap(null);
				}
				gmwdmapData["allMarkers" + key] = [];
				gmwdSetMapMarkers(key);

			});
			           
			jQuery("#gmwd_store_locator_address" + key).val("");
			return false;	
		});		
	
	}
}	
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////

function gmwdSearch(fieldName, values, key ){
    gmwdmapData["ajaxData" + key]["page"] = "map";
    gmwdmapData["ajaxData" + key][fieldName] = values;
    gmwdmapData["ajaxData" + key]["map_id"] = gmwdmapData["mapId" + key];   
    gmwdmapData["ajaxData" + key]["action"] = "get_ajax_markers";
    gmwdmapData["ajaxData" + key]["task"] = "get_ajax_markers";
     
    jQuery.post(ajaxURL, gmwdmapData["ajaxData" + key], function (data){
        gmwdmapData["mapMarkers" + key] = JSON.parse(data);              
        for(var i=0; i<gmwdmapData["allMarkers" + key].length; i++){
            gmwdmapData["allMarkers" + key][i].setMap(null);
        }
        gmwdmapData["allMarkers" + key] = [];
        gmwdSetMapMarkers(key);

    });        

}


function geoLocateUser(key){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {      
          var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
          var marker = new google.maps.Marker({
                map: gmwdmapData["main_map" + key],
                position: latlng,
                icon: GMWD_URL + '/images/geoloc.png'
          });
          var geocoder = new google.maps.Geocoder();
            geocoder.geocode({"latLng":latlng},function(data,status){	 
                if(status == google.maps.GeocoderStatus.OK){	            
                    var address = data[1].formatted_address; 
                    
                    gmwdmapData["main_map" + key].setCenter(latlng);
                    gmwdmapData["main_map" + key].setZoom(13);
                    var infoWindow = new google.maps.InfoWindow({map: gmwdmapData["main_map" + key]});		
                    infoWindow.setPosition(latlng);
                    var contentString = address; 
                    if(gmwdmapData["enableDirections" + key] == 1 ){
                        contentString += "<br> <a href='javascript:void(0)' data-lat='" + position.coords.latitude + "' data-lng='" +Number(position.coords.longitude) + "' data-address='" + address + "' class='gmwd_direction' onclick='showDirectionsBox(this);' data-key='" + key + "'>Get Directions</a>";
                    }
                    infoWindow.setContent(contentString);
                }
           });
	
        }, function() {
          alert('Error: Your browser doesn\'t support geolocation.');
        });
    } 
    else {
        // Browser doesn't support Geolocation
        alert('Error: Your browser doesn\'t support geolocation.');
    }
}
function getMyLocation(input){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({"latLng":latlng},function(data,status){	 
                if(status == google.maps.GeocoderStatus.OK){	            
                    var address = data[1].formatted_address; 
                    input.val(address);
                    cnterLat = data[1].geometry.location.lat(); 
                    cnterLng = data[1].geometry.location.lng();                    
                }
            });
        });
    }
  else{
      alert("Browser doesn't support Geolocation.");
  }	   

}

function initSerachBox(key){
    var input = document.createElement("input");
    input.id = "gmwd_serach_box" + key;
    input.type = "text";
    input.style.cssText = "width:400px;";
    input.setAttribute("onkeypress", "if(event.keyCode == 13) return false;") ;
    input.setAttribute("class", "gmwd_serach_box") ;
    
    searchBox = new google.maps.places.SearchBox(input);
    gmwdmapData["main_map" + key].controls[gmwdmapData["serchBoxPosition" + key]].push(input);
    
    gmwdmapData["main_map" + key].addListener('bounds_changed', function() {
        searchBox.setBounds( gmwdmapData["main_map" + key].getBounds());
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
         gmwdmapData["main_map" + key].fitBounds(bounds);
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