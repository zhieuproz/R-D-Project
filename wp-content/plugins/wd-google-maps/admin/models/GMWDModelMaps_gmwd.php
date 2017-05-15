<?php

class GMWDModelMaps_gmwd extends GMWDModel {
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
	public function get_row($id){
		global $wpdb;
        $id = (int)$id ;
		$row = parent::get_row_by_id($id);
     
		if($id){
            $row->info_window_info = explode(",",$row->info_window_info); 
			$limit_markers = isset($_POST["limit_markers"]) ? (int)$_POST["limit_markers"] : 20;	
			$limit_polygons = isset($_POST["limit_polygons"]) ? (int)$_POST["limit_polygons"] : 20;	
			$limit_polylines = isset($_POST["limit_polylines"]) ? (int)$_POST["limit_polylines"] : 20;
			
			$filter_by_markers = isset($_POST["filter_by_markers"]) ? esc_html(stripslashes($_POST["filter_by_markers"])) : "";
			$filter_by_polygons = isset($_POST["filter_by_polygons"]) ? esc_html(stripslashes($_POST["filter_by_polygons"])) : "";
			$filter_by_polylines = isset($_POST["filter_by_polylines"]) ? esc_html(stripslashes($_POST["filter_by_polylines"])) : "";
			
			$where_markers = "";
			if($filter_by_markers){
				$where_markers = " AND (address LIKE '%".$filter_by_markers."%' OR title LIKE '%".$filter_by_markers."%')";
			}
           
			$where_polygons = "";
			if($filter_by_polygons){
				$where_polygons = " AND title LIKE '%".$filter_by_polygons."%'";
			}	
			$where_polylines = "";
			if($filter_by_polylines){
				$where_polylines = " AND title LIKE '%".$filter_by_polylines."%'";
			}
            // markers
			$markers = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "gmwd_markers WHERE map_id= '".$id."' ".$where_markers." ORDER BY id DESC LIMIT 0,".$limit_markers );	
			$row_markers = array();
			foreach($markers as $marker){
                $marker->description = "";
                $marker->title = str_replace(array('"', '&quot;'),"@@@",$marker->title); 
                $marker->address = str_replace(array('"', '&quot;'),"@@@",$marker->address); 
				$row_markers[$marker->id] = $marker;			
			}
			$row->markers  = $row_markers;
            
			$all_markers = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "gmwd_markers WHERE map_id= '".$id."' ".$where_markers."");
            $row_all_markers = array();
			foreach($all_markers as $marker){
                $marker->description = "";
				$row_all_markers[$marker->id] = $marker;			
			}
			$row->all_markers = $row_all_markers;            
            $row->markers_count = count($all_markers);
            
                             			
            //polygons    
			$polygons = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "gmwd_polygons WHERE map_id= '".$id."' ".$where_polygons."  ORDER BY id DESC LIMIT 0,".$limit_polygons);
			$all_polygons = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "gmwd_polygons WHERE map_id= '".$id."' ".$where_polygons."");
            $row->polygons_count = count($all_polygons);
			$row_polygons = array();
			foreach($polygons as $polygon){
                $polygon->title = str_replace(array('"', '&quot;'),"@@@",$polygon->title); 
				$row_polygons[$polygon->id] = $polygon;			
			}
			$row->polygons = $row_polygons;
            
			$row_all_polygons = array();
			foreach($all_polygons as $polygon){
				$row_all_polygons[$polygon->id] = $polygon;			
			}
			$row->all_polygons = $row_all_polygons;            
			
            //polyline
			$polylines = $wpdb-> get_results("SELECT * FROM " . $wpdb->prefix . "gmwd_polylines WHERE map_id= '".$id."'  ".$where_polylines." ORDER BY id DESC LIMIT 0,".$limit_polylines);
			$all_polylines = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "gmwd_polylines WHERE map_id= '".$id."' ".$where_polylines."");
            $row->polylines_count = count($all_polylines);
			$row_polylines = array();
			foreach($polylines as $polyline){
				$row_polylines[$polyline->id] = $polyline;			
			}
			$row->polylines = $row_polylines;
			$row_all_polylines = array();
			foreach($all_polylines as $polyline){
                $polyline->title = str_replace(array('"', '&quot;'),"@@@",$polyline->title); 
				$row_all_polylines[$polyline->id] = $polyline;			
			}
			$row->all_polylines = $row_all_polylines;
            if($row->theme_id){   
                
                $map_theme_code = $wpdb->get_var($wpdb->prepare("SELECT map_style_code FROM ". $wpdb->prefix . "gmwd_themes WHERE id='%d'", $row->theme_id));
                $row->map_theme_code = $map_theme_code ? $map_theme_code : "[]";
            }
            else{
                $row->map_theme_code = "[]";
            }
		}
		else{
			$row->published = 1;
			$row->api_version = 3.22;
			$row->type = 0;
			$row->width = 100;
			$row->width_percent = "%";
			$row->center_address = gmwd_get_option("center_address") ;
			$row->center_lat = gmwd_get_option("center_lat");
			$row->center_lng = gmwd_get_option("center_lng");
			$row->zoom_level = gmwd_get_option("zoom_level");
			$row->min_zoom = 2;
			$row->max_zoom = 22;
			$row->whell_scrolling = gmwd_get_option("whell_scrolling");
			$row->map_draggable = gmwd_get_option("map_draggable");
			$row->map_language = "en";
			$row->info_window_open_on = "click";
			$row->geolocate_user = 0;
			$row->enable_zoom_control = 1;
			$row->enable_map_type_control = 1;
			$row->enable_scale_control = 1;
			$row->enable_street_view_control = 1;
			$row->enable_fullscreen_control = 0;
			$row->enable_rotate_control = 1;
			$row->enable_bicycle_layer = 0;
			$row->enable_traffic_layer = 0;
			$row->enable_transit_layer = 0;
			$row->circle_line_width = 2;
			$row->circle_line_color = "000";
			$row->circle_line_opacity = 0.6;
			$row->circle_fill_color = "7FDF16";
			$row->circle_fill_opacity = 0.3;	
			$row->store_locator_window_width = 100;
			$row->store_locator_window_width_unit = "%";
            $row->directions_window_width = 100;
            $row->directions_window_open = 1;
			$row->directions_window_width_unit = "%";
            $row->store_locator_header_title = "Store Locator";
            $row->info_window_info = array("title", "address", "desc", "pic");
            $map_theme_code = $wpdb->get_var("SELECT map_style_code FROM ". $wpdb->prefix . "gmwd_themes WHERE `default`='1'");
			$row->map_theme_code = $map_theme_code ? $map_theme_code : "[]";
            $row->theme_id = $wpdb->get_var("SELECT id FROM ". $wpdb->prefix . "gmwd_themes WHERE `default`='1'");            
            						
			$row->markers = array();
			$row->all_markers = array();
			$row->markers_count = 0;
			$row->polygons = array();
			$row->all_polygons = array();
			$row->polygons_count = 0;
			$row->polylines = array();
			$row->all_polylines = array();
			$row->polylines_count = 0;

		}
		return $row;
	}
	public function get_rows(){
		global $wpdb;
		$where = ((isset($_POST['search_value']) && (esc_html(stripslashes($_POST['search_value'])) != '')) ? 'WHERE title LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"'  : '');
		$asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'asc');
		$asc_or_desc = ($asc_or_desc != 'asc') ? 'desc' : 'asc';
		$order_by = ' ORDER BY ' . ((isset($_POST['order_by']) && esc_html(stripslashes($_POST['order_by'])) != '') ? esc_html(stripslashes($_POST['order_by'])) : 'id') . ' ' . $asc_or_desc;
		if (isset($_POST['page_number']) && $_POST['page_number']) {
		  $limit = ((int) $_POST['page_number'] - 1) * $this->per_page;
		}
		else {
		  $limit = 0;
		}
		// get rows
		$query = "SELECT id, title, published, shortcode_id  FROM " . $wpdb->prefix . "gmwd_maps ". $where . $order_by . " LIMIT " . $limit . ",".$this->per_page ;				
		$rows = $wpdb->get_results($query);
		
		return $rows;
	
	}
	public function page_nav() {
		global $wpdb;
		$where = ((isset($_POST['search_value']) && (esc_html(stripslashes($_POST['search_value'])) != '')) ? 'WHERE title LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"'  : '');
		$query = "SELECT COUNT(*) FROM " . $wpdb->prefix . "gmwd_maps " . $where;
		$total = $wpdb->get_var($query);
		$page_nav['total'] = $total;
		if (isset($_POST['page_number']) && $_POST['page_number']) {
			$limit = ((int) $_POST['page_number'] - 1) * $this->per_page;
		}
		else {
			$limit = 0;
		}
		$page_nav['limit'] = (int) ($limit / $this->per_page + 1);
		return $page_nav;
	}
    
    public function get_themes(){
		global $wpdb;
		// get rows
		$query = "SELECT T_THEMES.id, T_THEMES.title, T_THEMES.`default`, T_THEMES.map_style_code, T_MAP_STYLES.image  FROM " . $wpdb->prefix . "gmwd_themes AS T_THEMES LEFT JOIN " . $wpdb->prefix . "gmwd_mapstyles AS T_MAP_STYLES ON T_THEMES.map_style_id = T_MAP_STYLES.id WHERE T_THEMES.published = '1' ORDER BY T_THEMES.id";				
		$themes = $wpdb->get_results($query);

		return $themes;	
	}

	public function get_lists(){
		$lists = array();
		$map_alignment_list = array("left" => __("Left","gmwd"), "center" => __("Center","gmwd"), "right" => __("Right","gmwd"), "none" => __("None","gmwd"));
		$map_types_list = array( __("Roadmap","gmwd"),  __("Satellite","gmwd"),  __("Hybrid","gmwd"), __("Terrain","gmwd"));
		$map_markers_list = array(__("None","gmwd"), __("Basic Table","gmwd"),  __("Advanced Table","gmwd"),   __("Carousel","gmwd"));
		

		$map_type_control_styles_list = array( __("Default ","gmwd"), __("Horizontal Bar","gmwd"), __("Dropdown Menu","gmwd"));

        
        $map_positions = array( __("Top Left","gmwd"),__("Top Center","gmwd"), __("Top Right","gmwd"),__("Left Center","gmwd"),__("Left Top","gmwd"),__("Left Bottom","gmwd"),__("Right Top","gmwd"),__("Right Center","gmwd"),__("Right Bottom","gmwd"),__("Bottom Left","gmwd"),__("Bottom Center","gmwd"),__("Bottom Right","gmwd")); 
		
		
		$map_controls_positions_list = array_merge(array(  __("Default ","gmwd")), $map_positions);		
		$map_positions_list = array_merge(array(  __("Select ","gmwd")), $map_positions);
		
		$zoom_control_styles_list = array( __("Default ","gmwd"), __("Small","gmwd"), __("Large","gmwd"));
		
		$map_direction_positions_list = array( __("Top Left","gmwd"), __("Top Right","gmwd"), __("Bottom Left","gmwd"), __("Bottom Right","gmwd"));
			
		$lists["map_alignment"] = $map_alignment_list;
		$lists["map_types"] = $map_types_list;
		$lists["map_markers"] = $map_markers_list;
		$lists["map_type_control_styles"] = $map_type_control_styles_list;
		$lists["map_controls_positions"] = $map_controls_positions_list;
		$lists["map_positions"] = $map_positions_list;
		$lists["zoom_control_styles"] = $zoom_control_styles_list;
		$lists["map_direction_positions"] = $map_direction_positions_list;

		return $lists;
	
	}
	
	public function get_query_urls($map_id){
		
		$urls = array();
		$query_url =  admin_url('admin-ajax.php');
		//add markers url
		$query_url_marker = add_query_arg(array('action' => 'add_marker', 'page' => 'markers_gmwd', 'task' => 'edit', 'map_id' => $map_id, 'nonce_gmwd' => wp_create_nonce('nonce_gmwd')), $query_url);
		
		//add polygon url
		$query_url_polygon = add_query_arg(array('action' => 'add_polygon', 'page' => 'polygons_gmwd', 'task' => 'edit',  'map_id' => $map_id, 'nonce_gmwd' => wp_create_nonce('nonce_gmwd') ), $query_url);
		//add polyline url
		$query_url_polyline = add_query_arg(array('action' => 'add_polyline', 'page' => 'polylines_gmwd', 'task' => 'edit', 'map_id' => $map_id, 'nonce_gmwd' => wp_create_nonce('nonce_gmwd')), $query_url);

		$urls["marker"] = $query_url_marker;
		$urls["polygon"] = $query_url_polygon;
		$urls["polyline"] = $query_url_polyline;

		return $urls;
		
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