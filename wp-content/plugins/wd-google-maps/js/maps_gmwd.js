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
    jQuery("#settings").tooltip();

    if(jQuery("#active_main_tab").val() == "settings" || jQuery("#active_main_tab").val() == "theme_preview"){ 
        mapWhellScrolling = false;
        gmwdInitMainMap("wd-map3", false);    
        jQuery(".pois_bar").hide();
        jQuery("#gmwd_preview_iframe").attr("src", previewIframeURL); 
    }
    else{
        mapWhellScrolling = false;
        gmwdInitMainMap("wd-map", false);
        jQuery(".pois_bar").show();
    }

	initAutocomplete(false,false,"address","center_lat", "center_lng");
	initSearchBox("gmwd-input-search");
   
    jQuery("#address, #gmwd-input-search").keypress(function(event){ 
        event = event || window.event;
        if(event.keyCode == 13){          
            getLatLngFromAddress(jQuery(this).val(), "center_lat", "center_lng", gmwdSetMapCenter);   
            return false;
        }   
    });
        
    jQuery(".wd-tabs li a").click(function(){
		jQuery(".wd-tabs-container>div").hide();
		jQuery(".wd-tabs li a").removeClass("wd-active-tab");
		jQuery(jQuery(this).attr("href")).show();
		jQuery(this).addClass("wd-active-tab");
        centerLat = Number(jQuery("#center_lat").val());
        centerLng = Number(jQuery("#center_lng").val());
        jQuery("#active_main_tab").val(jQuery(this).attr("href").substr(1));        
        if(jQuery(this).attr("href") == "#theme_preview" ){
            jQuery(".pois_bar").hide();
            jQuery(".published-wrapper").hide();                       
            gmwdUpdatePreview();    
        }
		else if(jQuery(this).attr("href") == "#settings"){
            mapWhellScrolling = false;
			gmwdInitMainMap("wd-map3", false);
            jQuery(".pois_bar").hide();
            jQuery(".published-wrapper").hide();
		}      
		else{
            mapWhellScrolling = false;
			gmwdInitMainMap("wd-map", false);
            initSearchBox("gmwd-input-search");
            jQuery(".pois_bar").show();
            jQuery(".published-wrapper").show();
           
		}
       
		return false;
	});

    jQuery("[name=poi_ids]").click(function(){ 
        _this = jQuery(this);
        if(_this.is(":checked")){
            var allChecked = true;
            _this.closest(".gmwd_pois").find(".wd-pois-row:not(.wd-template) [name=poi_ids]").each(function(){
            
                if(jQuery(this).is(":checked") == false){
                    allChecked = false;
                    return false;
                }
            });
            if(allChecked == true){
                _this.closest(".gmwd_pois").find(".check_all").attr("checked","checked");
            }
        }
        else{
            _this.closest(".gmwd_pois").find(".check_all").removeAttr("checked");
        }
    }); 
	
	
	
	jQuery(".wd-settings-tabs li a").click(function(){
		jQuery(".wd-settings-tabs-container .wd-settings-container").hide();
		jQuery(".wd-settings-tabs li a").removeClass("wd-settings-active-tab");
		jQuery(jQuery(this).attr("href")).show();
		jQuery(this).addClass("wd-settings-active-tab");
        jQuery("#active_settings_tab").val(jQuery(this).attr("href").substr(1));
		return false;
	});

	
	
	jQuery(".wd-pois-tabs li a:not(.wd-circles-tab, .wd-rectangles-tab)").click(function(){
		jQuery(".wd-pois-tabs-container .wd-pois-container").hide();
		jQuery(".wd-pois-tabs li a").removeClass("wd-pois-active-tab");
		jQuery(".wd-pois-tabs li a").removeClass("wd-pois-active-wd-gm-markers-tab");
		jQuery(".wd-pois-tabs li a").removeClass("wd-pois-active-wd-gm-polygons-tab");
		jQuery(".wd-pois-tabs li a").removeClass("wd-pois-active-wd-gm-polylines-tab");        
       
		jQuery(jQuery(this).attr("href")).show();
		jQuery(this).addClass("wd-pois-active-tab");
		jQuery(this).addClass("wd-pois-active-"+ jQuery(this).attr("href").substr(1) + "-tab");
        jQuery("#active_poi_tab").val(jQuery(this).attr("href").substr(1));
		return false;
	});
	

	// settings general
	// map type
	jQuery("#settings-general #type").change(function(){
		mapType = jQuery(this).val();
		gmwdSetMapTypeId();			
	});
	

    // lat, lng
    jQuery("#center_lat, #center_lng").change(function(){        
        getAddressFromLatLng(Number(jQuery("#center_lat").val()), Number(jQuery("#center_lng").val()), "address", gmwdSetMapCenter); 
        
    });
	
	// map zoom level
	jQuery("#zoom_level").bind("slider:ready slider:changed", function (event, data) { 
		zoom = Number(data.value.toFixed(1));
		map.setZoom(zoom);		
	});
    // map min zoom
	jQuery("#min_zoom").bind("slider:ready slider:changed", function (event, data) { 
		minZoom = Number(data.value.toFixed(1));
		gmwdSetMapOptions();		
	});
    // map max zoom
	jQuery("max_zoom").bind("slider:ready slider:changed", function (event, data) { 
		maxZoom = Number(data.value.toFixed(1));
		gmwdSetMapOptions();		
	});

	// wheel scrolling
	/*jQuery("[name=whell_scrolling]").change(function(){	
		mapWhellScrolling = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});*/
	
	// draggable
	jQuery("[name=map_draggable]").change(function(){
		mapDragable = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});
	
   // db-click zoom
	jQuery("[name=map_db_click_zoom]").change(function(){
		mapDbClickZoom = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});
	// controls

	jQuery("[name=enable_zoom_control]").change(function(){
		enableZoomControl = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});
	jQuery("[name=enable_map_type_control]").change(function(){
		enableMapTypeControl = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});
	jQuery("[name=enable_scale_control]").change(function(){
		enableScaleControl = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});
	jQuery("[name=enable_street_view_control]").change(function(){
		enableStreetViewControl = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});
	jQuery("[name=enable_fullscreen_control]").change(function(){
		enableFullscreenControl = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});
	jQuery("[name=enable_rotate_control]").change(function(){
		enableRotateControl = (jQuery(this).val() == 0) ? false : true;
		gmwdSetMapOptions();
	});	
 	
	jQuery("#map_type_control_style").change(function(){	
		mapTypeControlStyle = Number(jQuery(this).val());
		gmwdsetControlOption(mapTypeControlPosition, "map_type");					

	});
		
	jQuery("#map_type_control_position").change(function(){
		mapTypeControlPosition = Number(jQuery(this).val());		
		gmwdsetControlOption(mapTypeControlPosition, "map_type");		
	});	
    
	jQuery("#fullscreen_control_position").change(function(){
		fullscreenControlPosition = Number(jQuery(this).val());		
		gmwdsetControlOption(fullscreenControlPosition, "fullscreen");		
	
	});		

	jQuery("#zoom_control_position").change(function(){
		zoomControlPosition = Number(jQuery(this).val());	
		gmwdsetControlOption(zoomControlPosition, "zoom");			
	});	
	jQuery("#street_view_control_position").change(function(){
		streetViewControlPosition = Number(jQuery(this).val());
		gmwdsetControlOption(streetViewControlPosition, "street_view");				
	});
		

	//layers
	
	jQuery("[name=enable_bicycle_layer]").change(function(){
		enableBykeLayer = jQuery(this).val();
		gmwdSetLayers("bike");
	});
	
	jQuery("[name=enable_traffic_layer]").change(function(){	
		enableTrafficLayer = jQuery(this).val();
		gmwdSetLayers("traffic");
	});
	
	jQuery("[name=enable_transit_layer]").change(function(){
		enableTransitLayer = jQuery(this).val();
		gmwdSetLayers("transit");
	});	
	
	jQuery("#georss_url").blur(function(){
		geoRSSURL = jQuery(this).val();
		gmwdSetGeoRSSURL();
	});	
	
	jQuery("#kml_url").blur(function(){
		KMLURL = jQuery(this).val();
		gmwdSetKMLURL();
	});
	jQuery("#fusion_table_id").blur(function(){
		fusionTableId = jQuery(this).val();
		gmwdSetFusionTableId();
	});
    
	// geolocate user
	jQuery("[name=geolocate_user]").change(function(){
        if(isHttps == 0){
            if(jQuery(this).val() == 1){
                jQuery(".geolocation_msg").show();
            }
            else{
                jQuery(".geolocation_msg").hide();
            }
        }    
    });
	jQuery(".info_window_info").change(function(){
        var selected = [];
        jQuery(".info_window_info:checked").each(function(){
            selected.push(jQuery(this).val());
        });
        jQuery("[name=info_window_info]").val(selected.join());
    });     
});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function gmwdCheckAll(obj){
    if(jQuery(obj).is(":checked")){     
        jQuery(obj).closest(".gmwd_pois").find(".wd-pois-row:not(.wd-template) [name=poi_ids]").attr("checked","checked");
    }
    else{
        jQuery(obj).closest(".gmwd_pois").find(".wd-pois-row:not(.wd-template) [name=poi_ids]").removeAttr("checked");
    }
}
function gmwdOnChnageMapTheme(obj){
    jQuery(".select_map_theme").closest(".wd-left").removeClass("map_theme_img_active");
    jQuery(obj).closest(".wd-left").addClass("map_theme_img_active");
    jQuery("[name=theme_id]").removeAttr("checked");
    jQuery(obj).next("[name=theme_id]").attr("checked","checked" );
    mapTheme = jQuery(obj).closest(".wd-left").find(".theme_code").val();
    gmwdUpdatePreview();
}
function gmwdUpdatePreview(){
  
    var data = {};
    /*fillInputPois();
    jQuery("#adminForm input, #adminForm select, #adminForm textarea").each(function(){
        var name = jQuery(this).attr("name");
        if(jQuery(this).is("input[type=radio]") ){	      
            data[name] = jQuery("[name=" + name + "]:checked").val();						
        }
        else if(jQuery(this).is("select")){
            data[name] = jQuery("[name=" + name + "] :selected").val();
        }
        else {
            data[name] = jQuery(this).val();
        }
    
    });
    */
    data["action"] = 'preview_map';
    data["page"] = 'maps_gmwd';
    data["ajax"] = '1';
    data["task"] = 'for_preview';
    data["theme_id"] = jQuery("[name=theme_id]:checked").val();
    
    jQuery.post(ajax_url, data, function (data){ 
        jQuery("#gmwd_preview_iframe").attr("src", previewIframeURL);                                      
    });
}
function gmwdSetMapCenter(){
    map.setCenter({lat:Number(jQuery("#center_lat").val()), lng:Number(jQuery("#center_lng").val())});
}

function gmwdSetMapOptions(){
	var options = {
		scrollwheel: mapWhellScrolling,
		draggable: mapDragable, 
        disableDoubleClickZoom: mapDbClickZoom,	
		zoomControl: enableZoomControl,	
		mapTypeControl: enableMapTypeControl,
		scaleControl: enableScaleControl, 
		streetViewControl: enableStreetViewControl, 
		fullscreenControl: enableFullscreenControl, 
		rotateControl: enableRotateControl, 
		maxZoom: maxZoom,
		minZoom: minZoom        
	};
	
	map.setOptions(options);
}

function gmwdsetControlOption(value, type){

	if(type == "fullscreen"){
        value = value == 0 ? 7 : value;
		map.setOptions({fullscreenControlOptions:{
			 position: value				
		}});								
	}
	else if( type == "zoom"){
        value = value == 0 ? 5 : value;
		map.setOptions({zoomControlOptions:{
			 position: value
		}});				
	}
	else if(type == "map_type"){
        value = value == 0 ? 5 : value;
		map.setOptions({ mapTypeControlOptions:{
			position: value,
			style: mapTypeControlStyle			
		} });		
	}
	else if(type == "street_view"){
        value = value == 0 ? 9 : value;
		map.setOptions({streetViewControlOptions:{
			 position: value	
		}});					
	}

}

function gmwdOpenPoiForm(obj, data){
    if(typeof data == "undefined"){
        data = {};
    }
   
    var url = jQuery(obj).attr("data-href");
    var poi = jQuery(obj).attr("data-poi");

    jQuery.ajax({
        type: "POST",
        url: url,
        data: {"data": JSON.stringify(data)},
        beforeSend: function(){
            jQuery(".gmwd_opacity_div").show();
        },
        success: function (result) {  
						
            jQuery("#wd-overlays").html(result);                        
            jQuery(".wd-main-map").hide();      
            jQuery(".gmwd_opacity_div").hide();             
            jQuery("#wd-overlays").slideDown('slow');
            mapWhellScrolling = (jQuery('[name=whell_scrolling]:checked').val() == 0) ? false : true;
            gmwdInitMainMap('wd-map2', true);
			
            switch(poi){
                case "markers" :				
					if(url.indexOf("&hiddenName=") > -1){
						gmwdSetMarker();
					}
                    initAutocomplete(true, gmwdMarkeroptions,"marker_address","lat", "lng");
                    gmwdMarkerMapEvents();
                    break;

                case "polygons" :
					if(url.indexOf("&hiddenName=") > -1){
						gmwdSetPolygon();
					}
					gmwdPolygonMapEvents()
                    break;                     
                 case "polylines" :
					if(url.indexOf("&hiddenName=") > -1){
						gmwdSetPolyline();
					}
					gmwdPolylineMapEvents();
                    break;              
            }
            
        },
        error: function (errorMsg) {
            alert(errorMsg);
        }
    });    
}

function gmwdAddPoi(){
    if(checkFields("wd-poi-required") == false){
        return false;
    } 

	var data = {};

	jQuery(".wd-form-field").each(function(){
		var name = jQuery(this).attr("name");
		if(jQuery(this).is("input[type=radio]") ){	      
            data[name] = jQuery(".pois_table [name=" + name + "]:checked").val();						
		}
		else if(jQuery(this).is("select")){
			data[name] = jQuery(".pois_table [name=" + name + "] :selected").val();
		}
		else {
        
			data[name] = jQuery(this).val();
		}
	});

    var published = data.published;
    var published_text = (published == 1 ? "Published" : "Unpublished");
    var published_image = ((published == 1) ? 'publish-blue' : 'unpublish-blue');   
    var titleAndAddress = _type == "markers" ? data.title + ' / ' + data.address : data.title;
    
	var poiData = JSON.stringify(data);
	
	if(_hiddenName != ""){
		var hiddenNameParts = _hiddenName.split("_");
		id = hiddenNameParts[hiddenNameParts.length - 1];
		var poiRow = jQuery(".gmwd_" + _type + " [data-id = 'poiId_" + id + "']");
		poiRow.find(".poi_title").html(titleAndAddress);
		poiRow.find("[name=" + _type + "_" + id + "]").val(poiData);		
		var key = id;
	}
	else{	
		var poiRow = jQuery(".gmwd_" + _type + " .wd-template").clone() ;
		var index = jQuery(".gmwd_" + _type + " .wd-pois-row:not(.wd-template)").length + 1;	
		poiRow.attr("data-id", "poiId_tmp" + index);		
		poiRow.find("[name=" + _type + "_tmp]").attr("name",  _type + "_tmp" + index);		
		poiRow.find("[name=" +  _type + "_tmp" + index + "]").val(poiData);
		poiRow.find(".poi_title").html(titleAndAddress);		
		poiRow.removeClass("wd-template");
		jQuery(".gmwd_" + _type + " .no_pois").html("");		
        poiRow.insertAfter(".gmwd_" + _type + " .wd-pois-header-row");  
		var key = "tmp" + index;
        jQuery(".gmwd_" + _type + " .wd-pois-row:not(.wd-template) .poi_number").each(function(index){
            jQuery(this).html((index+1) + ".");
        });
        poiRow.find("[name=poi_ids]").val(key);
	}
	poiRow.find(".poi_published").attr("src", GMWD_URL + '/images/css/' + published_image + '.png');
	poiRow.find(".poi_published").attr("title", published_text);
	poiRow.find(".poi_published").attr("data-published", published);
    
	setEditedMap(_type, key, data);
    mapWhellScrolling = false;
	gmwdInitMainMap('wd-map', false);
	jQuery(".wd-pois-tabs-container .wd-pois-container").hide();
	jQuery(".wd-pois-tabs li a").removeClass("wd-pois-active-tab");
	jQuery("#wd-gm-" + _type).show();
	jQuery("[href='#wd-gm-" + _type + "']").addClass("wd-pois-active-tab");
    gmwdClosePoi();
	return false;
}

function gmwdClosePoi(){
    jQuery("#wd-overlays").html("");
    jQuery("#wd-overlays").hide();
    jQuery(".wd-main-map").slideDown('slow');
    mapWhellScrolling = false;
    gmwdInitMainMap("wd-map", false);
	initAutocomplete(false, false,"address","center_lat", "center_lng"); 
	initSearchBox("gmwd-input-search");	
	return false;	
}

function setEditedMap(type, key, data){
   
	switch(type){
		case "markers" :
			if(data != false)
				mapMarkers[key] = data;
			else
				delete mapMarkers[key]
						
			for(var i=0; i<allMarkers.length; i++){
				allMarkers[i].setMap(null);
			}
			allMarkers = [];
			gmwdSetMapMarkers();
            //centerLat =  Number(data.lat);
            //centerLng =  Number(data.lng);
			break;

		case "polygons" :
			if(data != false)
				mapPolygons[key] = data;
			else
				delete mapPolygons[key];	
				
			for(var i=0; i<allPolygonMarkers.length; i++){
				allPolygonMarkers[i].setMap(null);
			}
			for(var i=0; i<allPolygons.length; i++){
				allPolygons[i].setMap(null);
			}
			allPolygonMarkers = [];			
			allPolygons = [];				
			gmwdSetMapPolygons();
			break;	

            
		case "polylines" :
			if(data != false)
				mapPolylines[key] = data;
			else
				delete mapPolylines[key];	
				
			for(var i=0; i<allPolylineMarkers.length; i++){
				allPolylineMarkers[i].setMap(null);
			}
			for(var i=0; i<allPolylines.length; i++){
				allPolylines[i].setMap(null);
			}	
			allPolylineMarkers = [];			
			allPolylines = [];				
			gmwdSetMapPolylines();
			break;					
	}

    
}	
function removePois(obj){
    var ids = [];
    var type = jQuery(obj).attr("data-poi");
    var page = type + "_gmwd";
    
    jQuery(".gmwd_" + type + " [name=poi_ids]:checked").each(function(){
        removePoi(this, false);
        ids.push(jQuery(this).val());
        jQuery(this).closest(".wd-pois-row").remove();    
    });
     var data = {
        'action': 'remove_poi',
        'task': 'remove',
        'page': page,
        "ids": ids,
        "ajax" : 1,
        "nonce_gmwd" : nonce
    };
                    
    jQuery.post(ajax_url, data, function(response) {});  	

}
function removePoi(obj, single){	

	var key = jQuery(obj).closest(".wd-pois-row").attr("data-id").split("_"); 
	key = key[1];
 
    var type = jQuery(obj).attr("data-poi");
	var page = jQuery(obj).attr("data-poi") + "_gmwd";

	switch(type){
		case "markers" :
			mapMarkers[key] === undefined;
			break;
           
		case "polygons" :
			mapPolygons[key] === undefined;

			break;	
		case "polylines" :
			mapPolylines[key] === undefined;
			break;		
	}
	
	setEditedMap(type, key, false);
	
	var index = jQuery(".gmwd_" + jQuery(obj).attr("data-poi") + " .wd-pois-row:not(.wd-template)").length;
	if(index == 0){
		jQuery(".gmwd_" + jQuery(obj).attr("data-poi") + " .no_pois").html("No " + jQuery(obj).attr("data-poi"));
	}
	  
    if(single == true){
        if(key.indexOf("tmp") != -1){	
            jQuery(obj).closest(".wd-pois-row").remove();
            return;
        }
        var ids = [];
        ids.push(key);
        
        
        var data = {
            'action': 'remove_poi',
            'task': 'remove',
            'page': page,
            "ids": ids, 
            "ajax": 1,
            "nonce_gmwd" : nonce            
        };
                        
        jQuery.post(ajax_url, data, function(response) {				
            jQuery(obj).closest(".wd-pois-row").remove();
        });
    }

	return false;
}

function copyPoi(obj){
    var type = jQuery(obj).attr("data-poi");
    jQuery(".gmwd_" + type + " [name=poi_ids]:checked").each(function(){
        var index = jQuery(".gmwd_" + type + " .wd-pois-row:not(.wd-template)").length + 1;	
        var poiRow =  jQuery(this).closest(".wd-pois-row").clone();
        poiRow.attr("data-id","poiId_tmp" + index);
        poiRow.find("[type=checkbox]").val("");
        poiRow.find("[type=hidden]").attr("name",  type + "_tmp" + index);	        
        poiRow.find(".wd-edit-poi").attr("data-href", poiRow.find(".wd-edit-poi").attr("data-href") + "&dublicated=1");	
        var poiData = JSON.parse(poiRow.find("[type=hidden]").val());
        poiData.id = "";
        poiRow.find("[type=hidden]").val(JSON.stringify(poiData));	  
        poiRow.insertAfter(".gmwd_" + type + " .wd-pois-header-row");  
        var index = jQuery(".gmwd_" + type + " .wd-pois-row:not(.wd-template)").length + 1;
        var key = "tmp" + index;	
        setEditedMap(type, key, poiData);        
    });

    jQuery(".gmwd_" + type + " .wd-pois-row:not(.wd-template) .poi_number").each(function(index){
        jQuery(this).html((index+1) + ".");
    });
    jQuery(".gmwd_" + type+ " input[type=checkbox]").each(function(){
        jQuery(this).removeAttr("checked");
    });
}
function editPoi(obj){
	
	var newHref = jQuery(obj).attr("data-url") ;
	
    newHref += "&hiddenName=" + jQuery(obj).closest(".wd-pois-row").find("input[type=hidden]").attr("name") ;	
   // newHref += "&data=" + jQuery(obj).closest(".wd-pois-row").find("input[type=hidden]").val();
    data = jQuery(obj).closest(".wd-pois-row").find("input[type=hidden]").val();
	
	jQuery(obj).attr("data-href",newHref);
    gmwdOpenPoiForm(obj, data);
}

function publishPoi(obj){

    var ids = [];
    var type = jQuery(obj).attr("data-poi");
   
    var page = type + "_gmwd"; 
    if(jQuery(obj).is("img") == true){
        jQuery(obj).closest(".wd-pois-row").find("[name=poi_ids]").attr("checked","checked");
    }
    var publish_unpublish = jQuery(obj).attr("data-published") == 0 ? 1 : 0;
    var published_image = ((publish_unpublish) ? 'publish-blue' : 'unpublish-blue');               
    jQuery(".gmwd_" + type + " [name=poi_ids]:checked").each(function(){
        ids.push(jQuery(this).val()); 
        jQuery(this).closest(".wd-pois-row").find(".poi_published").attr("src", GMWD_URL + '/images/css/' + published_image + '.png');
        var poi_data =  jQuery(this).closest(".wd-pois-row").find(".poi_data").val();
        poi_data = JSON.parse(poi_data);
        poi_data.published = publish_unpublish;
        jQuery(this).closest(".wd-pois-row").find(".poi_data").val(JSON.stringify(poi_data));
    });
    
     var data = {
        'action': 'publish_poi',
        'task': 'publish',
        'page': page,
        "ids": ids,
        "ajax" : 1,
        "nonce_gmwd" : nonce,
        "publish_unpublish" : publish_unpublish
    };
   jQuery(".gmwd_opacity_div").show(); 
    jQuery.post(ajax_url, data, function(response) { 
        if(jQuery(obj).is("img") == true){
            jQuery(obj).attr("data-published",publish_unpublish);
        }
        jQuery(".gmwd_" + type + " [type=checkbox]").removeAttr("checked");
        switch(type){
            case "markers" :
                var pois = mapMarkers;			
                break;	            
            case "polygons" :
                var pois = mapPolygons;
                break;	
            case "polylines" :
                var pois = mapPolylines;
                break;	
        }
        for(var j=0; j<ids.length; j++){
            var poi = pois[ids[j]];
            poi.published = publish_unpublish;
        } 
        mapWhellScrolling = false;        
        gmwdInitMainMap("wd-map", false);
        jQuery(".gmwd_opacity_div").hide(); 
  
    });
    

    
}



////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
function fillInputPois(){
	var markers = [];
	var polygons = [];
	var polylines = [];

	jQuery(".gmwd_markers .wd-pois-row:not(.wd-template) ").each(function(){
		var marker = jQuery(this).find("[name^=markers_]").val();
		markers.push(JSON.parse(marker));
	});
     var chunk = Math.ceil(Number(markers.length)/300);
     var i,j,temparray;
     var _markers = [];
   
     for (i=0, j=markers.length; i<j; i += 300) {
        temparray = markers.slice(i,i+300);
        _markers.push(temparray);
     }
	
	jQuery(".gmwd_polygons .wd-pois-row:not(.wd-template)").each(function(){
		var polygon = jQuery(this).find("[name^=polygons_]").val();
		polygons.push(JSON.parse(polygon));
	});
	
	jQuery(".gmwd_polylines .wd-pois-row:not(.wd-template)").each(function(){
		var polyline = jQuery(this).find("[name^=polylines_]").val();
		polylines.push(JSON.parse(polyline));
	});	
     jQuery("[name^=main_markers]").remove();  
     
    for(var i=0; i<_markers.length; i++){
        jQuery("#adminForm").append('<input id="main_markers' + i + '" name="main_markers' + i + '" type="hidden" />');
        jQuery("[name=main_markers" + i + "]").val(JSON.stringify(_markers[i]));
    } 

    jQuery("#markers_count").val(chunk);

	jQuery("[name=polygons]").val(JSON.stringify(polygons));
	jQuery("[name=polylines]").val(JSON.stringify(polylines));


}

function poiPaginationFilter(e,obj){
	var key_code = (e.keyCode ? e.keyCode : e.which);
	if(jQuery(obj).is("input") && key_code != 13){
		return false;
	}
	jQuery(".gmwd_" + type).find(".wd-pagination-poi").show();
	var type = jQuery(obj).attr("data-type");
	
	var limit = Number(jQuery(".gmwd_" + type).find(".wd-pagination-poi").attr("data-limit"));
	
	if(!jQuery(obj).is("input") ){
		limit = limit + 20;
	}
	var data = {	
		'action': 'view_maps_pois',
		'task': 'display_pois',
		'page': 'maps_gmwd',
		'id': jQuery("#id").val(),
        "nonce_gmwd" : nonce
	};
	data['limit_' + type]  = limit;
	data['filter_by_' + type]  = jQuery(".filter_by_"+ type).val();

	jQuery.ajax({
        type: "POST",
        url: ajax_url,
		data : data,
        beforeSend: function(){
            jQuery(".gmwd_opacity_div").show();
        },
		success: function(response){
			jQuery(".gmwd_opacity_div").hide();
			var poisContainer = jQuery(response).find(".gmwd_" + type);
			
			jQuery(".gmwd_" + type).html(poisContainer.html());	
			jQuery(".gmwd_" + type).find(".wd-pagination-poi").attr("data-limit", limit);
			var total = Number(jQuery(".gmwd_" + type).find(".wd-pagination-poi").attr("data-total"));
			if(limit>=total ){				
				jQuery(".gmwd_" + type).find(".wd-pagination-poi").hide();
			}
			
			jQuery(".gmwd_" + type).find("input.filter_by_" + type).val(data['filter_by_' + type] );
			
		},
		failure: function (errorMsg) {
            alert(errorMsg);
        }, 
		error: function (errorMsg) {
            alert(errorMsg);
        }
	});

}

////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////