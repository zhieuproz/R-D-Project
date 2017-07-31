<?php

class GMWDViewShortcode_gmwd extends GMWDView{

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
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public function display() {	

        $shortcodes = $this->model->get_shortcodes();
        $max_short_code_id = $this->model->get_shortcode_max_id();
        
		wp_print_scripts('jquery');
		$maps = $this->model->get_maps();
        $whitelist = array( '127.0.0.1', '::1' );
        $is_localhost = in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ? 1 : 0;
        $map_api_url = "https://maps.googleapis.com/maps/api/js?libraries=places,geometry&v=3.exp";

        if(gmwd_get_option("map_language")){
            $map_api_url .= "&language=" . gmwd_get_option("map_language");
        }
        
        if(gmwd_get_option("map_api_key")){
            $map_api_url .= "&key=" . gmwd_get_option("map_api_key");
        }
		else{
			$api_keys = array("AIzaSyAmYQInD-coq0G5wC_D9h7uHjGeHhSSR4o", "AIzaSyBxiaSJPIRfQWID9j4hCrX3t7z-9IOOjis","	AIzaSyDi6aVWxOVptj9WZZYeAgdAA1xpqAR1mnw", "AIzaSyCzvhE5_lt5l0fYYChF1TpRtfFTjXpYkVI","AIzaSyBMWPhZdxcpwpfXBrGPGmz8zMjwJJt83mc");
			$map_api_url .= "&key=" . $api_keys[rand(0,4)];
		}        
	?>	

		<!--<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>	/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>-->
		<script src="<?php echo GMWD_URL . '/js/admin_main.js'; ?>" type="text/javascript"></script>
		<script src="<?php echo GMWD_URL . '/js/simple-slider.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo $map_api_url; ?>" type="text/javascript"></script>
		<script src="<?php echo GMWD_URL . '/js/init_map_admin.js'; ?>" type="text/javascript"></script>

        <?php if (get_bloginfo('version') >= '4.5') { ?>
        <link media="all" type="text/css" href="<?php echo get_admin_url(); ?>load-styles.php?c=1&dir=ltr&load%5B%5D=dashicons,admin-bar,common,forms,admin-menu,dashboard,list-tables,edit,revisions,media,themes,about,nav-menus,widgets,site-icon,&load%5B%5D=l10n,buttons,wp-auth-check,media-views" rel="stylesheet">
        <?php } 
        else{
        ?>
		<link media="all" type="text/css" href="<?php echo get_admin_url(); ?>load-styles.php?c=1&amp;dir=ltr&amp;load=admin-bar,wp-admin,dashicons,buttons,wp-auth-check" rel="stylesheet">
        <?php 
        }
        if (get_bloginfo('version') < '3.9') { ?>
		<link media="all" type="text/css" href="<?php echo get_admin_url(); ?>css/colors<?php echo ((get_bloginfo('version') < '3.8') ? '-fresh' : ''); ?>.min.css" id="colors-css" rel="stylesheet">
		<?php } ?>
		<link media="all" type="text/css" href="<?php echo GMWD_URL . '/css/admin_main.css'; ?>" rel="stylesheet">
		<link media="all" type="text/css" href="<?php echo GMWD_URL . '/css/simple-slider.css'; ?>" rel="stylesheet">
		<div class="" >
			
			<?php
				if (isset($_POST['tag_text'])) {
					echo '<script>top.tinyMCE.activeEditor.windowManager.close(window);</script>'; 
					die();
				}
			?>
			<h2 style="width:98%; margin: 0px auto 15px;"><?php _e("Google Maps WD","gmwd");?></h2>
			<form method="post" action="" id="adminForm">
                <?php wp_nonce_field('nonce_gmwd', 'nonce_gmwd'); ?>  
				<table class="shortcode_table" style="width:98%; margin: 0 auto;">
                    <tr>
                        <td class="wd-cell-valign-top">
                            <table>
                                <tr>
                                    <td style="width:32%"><label for="map"><?php _e("Select Map","gmwd");?>:</label></td>
                                    <td>
                                        <select name="map" id="map" onchange="onSelectMapChange(this);" style="width:200px;">
                                            <option value="0"><?php _e("-Select Map-","gmwd");?></option>
                                            <?php 
                                                foreach($maps as $key => $value){									
                                                    echo '<option value="'.$key.'" >'.$value.'</option>';
                                                }							
                                            ?>
                                        </select>
                                    </td>
                                </tr>                   						
                                <tr>
                                    <td colspan="2">
                                        <input type="button" id="wd_insert" name="" value="Insert" class="wd-btn wd-btn-primary" onClick="gmwdInsertShortcode();" />
                                        <input type="button" id="" name="" value="Cancel" class="wd-btn wd-btn-secondary" onClick="top.tinyMCE.activeEditor.windowManager.close(window);" />
                                    </td>
                                </tr>	                            
                            </table>
                        </td>
                        <td class="wd-cell-valign-top">
                            <div id="wd-map-container" style="width:500px; height:300px;">
                            </div>
                        </td>
                     </tr>   
					
				</table>			
				<input type="hidden" name="page" id="page" value="shortcode_gmwd">
				<input type="hidden" name="task" id="task" value="">
				<input type="hidden" name="id" id="id" value="">
				<input type="hidden" name="tag_text" id="tag_text" value="">
				<input type="hidden" name="insert" id="insert" value="">
			</form>	
		</div>
		<script>
            var centerLat,centerLng,zoom,mapType,maxZoom,minZoom,mapWhellScrolling,mapDragable,mapDbClickZoom, enableZoomControl,enableMapTypeControl,mapTypeControlOptions,enableScaleControl,enableStreetViewControl,enableFullscreenControl,enableRotateControl,           mapTypeControlPosition, fullscreenControlPosition,zoomControlPosition,streetViewControlPosition ,mapTypeControlStyle, mapBorderRadius, enableBykeLayer, enableTrafficLayer,enableTransitLayer,geoRSSURL,KMLURL, fusionTableId, mapMarkers,mapCircles,mapRectangles,mapPolygons,mapPolylines,mapTheme,GMWD_URL, enableDirections, markerListingType, markerDefaultIcon;
            
			jQuery("#id").val(<?php echo $max_short_code_id + 1;?>);
            gmwdShortcodeEdit();

            function onSelectMapChange(obj){
                var mapId = jQuery(obj).val();
				if(mapId){
					gmwdInitShortcodeMap(mapId);
				}
                else{
                    map = new google.maps.Map(document.getElementById("wd-map-container"), {
                        center: {lat: Number(<?php echo gmwd_get_option("center_lat");?>), lng: Number(<?php echo gmwd_get_option("center_lng");?>)},		
                        zoom: Number(<?php echo gmwd_get_option("zoom_level");?>)      
                    });                
                }
                
            }
            
            function gmwdInitShortcodeMap(mapId){
                var data = {};
                data.map = mapId;
                data.page = "maps_gmwd";
                data.task = "map_data";
                data.action = "map_data";
                data.ajax = 1;

                jQuery.post(ajax_url,  data, function (data){
					data = JSON.parse(data);
					zoom = Number(data.zoom_level);
					mapType = data.type;
					maxZoom = Number(data.max_zoom);
					minZoom = Number(data.min_zoom);
					mapWhellScrolling = Number(data.whell_scrolling) == 1 ? true : false;				
					mapDragable = Number(data.map_draggable) == 1 ? true : false;				
					mapDbClickZoom = Number(data.map_db_click_zoom) == 1 ? true : false;				
					enableZoomControl = Number(data.enable_zoom_control) == 1 ? true : false;
					enableMapTypeControl = Number(data.enable_map_type_control) == 1 ? true : false;			
					mapTypeControlOptions = {};
					enableScaleControl = Number(data.enable_scale_control) == 1 ? true : false;
					enableStreetViewControl = Number(data.enable_street_view_control) == 1 ? true : false;
					enableFullscreenControl = Number(data.enable_fullscreen_control) == 1 ? true : false;
					enableRotateControl = Number(data.enable_rotate_control) == 1 ? true : false;
					mapTypeControlPosition = Number(data.map_type_control_position);
					fullscreenControlPosition = Number(data.fullscreen_control_position);	
					zoomControlPosition = Number(data.zoom_control_position);
					streetViewControlPosition = Number(data.street_view_control_position);
					mapTypeControlStyle = Number(data.map_type_control_style);
					mapBorderRadius = data.border_radius;
					enableBykeLayer =  Number(data.enable_bicycle_layer);	
					enableTrafficLayer =  Number(data.enable_traffic_layer);				
					enableTransitLayer =  Number(data.enable_transit_layer);	
					geoRSSURL = data.georss_url;	
					KMLURL = data.kml_url;	
					fusionTableId = data.fusion_table_id;	
					mapMarkers = data.all_markers;
					mapCircles = data.all_circles;
					mapRectangles = data.all_rectangles;
					mapPolygons = data.all_polygons;
					mapPolylines = data.all_polylines;
					infoWindowInfo = data.info_window_info;

					centerLat = Number(data.center_lat);
					centerLng = Number(data.center_lng);	                  
					mapTheme = htmlspecialchars_decode(data.map_theme_code);

					GMWD_URL = "<?php echo GMWD_URL;?>";
					enableDirections = data.enable_directions;
					markerListingType = data.marker_listing_type;
					markerDefaultIcon = "<?php echo  gmwd_get_option("marker_default_icon");?>"; 
					gmwdInitMainMap("wd-map-container", false);                    
                });              
            }
            
			function gmwdShortcodeEdit(){
            
                var shortcodeParams = gmwdShortcodeParams();

                if( shortcodeParams != false ){
              
                    for(param in shortcodeParams){
                        if(jQuery("#" + param).is("input[type=checkbox]") || jQuery("#" + param).is("input[type=radio]") ){
                            jQuery("#" + param).removeAttr("checked");
                            jQuery("#" + param + "[value='" + shortcodeParams[param] + "']").attr("checked","checked");     			
                        }
                        else if(jQuery("#" + param).is("select")){
                            jQuery("#" + param + " option").removeAttr("selected");
                            jQuery("#" + param).find("[value='" + shortcodeParams[param] + "']").attr("selected","selected");
                        }
                        else {
                            jQuery("#" + param).val(shortcodeParams[param]);
                        } 
                    }
                    jQuery("#wd_insert").val("Update");
                    jQuery("#insert").val(0);
                    gmwdInitShortcodeMap(jQuery("#map :selected").val());
                }
                else{
                    map = new google.maps.Map(document.getElementById("wd-map-container"), {
                        center: {lat: Number(<?php echo gmwd_get_option("center_lat");?>), lng: Number(<?php echo gmwd_get_option("center_lng");?>)},		
                        zoom: Number(<?php echo gmwd_get_option("zoom_level");?>)      
                    });                
                    jQuery("#wd_insert").val("Insert");
                    jQuery("#insert").val(1);
                }                
            }
            
            function gmwdShortcodeParams(){
                var params = {};
                
                //var editorText = tinyMCE.activeEditor.selection.getContent();
                var editorText = top.tinyMCE.activeEditor.selection.getContent();
                var start = editorText.indexOf("[Google_Maps_WD");
                var end = editorText.indexOf("]", start);
                var shortcodes = [];

                <?php foreach($shortcodes as $shortcode){
                ?>
                    shortcodes[<?php echo $shortcode->id;?>] = "<?php echo $shortcode->tag_text;?>";
                <?php
                }
                ?>
               
                if (start > -1 && end >-1 ) {
              
                    currentIdStr = editorText.substring(start + 1, end);
                    currentIdStr = currentIdStr.substring(currentIdStr.indexOf(" ") + 1);
                    console.log(currentIdStr);
                    currentIdArray = currentIdStr.split("=");  
                    var currentId =  currentIdArray[1].substring(0, currentIdArray[1].indexOf(" "));                                  
                    jQuery("#id").val(currentId);
                    paramsText = shortcodes[currentId]; 
          
                    paramsArray = paramsText.split(" "); 
                    for(var j=0; j<paramsArray.length; j++){
                        var param = paramsArray[j].split("=");
                        params[param[0]] = param[1];
                    }                    
                   
                    return params;                     
                }

                return false;            
            }
            
			function gmwdInsertShortcode(){
				var plugin_url = '<?php echo GMWD_URL; ?>'
				var short_code = '[Google_Maps_WD '; 
                
				var tagText = "id=" + jQuery("#id").val() + " map=" + jQuery("#map :selected").val();
                
                short_code = short_code + tagText + ']';
                
                short_code = short_code.replace(/\[Google_Maps_WD([^\]]*)\]/g, function(d, c) {                             
                     return '<img src="' + plugin_url + '/images/icon-map-50.png" alt="Google_Maps_WD id=' + jQuery("#id").val() + ' map='+ jQuery("#map :selected").val() + '" title="Google_Maps_WD id=' + jQuery("#id").val() + ' map='+ jQuery("#map :selected").val() + '" class="gmwd_shortcode mceItem" >';                         
                });
                               
                //window.parent.tinyMCE.DOM.encode(c)

                jQuery("#page").val("shortcode_gmwd");
                jQuery("#task").val("save");

                jQuery("#tag_text").val(tagText);
                jQuery("#adminForm").submit();
                
                //window.tinyMCE.execCommand('mceInsertContent', false, short_code);
                top.tinyMCE.execCommand('mceInsertContent', false, short_code);
                //top.tinyMCEPopup.editor.execCommand('mceRepaint');                              
			}

            
            jQuery("[data-slider]").each(function () {
			  var input = jQuery(this);
			  jQuery("<span>").addClass("output").insertAfter(jQuery(this));  
			}).bind("slider:ready slider:changed", function (event, data) {   
			  jQuery(this) .nextAll(".output:first").html(data.value.toFixed(1));   
			});
			
		

		</script>			
	
	<?php  
	die();
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
}