////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////

var marker;
var infoWindow;
var linkUrl;
var rightClick = false;

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
    jQuery("#marker_address").keypress(function(event){
        rightClick = false;
        event = event || window.event;
        if(event.keyCode == 13){
            if(marker){
                marker.setMap(null);
            }
            getLatLngFromAddress(jQuery(this).val(), "lat", "lng", gmwdSetMarker);

            return false;
        }
    });


    // lat, lng
    jQuery("#lat, #lng").change(function(){
        rightClick = false;
        getAddressFromLatLng(Number(jQuery("#lat").val()), Number(jQuery("#lng").val()), "marker_address", gmwdSetMarker);
    });


	jQuery("#title").blur(function(){
		if(marker){
			marker.setTitle(jQuery(this).val());
			gmwdCreateInfoWindow();
		}
	});


	// info window
	jQuery("[name=info_window_open]").change(function(){
		gmwdSetInfoWindow();
	});
    jQuery("[name=enable_info_window]").change(function(){
		gmwdSetInfoWindow();
	});


	// animations
	jQuery("#animation").change(function(){
		gmwdSetMarkerAnimation(jQuery(this).val());
	});



});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function gmwdSetMarker(){
    if(marker){
        marker.setMap(null);
    }
	marker = new google.maps.Marker({
		map: map,
        draggable: true,
		position: {lat: Number(jQuery("#lat").val()), lng: Number(jQuery("#lng").val())}
	});

	marker.setTitle(jQuery("#title").val());

    if(rightClick === false){
        map.setOptions({center: {lat: Number(jQuery("#lat").val()), lng: Number(jQuery("#lng").val())}});
    }
    gmwdCreateInfoWindow();
	if(jQuery("[name=info_window_open]:checked").val() == 1 && jQuery("[name=enable_info_window]:checked").val() == 1){
		infoWindow.open(map, marker);
	}
	gmwdSetMarkerAnimation(jQuery("#animation :selected").val());
	linkUrl = jQuery("#link_url").val();


	gmwdMarkerEvents();
}

function gmwdCreateInfoWindow(){
	var contentString = "";
    var infoWindowInfo = jQuery("[name=info_window_info]").val();
    var contentString = "";

    if(infoWindowInfo.indexOf("title") != -1){
        contentString += jQuery("#title").val();
    }
    if(infoWindowInfo.indexOf("address") != -1){
        if(infoWindowInfo.indexOf("title") != -1){
            contentString += "<br>";
        }
        contentString += jQuery("#marker_address").val();
    } 
    
	if(infoWindow){
		infoWindow.setOptions({content: contentString});
	}
	else{
		infoWindow = new google.maps.InfoWindow({
			content: contentString,
			disableAutoPan: false
		});
	}

}

function gmwdSetInfoWindow(){
    gmwdCreateInfoWindow();
    if(jQuery("[name=enable_info_window]:checked").val() == 1){
        if(marker){
            if(jQuery("[name=info_window_open]:checked").val() == 1 ){
                infoWindow.open(map, marker);
                gmwdMarkerEvents();
            }
            else{
                infoWindow.close();
            }
        }
    }
   else{
        infoWindow.open(null, null);
    }
}


function gmwdSetMarkerAnimation(value){
  if(marker){
	  if(value == "BOUNCE"){
		marker.setAnimation(google.maps.Animation.BOUNCE)
	  }
	  else if(value == "DROP"){
		marker.setAnimation(google.maps.Animation.DROP)
	  }
	  else{
		marker.setAnimation(null);
	  }
  }
}

function gmwdMarkerEvents(){

        if(marker){
            google.maps.event.addListener(marker, 'click', function() {
                if(linkUrl){
                    window.open(linkUrl);
                }

                if(infoWindow && jQuery("[name=enable_info_window]:checked").val() == 1){
                    infoWindow.open(map, marker);
                }
            });
            google.maps.event.addListener(marker, 'dragend', function (event) {
                document.getElementById("lat").value = this.getPosition().lat();
                document.getElementById("lng").value = this.getPosition().lng();
                var latlng = new google.maps.LatLng(this.getPosition().lat(), this.getPosition().lng());
                var geocoder = geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            document.getElementById("marker_address").value = results[1].formatted_address;
                        }
                    }
                });
            });
        }


}

function gmwdMarkerMapEvents(){
    google.maps.event.addListener(map, 'rightclick', function(event) {
        if(marker){
            marker.setVisible(false);
            marker.setMap(null);
        }
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            latLng: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
        },
        function(responses) {
           if (responses && responses.length > 0) {
               jQuery("#marker_address").val(responses[0].formatted_address);
                jQuery("#lat").val( event.latLng.lat());
                jQuery("#lng").val( event.latLng.lng());
                rightClick = true;
                gmwdSetMarker();
           }
        });

    });
}

function gmwdMarkeroptions(){
	gmwdMarkerEvents();
	marker.setTitle(jQuery("#title").val());
	gmwdSetMarkerAnimation(jQuery("#animation :selected").val());
	gmwdSetInfoWindow();
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
