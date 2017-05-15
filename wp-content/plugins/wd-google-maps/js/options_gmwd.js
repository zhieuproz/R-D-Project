////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constructor & Destructor                                                           //
////////////////////////////////////////////////////////////////////////////////////////
jQuery( document ).ready(function() {
	jQuery(document).tooltip();
	if(jQuery("#wd-options-map").length>0){
		map = new google.maps.Map(document.getElementById("wd-options-map"), {		
			zoom: zoom,
			scrollwheel: mapWhellScrolling,
			draggable: mapDragable       
		});
		/*jQuery(".wd-options-tabs-container .wd-options-container:not(#general)").hide();
		
		jQuery(".wd-options-tabs li a").click(function(){
			jQuery(".wd-options-tabs-container .wd-options-container").hide();
			jQuery(".wd-options-tabs li a").removeClass("wd-btn-primary");
			jQuery(jQuery(this).attr("href")).show();
			jQuery(this).addClass("wd-btn-primary");
			return false;
		}); */
		
		initAutocomplete(false,gmwdSetMapCenter,"address","center_lat", "center_lng", true);
		jQuery("#center_lat, #center_lng").change(function(){        
			getAddressFromLatLng(Number(jQuery("#center_lat").val()), Number(jQuery("#center_lng").val()), "address", gmwdSetMapCenter); 
			
		});
		jQuery("#address").keypress(function(event){
			event = event || window.event;
			if(event.keyCode == 13){  					
				getLatLngFromAddress(jQuery(this).val(), "center_lat", "center_lng", gmwdSetMapCenter);                        
				return false;
			}   
		});
		jQuery("#center_lat, #center_lng").change(function(){        
			getAddressFromLatLng(Number(jQuery("#center_lat").val()), Number(jQuery("#center_lng").val()), "address", gmwdSetMapCenter); 
			
		});
		
        // map zoom level
        jQuery("#zoom_level").bind("slider:ready slider:changed", function (event, data) { 
            zoom = Number(data.value.toFixed(1));
            map.setZoom(zoom);		
        });	
		// wheel scrolling
		jQuery("[name=whell_scrolling]").change(function(){	
			mapWhellScrolling = (jQuery(this).val() == 0) ? false : true;
			gmwdSetMapOptions();
		});
		
		// draggable
		jQuery("[name=map_draggable]").change(function(){
			mapDragable = (jQuery(this).val() == 0) ? false : true;
			gmwdSetMapOptions();
		});	
        
        // get user location for set up map center
        if(jQuery(".wd-set-up-map").length>0 ){       
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
               
                    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    var geocoder = new google.maps.Geocoder(); 
                    geocoder.geocode({"latLng":latlng},function(data,status){
                        if(status == google.maps.GeocoderStatus.OK){	            
                            var address = data[1].formatted_address; 
                            jQuery("#address").val(address);
                            jQuery("#center_lat").val(data[1].geometry.location.lat()); 
                            jQuery("#center_lng").val(data[1].geometry.location.lng());
                            gmwdSetMapCenter();                        
                        }
                    });
                },
                function(){
                    jQuery("#address").val(centerAddress);
                    jQuery("#center_lat").val(centerLat); 
                    jQuery("#center_lng").val(centerLng); 
                    gmwdSetMapCenter();   
                });
            }
          else{
            alert("Browser doesn't support Geolocation.");
            jQuery("#address").val(centerAddress);
            jQuery("#center_lat").val(centerLat); 
            jQuery("#center_lng").val(centerLng); 
            gmwdSetMapCenter();               
          }	 
        } 
        else{
            jQuery("#address").val(centerAddress);
            jQuery("#center_lat").val(centerLat); 
            jQuery("#center_lng").val(centerLng); 
            gmwdSetMapCenter();     
        }
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
                   gmwdSetMapCenter();                     
               }  
            });
          
        });
	}

   
});  
			


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function gmwdSetMapCenter(){
	map.setCenter({lat:Number(jQuery("#center_lat").val()), lng:Number(jQuery("#center_lng").val())});
}

function gmwdSetMapOptions(){
	var options = {
		scrollwheel: mapWhellScrolling,
		draggable: mapDragable, 
		zoom: zoom    
	};				
	map.setOptions(options);
}
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////