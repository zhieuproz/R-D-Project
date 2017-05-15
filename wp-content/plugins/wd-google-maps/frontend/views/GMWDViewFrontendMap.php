<?php
	
class GMWDViewFrontendMap extends GMWDViewFrontend{
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
	public function display(){

		$params = $this->model->params;
        $shortcode_id = $params["id"]; 
		$row = $this->model->get_map();

        if($row){
            $overlays = $this->model->get_overlays($row->id);
            $theme_id = GMWDHelper::get("f_p") == 1 ?  GMWDHelper::get("theme_id") : $row->theme_id;
            $theme = $this->model->get_theme($theme_id); 
            $map_alignment =  $row->map_alignment == "right" ? "wd-right" : "" ; 
            $map_center =  $row->map_alignment == "center" ?  "margin-right:auto; margin-left:auto;" : "";            
		?>

        <div class="gmwd_container_wrapper">
            <div class="gmwd_container">
                <div id="gmwd_container_1">
                    <script>
                        if(typeof gmwdmapData == 'undefined'){
                            var gmwdmapData = []; 
                        }                
                        
                        gmwdmapData["widget" + '<?php echo $shortcode_id;?>'] = "<?php isset($params["widget"]) ? 1 : 0; ?>";                   
                        gmwdmapData["mapId" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->id; ?>");                   
                        gmwdmapData["centerLat" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->center_lat; ?>");
                        gmwdmapData["centerLng" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->center_lng; ?>");	
                        gmwdmapData["zoom" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->zoom_level; ?>");
                        gmwdmapData["mapType" + '<?php echo $shortcode_id;?>'] = "<?php echo $row->type; ?>";
                        gmwdmapData["maxZoom" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->max_zoom; ?>");
                        gmwdmapData["minZoom" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->min_zoom; ?>");
                        gmwdmapData["mapWhellScrolling" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->whell_scrolling; ?>") == 1 ? true : false;				
                        gmwdmapData["infoWindowOpenOn" + '<?php echo $shortcode_id;?>'] = "<?php echo $row->info_window_open_on; ?>" ;				
                        gmwdmapData["mapDragable" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->map_draggable; ?>") == 1 ? true : false;	
    
                        gmwdmapData["mapDbClickZoom" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->map_db_click_zoom; ?>") == 1 ? true : false;	
                                    
                        gmwdmapData["enableZoomControl" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->enable_zoom_control; ?>") == 1 ? true : false;
                        gmwdmapData["enableMapTypeControl" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->enable_map_type_control; ?>") == 1 ? true : false;			
                        gmwdmapData["mapTypeControlOptions" + '<?php echo $shortcode_id;?>'] = {};
                        
                        gmwdmapData["enableScaleControl" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->enable_scale_control; ?>") == 1 ? true : false;
                        gmwdmapData["enableStreetViewControl" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->enable_street_view_control; ?>") == 1 ? true : false;
                        gmwdmapData["enableFullscreenControl" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->enable_fullscreen_control; ?>") == 1 ? true : false;
                        gmwdmapData["enableRotateControl" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->enable_rotate_control; ?>") == 1 ? true : false;
                        gmwdmapData["mapTypeControlPosition" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->map_type_control_position; ?>");
                        
                        gmwdmapData["zoomControlPosition" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->zoom_control_position; ?>");
                        gmwdmapData["streetViewControlPosition" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->street_view_control_position; ?>");
                        
                        gmwdmapData["fullscreenControlPosition" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->fullscreen_control_position; ?>");
                        
                        gmwdmapData["mapTypeControlStyle" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->map_type_control_style; ?>");				
                        gmwdmapData["mapBorderRadius" + '<?php echo $shortcode_id;?>'] = "<?php echo $row->border_radius; ?>";
                        gmwdmapData["enableBykeLayer" + '<?php echo $shortcode_id;?>'] =  Number("<?php echo $row->enable_bicycle_layer; ?>");	
                        gmwdmapData["enableTrafficLayer" + '<?php echo $shortcode_id;?>'] =  Number("<?php echo $row->enable_traffic_layer; ?>");				
                        gmwdmapData["enableTransitLayer" + '<?php echo $shortcode_id;?>'] =  Number("<?php echo $row->enable_transit_layer; ?>");	
                        gmwdmapData["geoRSSURL" + '<?php echo $shortcode_id;?>'] = "<?php echo $row->georss_url; ?>";	
                        gmwdmapData["KMLURL" + '<?php echo $shortcode_id;?>'] = "<?php echo $row->kml_url; ?>";	
                        gmwdmapData["fusionTableId" + '<?php echo $shortcode_id;?>'] = '<?php echo $row->fusion_table_id; ?>';	
                
                        gmwdmapData["mapTheme" + '<?php echo $shortcode_id;?>'] = '<?php echo stripslashes(htmlspecialchars_decode ($theme->map_style_code)) ;?>';			
                        gmwdmapData["mapMarkers" + '<?php echo $shortcode_id;?>'] = JSON.parse('<?php echo $overlays->all_markers ? json_encode($overlays->all_markers) : "[]";?>');

                        gmwdmapData["mapPolygons" + '<?php echo $shortcode_id;?>'] =  JSON.parse('<?php echo $overlays->polygons ?json_encode($overlays->polygons) : "[]";?>');
                        gmwdmapData["mapPolylines" + '<?php echo $shortcode_id;?>'] = JSON.parse('<?php echo $overlays->polylines ? json_encode($overlays->polylines) : "[]";?>');
                        
                        gmwdmapData["enableCategoryFilter" + '<?php echo $shortcode_id;?>'] = "<?php echo  $row->enable_category_filter;?>";
                        
                        gmwdmapData["enableDirections" + '<?php echo $shortcode_id;?>'] = "<?php echo  isset($params["widget"]) ? 0 : $row->enable_directions;?>";
                        gmwdmapData["enableStoreLocatior" + '<?php echo $shortcode_id;?>'] = "<?php echo  $row->enable_store_locator;?>";
                        gmwdmapData["storeLocatorDistanceIn" + '<?php echo $shortcode_id;?>'] = "<?php echo $row->distance_in;?>";
                        
                        gmwdmapData["storeLocatorStrokeWidth" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->circle_line_width;?>");
                        gmwdmapData["storeLocatorFillColor" + '<?php echo $shortcode_id;?>'] = "#" + "<?php echo $row->circle_fill_color;?>";
                        gmwdmapData["storeLocatorFillOpacity" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->circle_fill_opacity;?>");
                        gmwdmapData["storeLocatorLineColor" + '<?php echo $shortcode_id;?>'] = "#" + "<?php echo $row->circle_line_color;?>";
                        gmwdmapData["storeLocatorLineOpacity" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->circle_line_opacity;?>");
                        
                        gmwdmapData["markerListingType" + '<?php echo $shortcode_id;?>'] = "<?php echo  $row->marker_listing_type;?>";
                        gmwdmapData["markerListInsideMap" + '<?php echo $shortcode_id;?>'] = "<?php echo  $row->marker_list_inside_map;?>";
                        gmwdmapData["markerListPosition" + '<?php echo $shortcode_id;?>'] = Number("<?php echo  $row->marker_list_inside_map_position;?>");
                        gmwdmapData["infoWindowInfo" + '<?php echo $shortcode_id;?>'] = "<?php echo $row->info_window_info;?>";
                        gmwdmapData["advancedInfoWindowPosition" + '<?php echo $shortcode_id;?>'] = Number("<?php echo  $row->advanced_info_window_position ? $row->advanced_info_window_position : 10 ;?>");
                        gmwdmapData["geolocateUser" + '<?php echo $shortcode_id;?>'] = Number("<?php echo $row->geolocate_user;?>");
                        gmwdmapData["items" + '<?php echo $shortcode_id;?>'] = "<?php echo $theme->carousel_items_count;?>";
                        
                        gmwdmapData["enableSerchBox" + '<?php echo $shortcode_id;?>'] = "<?php echo $row->enable_searchbox;?>";
                        gmwdmapData["serchBoxPosition" + '<?php echo $shortcode_id;?>'] = Number("<?php echo  $row->searchbox_position ? $row->searchbox_position : 3 ;?>");
                        
                        gmwdmapData["allMarkers" + '<?php echo $shortcode_id;?>'] = [];       
                        gmwdmapData["allPolygons" + '<?php echo $shortcode_id;?>'] = [];
                        gmwdmapData["allPolygonMarkers" + '<?php echo $shortcode_id;?>'] = [];
                        gmwdmapData["allPolylines" + '<?php echo $shortcode_id;?>'] = [];
                        gmwdmapData["allPolylineMarkers" + '<?php echo $shortcode_id;?>'] = [];
                        gmwdmapData["infoWindows" + '<?php echo $shortcode_id;?>'] = [];
                        gmwdmapData["ajaxData" + '<?php echo $shortcode_id;?>']  = {};
                        
                        var ajaxURL = "<?php echo admin_url('admin-ajax.php');?>";
                        var markerDefaultIcon = "<?php echo  gmwd_get_option("marker_default_icon");?>";
                        var GMWD_URL = "<?php echo GMWD_URL;?>";
                        jQuery( document ).ready(function() {					
                            gmwdInitMainMap("wd-map<?php echo $shortcode_id;?>",false, '<?php echo $shortcode_id;?>');
                            gmwdReadyFunction('<?php echo $shortcode_id;?>');
                        });
                    </script>

                    <?php
                        if(!isset($params["widget"])){
                            //store locator
                            if(($row->store_locator_position == 0 || $row->store_locator_position == 1) && $row->enable_store_locator == 1){						
                                $this->display_store_locator($row, $theme, $shortcode_id);				
                            }

                        }				
                    ?>
                    <div class="wd-clear">
                        <div id="wd-map<?php echo $shortcode_id;?>" class="wd-row <?php echo $map_alignment;?>" style="<?php echo $map_center;?> height:<?php echo $row->height ;?>px; width:<?php echo $row->width.$row->width_percent;?>"></div>
                    </div>
                    <?php
                        if(!isset($params["widget"])){
                                       
                            //store locator
                            if(($row->store_locator_position == 2 || $row->store_locator_position == 3) && $row->enable_store_locator == 1){						
                                $this->display_store_locator($row, $theme, $shortcode_id);				
                            }
                        }
            
                    ?>
                            
                </div>
            </div>
		</div>
		<?php
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////

	private function display_store_locator($row, $theme, $shortcode_id){
        $class_columns_first =  $theme->store_locator_columns == 0 ? "col-lg-12 col-md-12 col-sm-12 col-xs-12" : "col-lg-7 col-md-7 col-sm-12 col-xs-12";
        $class_columns_second =  $theme->store_locator_columns == 0 ? "col-lg-12 col-md-12 col-sm-12 col-xs-12" : "col-lg-5 col-md-5 col-sm-12 col-xs-12";
        $btn_alignment_class = $theme->store_locator_buttons_alignment == 0 ? "wd-text-left" : ($theme->store_locator_buttons_alignment == 1 ? "wd-text-center" : "wd-text-right");
	?>
		<style>
		.gmwd_store_locator_container<?php echo $shortcode_id;?>{
			width:<?php echo  $row->store_locator_window_width ? $row->store_locator_window_width .$row->store_locator_window_width_unit : "auto";?>!important;
			float:<?php echo $row->store_locator_position == 1 || $row->store_locator_position == 3 ? "right" : "left";?>;
            background:#<?php echo $theme->store_locator_window_bgcolor;?>!important;
            padding:5px;
            border-radius:<?php echo $theme->store_locator_window_border_radius ? $theme->store_locator_window_border_radius : 0 ;?>px!important;
		}
		.gmwd_store_locator_title<?php echo $shortcode_id;?>{
			color:#<?php echo $theme->store_locator_title_color;?>!important;
            margin:5px 0px !important;
		}
		.gmwd_store_locator_address<?php echo $shortcode_id;?>, .gmwd_store_locator_radius<?php echo $shortcode_id;?>{
			border-radius:<?php echo $theme->store_locator_input_border_radius;?>px!important;
			border-color:#<?php echo $theme->store_locator_input_border_color;?>!important;
			padding:5px!important;
		
		}
		.gmwd_store_locator_container<?php echo $shortcode_id;?> .gmwd_store_locator_label{
			color:#<?php echo $theme->store_locator_label_color;?>!important;
			background:#<?php echo $theme->store_locator_label_background_color;?>!important;
            border-radius:<?php echo $theme->store_locator_label_border_radius ? $theme->store_locator_label_border_radius : 0 ;?>px!important;
			padding: 1px 5px!important;
			display:block;
			width:120px;
            margin-right: 8px;
		}
		#gmwd_store_locator_search<?php echo $shortcode_id;?>, #gmwd_store_locator_reset<?php echo $shortcode_id;?>{
			border-radius:<?php echo $theme->store_locator_button_border_radius ? $theme->store_locator_button_border_radius : 0;?>px!important;
            width:<?php echo $theme->store_locator_button_width ? $theme->store_locator_button_width."px" : "auto"; ?>!important;
            padding:3px 15px !important;
            border: 0!important;
		}
		#gmwd_store_locator_search<?php echo $shortcode_id;?>{			
			background:#<?php echo $theme->store_locator_search_button_background_color;?>!important;
			color:#<?php echo $theme->store_locator_search_button_color;?>!important;
		}
		#gmwd_store_locator_reset<?php echo $shortcode_id;?>{
			background:#<?php echo $theme->store_locator_reset_button_background_color;?>!important;
			color:#<?php echo $theme->store_locator_reset_button_color;?>!important;
		}
        .gmwd_categories {
            padding:0 !important;
        }
		</style>
        <div class="wd-clear">
            <div class="gmwd_store_locator_container gmwd_store_locator_container<?php echo $shortcode_id;?> wd-clear">
                <h3 class="gmwd_store_locator_title<?php echo $shortcode_id;?>"><?php echo $row->store_locator_header_title ? $row->store_locator_header_title : __("Store Locator","gmwd");?></h3>
                <div class="container">
                    <div class="row">
                        <div class="<?php echo $class_columns_first;?>">
                            <div class="wd-clear wd-row">
                                <div class="wd-left">
                                    <label for="gmwd_store_locator_address<?php echo $shortcode_id;?>" class="gmwd_store_locator_label"><?php _e("Address","gmwd");?></label>
                                </div>
                                <div class="wd-left">
                                    <input type="text" id="gmwd_store_locator_address<?php echo $shortcode_id;?>" autocomplete="off" class="gmwd_store_locator_address<?php echo $shortcode_id;?>" >                               
                                </div>
                                <div class="wd-left">
                                    <span class="gmwd_my_location gmwd_my_location_store_locator<?php echo $shortcode_id;?>"><i title="<?php _e("Get My Location","gmwd");?>" class=""></i></span>                                
                                </div>	                                
                            </div>				
                            <div class="wd-clear">
                                <div class="wd-left">
                                    <label for="gmwd_store_locator_radius<?php echo $shortcode_id;?>" class="gmwd_store_locator_label"><?php _e("Radius","gmwd");?>
                                </div>
                                <div class="wd-left">
                                    <select class="gmwd_store_locator_radius<?php echo $shortcode_id;?>" id="gmwd_store_locator_radius<?php echo $shortcode_id;?>">                                  
                                        <option value="1">1<?php echo $row->distance_in;?></option>                 
                                        <option value="5">5<?php echo $row->distance_in;?></option>                
                                        <option value="10" selected="">10<?php echo $row->distance_in;?></option>      
                                        <option value="25">25<?php echo $row->distance_in;?></option>                
                                        <option value="50">50<?php echo $row->distance_in;?></option>                
                                        <option value="75">75<?php echo $row->distance_in;?></option>              
                                        <option value="100">100<?php echo $row->distance_in;?></option>             
                                        <option value="150">150<?php echo $row->distance_in;?></option>            
                                        <option value="200">200<?php echo $row->distance_in;?></option>         
                                        <option value="300">300<?php echo $row->distance_in;?></option>         
                                    </select>
                                </div>						
                            </div>
                        </div>	
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php echo $btn_alignment_class;?>">
                            <button id="gmwd_store_locator_search<?php echo $shortcode_id;?>"><?php _e("Search","gmwd");?></button>
                            <button id="gmwd_store_locator_reset<?php echo $shortcode_id;?>"><?php _e("Reset","gmwd");?></button>
                        </div>						
                    </div>
                </div>	
            </div>		
		</div>		
	
	<?php
	}

	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}