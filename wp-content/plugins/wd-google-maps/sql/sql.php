<?php
function gmwd_create_tables(){
    global $wpdb;

    $gmwd_maps = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_maps` (
        `id`                              INT(16) 	 NOT NULL AUTO_INCREMENT,
        `title`                           VARCHAR(256) NOT NULL,
        `width`                           VARCHAR(256) NOT NULL,
        `height`                          VARCHAR(256) NOT NULL,
        `center_address`                  VARCHAR(256) NOT NULL,
        `center_lat`                      VARCHAR(256) NOT NULL,
        `center_lng`                      VARCHAR(256) NOT NULL,
        `width_percent`                   VARCHAR(16)  NOT NULL,
        `map_alignment`                   VARCHAR(16)  NOT NULL,
        `border_radius`                   VARCHAR(16)  NOT NULL,
        `zoom_level`                      INT(16)      NOT NULL,
        `min_zoom`                        INT(16)      NOT NULL,
        `max_zoom`                        INT(16)      NOT NULL,
        `enable_zoom_control`             TINYINT(1)   NOT NULL,
        `zoom_control_position`           INT(16)      NOT NULL,
        `enable_map_type_control`         TINYINT(1)   NOT NULL,
        `map_type_control_position`       INT(16)      NOT NULL,
        `map_type_control_style`          INT(16)      NOT NULL,
        `enable_scale_control`            TINYINT(1)   NOT NULL,
        `enable_street_view_control`      TINYINT(1)   NOT NULL,
        `street_view_control_position`    INT(16)      NOT NULL,
        `enable_fullscreen_control`       TINYINT(1)   NOT NULL,
        `fullscreen_control_position`     INT(16)      NOT NULL,
        `enable_rotate_control`   		  TINYINT(1)   NOT NULL,
        `whell_scrolling`   			  TINYINT(1)   NOT NULL,
        `map_draggable`  			      TINYINT(1)   NOT NULL,
        `map_db_click_zoom`  			  TINYINT(1)   NOT NULL,
        `enable_directions`   			  TINYINT(1)   NOT NULL,
        `directions_window_open`   	      TINYINT(1)   NOT NULL,
        `info_window_open_on`   		  VARCHAR(16)  NOT NULL,
        `direction_position`   			  INT(16)      NOT NULL,
        `directions_window_width`   	  VARCHAR(16)  NOT NULL,
        `directions_window_width_unit`    VARCHAR(16)  NOT NULL,
        
        `enable_store_locator`   		  TINYINT(1)   NOT NULL,
        `store_locator_header_title`   	  VARCHAR(256) NOT NULL,              
        `store_locator_window_width`   	  VARCHAR(16)  NOT NULL,
        `store_locator_window_width_unit` VARCHAR(16)  NOT NULL,
        
        `store_locator_position`   		  VARCHAR(16)  NOT NULL,
        `restrict_to_country`   		  VARCHAR(256) NOT NULL,
        `distance_in`   				  VARCHAR(256) NOT NULL,
        `show_bouncing_icon`   			  TINYINT(1)   NOT NULL,
        `enable_bicycle_layer`   		  TINYINT(1)   NOT NULL,
        `enable_traffic_layer`   		  TINYINT(1)   NOT NULL,
        `enable_transit_layer`   		  TINYINT(1)   NOT NULL,
        `georss_url`   		              VARCHAR(256) NOT NULL,
        `kml_url`   		              VARCHAR(256) NOT NULL,
        `fusion_table_id`   		      VARCHAR(256) NOT NULL,

        `geolocate_user`   				  TINYINT(1)   NOT NULL,
        `marker_listing_type`   		  INT(16)      NOT NULL,
        `marker_list_position`   	      INT(16)      NOT NULL,
        `enable_category_filter`   		  TINYINT(1)   NOT NULL,

        `type`                            TINYINT(1)   NOT NULL,
        `marker_list_inside_map`          TINYINT(1)   NOT NULL,
        `marker_list_inside_map_position` INT(16)      NOT NULL,
        `advanced_info_window_position`   INT(16)      NOT NULL,
		
        `circle_line_color`               VARCHAR(256) NOT NULL,
        `circle_line_opacity`             VARCHAR(256) NOT NULL,
        `circle_fill_color`               VARCHAR(256) NOT NULL,
        `circle_fill_opacity`             VARCHAR(256) NOT NULL,
        `circle_line_width`               INT(16)      NOT NULL,
        `shortcode_id`                    INT(16)      NOT NULL,
        `theme_id`                        INT(16)      NOT NULL,
        `enable_searchbox`      	      TINYINT(1)   NOT NULL, 
        `searchbox_position`      	      INT(16)      NOT NULL, 
        `info_window_info`      	      VARCHAR(256) NOT NULL,        
        `published`      				  TINYINT(1)   NOT NULL DEFAULT '1', 

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_maps);
	
    $gmwd_mapstyles = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_mapstyles` (
        `id`             INT(16) 	  NOT NULL AUTO_INCREMENT,
        `title`          VARCHAR(256) NOT NULL,
        `styles`         LONGTEXT     NOT NULL,
        `image`          LONGTEXT     NOT NULL,

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
        
    $wpdb->query($gmwd_mapstyles);	

    $gmwd_options = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_options` (
        `id`             INT(16) 	 NOT NULL AUTO_INCREMENT,
        `name`           VARCHAR(256) NOT NULL,
        `value`          VARCHAR(256) NOT NULL,
        `default_value`  VARCHAR(256) NOT NULL,

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
        
    $wpdb->query($gmwd_options);

        
    $gmwd_markers = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_markers` (
        `id`                            INT(16) 	 NOT NULL AUTO_INCREMENT,
        `map_id`                        INT(16) 	 NOT NULL,
        `lat`                           VARCHAR(256) NOT NULL,
        `lng`                           VARCHAR(256) NOT NULL,
        `category`                      VARCHAR(256) NOT NULL,
        `title`                         VARCHAR(256) NOT NULL,
        `address`                       VARCHAR(256) NOT NULL,
        `animation`                     VARCHAR(16)  NOT NULL,
        `enable_info_window`            TINYINT(1)   NOT NULL,
        `info_window_open`              TINYINT(1)   NOT NULL,
        `marker_size`                   INT(16) 	 NOT NULL,
        `custom_marker_url`             VARCHAR(256) NOT NULL,
        `choose_marker_icon`            TINYINT(1)   NOT NULL,
        `description`                   LONGTEXT     NOT NULL,
        `link_url`                      VARCHAR(256) NOT NULL,
        `pic_url`                       VARCHAR(256) NOT NULL,
        `published`                     TINYINT(1)   NOT NULL,


        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_markers);

    $gmwd_marker_categories = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_markercategories` (
        `id`                            INT(16) 	 NOT NULL AUTO_INCREMENT,
        `title`                         VARCHAR(256) NOT NULL,
        `category_picture`              VARCHAR(256) NOT NULL,
        `parent`      					INT(16)    	 NOT NULL, 
        `level`      					INT(16)    	 NOT NULL, 
        `published`      				TINYINT(1)   NOT NULL, 

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_marker_categories);

    $gmwd_polygones = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_polygons` (
        `id`                            INT(16) 	 NOT NULL AUTO_INCREMENT,
        `map_id`                        INT(16) 	 NOT NULL,
        `title`                         VARCHAR(256) NOT NULL,
        `link`                          VARCHAR(256) NOT NULL,
        `line_width`                    VARCHAR(256) NOT NULL,
        `line_color`                    VARCHAR(256) NOT NULL,
        `line_opacity`                  VARCHAR(256) NOT NULL,
        `fill_color`                    VARCHAR(256) NOT NULL,
        `fill_opacity`                  VARCHAR(256) NOT NULL,
        `line_color_hover`              VARCHAR(256) NOT NULL,
        `line_opacity_hover`            VARCHAR(256) NOT NULL,
        `fill_color_hover`              VARCHAR(256) NOT NULL,
        `fill_opacity_hover`            VARCHAR(256) NOT NULL,
        `data`            				TEXT         NOT NULL,
        `show_markers`                  TINYINT(1)   NOT NULL,
        `enable_info_windows`           TINYINT(1)   NOT NULL,
        `published`      				TINYINT(1)   NOT NULL, 

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_polygones);
    
    $gmwd_rectangles = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_rectangles` (
        `id`                            INT(16) 	 NOT NULL AUTO_INCREMENT,
        `map_id`                        INT(16) 	 NOT NULL,
        `title`                         VARCHAR(256) NOT NULL,
        `link`                          VARCHAR(256) NOT NULL,
        `line_width`                    VARCHAR(256) NOT NULL,
        `line_color`                    VARCHAR(256) NOT NULL,
        `line_opacity`                  VARCHAR(256) NOT NULL,
        `fill_color`                    VARCHAR(256) NOT NULL,
        `fill_opacity`                  VARCHAR(256) NOT NULL,
        `line_color_hover`              VARCHAR(256) NOT NULL,
        `line_opacity_hover`            VARCHAR(256) NOT NULL,
        `fill_color_hover`              VARCHAR(256) NOT NULL,
        `fill_opacity_hover`            VARCHAR(256) NOT NULL,
        `south_west`            		VARCHAR(256) NOT NULL,
        `north_east`            		VARCHAR(256) NOT NULL,
        `show_markers`                  TINYINT(1)   NOT NULL ,
        `enable_info_windows`           TINYINT(1)   NOT NULL,
        `published`      				TINYINT(1)   NOT NULL, 

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_rectangles);   

    $gmwd_circles = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_circles` (
        `id`                            INT(16) 	 NOT NULL AUTO_INCREMENT,
        `map_id`                        INT(16) 	 NOT NULL,
        `title`                         VARCHAR(256) NOT NULL,
        `link`                          VARCHAR(256) NOT NULL,	
        `center_address`                VARCHAR(256) NOT NULL,
        `center_lat`                    VARCHAR(256) NOT NULL,
        `center_lng`                    VARCHAR(256) NOT NULL,
        `show_marker`                   TINYINT(1)   NOT NULL ,
        `radius`                        VARCHAR(256) NOT NULL,
        `line_width`                    VARCHAR(256) NOT NULL,
        `line_color`                    VARCHAR(256) NOT NULL,
        `line_opacity`                  VARCHAR(256) NOT NULL,
        `fill_color`                    VARCHAR(256) NOT NULL,
        `fill_opacity`                  VARCHAR(256) NOT NULL,
        `line_color_hover`              VARCHAR(256) NOT NULL,
        `line_opacity_hover`            VARCHAR(256) NOT NULL,
        `fill_color_hover`              VARCHAR(256) NOT NULL,
        `fill_opacity_hover`            VARCHAR(256) NOT NULL,
        `enable_info_window`            TINYINT(1)   NOT NULL,
        `published`      				TINYINT(1)   NOT NULL, 

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_circles);	


    $gmwd_polylines = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_polylines` (
        `id`                            INT(16) 	 NOT NULL AUTO_INCREMENT,
        `map_id`                        INT(16) 	 NOT NULL,
        `title`                         VARCHAR(256) NOT NULL,
        `line_width`                    VARCHAR(256) NOT NULL,
        `line_color`                    VARCHAR(256) NOT NULL,
        `line_opacity`                  VARCHAR(256) NOT NULL,
        `line_color_hover`              VARCHAR(256) NOT NULL,
        `line_opacity_hover`            VARCHAR(256) NOT NULL,
        `data`                          TEXT         NOT NULL,
        `show_markers`                  TINYINT(1)   NOT NULL ,
        `enable_info_windows`           TINYINT(1)   NOT NULL,
        `published`      				TINYINT(1)   NOT NULL DEFAULT '1', 

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_polylines);


    $gmwd_themes = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_themes` (
        `id`                                                    INT(16) 	 NOT NULL AUTO_INCREMENT,
        `title`                                                 VARCHAR(256) NOT NULL,
        `map_style_id`                                          INT(16)      NOT NULL,
        `map_style_code`                                        LONGTEXT     NOT NULL,
        `map_border_radius`                                     VARCHAR(16)  NOT NULL,        
        `directions_title_color`                                VARCHAR(16)  NOT NULL,
        `directions_window_background_color`                    VARCHAR(16)  NOT NULL,
        `directions_window_border_radius`                       VARCHAR(16)  NOT NULL,
        `directions_input_border_radius`                        VARCHAR(16)  NOT NULL,
        `directions_input_border_color`                         VARCHAR(16)  NOT NULL,
        `directions_label_color`                                VARCHAR(16)  NOT NULL,
        `directions_label_background_color`                     VARCHAR(16)  NOT NULL,
        `directions_label_border_radius`                        VARCHAR(16)  NOT NULL,
        `directions_button_width`                               VARCHAR(16)  NOT NULL,
        `directions_button_border_radius`                       VARCHAR(16)  NOT NULL,
        `directions_button_background_color`                    VARCHAR(16)  NOT NULL,
        `directions_button_color`                               VARCHAR(16)  NOT NULL,	
        `directions_button_alignment`                           TINYINT(1)   NOT NULL, 	
        `directions_columns`                                    TINYINT(1)   NOT NULL, 	
        `store_locator_title_color`                             VARCHAR(16)  NOT NULL,
        `store_locator_window_bgcolor`                          VARCHAR(16)  NOT NULL,
        `store_locator_window_border_radius`                    VARCHAR(16)  NOT NULL,
        `store_locator_input_border_radius`                     VARCHAR(16)  NOT NULL,
        `store_locator_input_border_color`                      VARCHAR(16)  NOT NULL,
        `store_locator_label_color`                             VARCHAR(16)  NOT NULL,
        `store_locator_label_background_color`                  VARCHAR(16)  NOT NULL,
        `store_locator_label_border_radius`                     VARCHAR(16)  NOT NULL,
        `store_locator_buttons_alignment`                       TINYINT(1)   NOT NULL, 
        `store_locator_button_width`                            VARCHAR(16)  NOT NULL,
        `store_locator_button_border_radius`                    VARCHAR(16)  NOT NULL,
        `store_locator_search_button_background_color`          VARCHAR(16)  NOT NULL,
        `store_locator_search_button_color`                     VARCHAR(16)  NOT NULL,
        `store_locator_reset_button_background_color`           VARCHAR(16)  NOT NULL,
        `store_locator_reset_button_color`                      VARCHAR(16)  NOT NULL,
        `store_locator_columns`                                 TINYINT(1)   NOT NULL, 
        `marker_listsing_basic_title_color`                     VARCHAR(16)  NOT NULL,
        `marker_listsing_basic_bgcolor`                         VARCHAR(16)  NOT NULL,
        `marker_listsing_basic_marker_title_color`              VARCHAR(16)  NOT NULL,
        `marker_listsing_basic_marker_desc_color`               VARCHAR(16)  NOT NULL,
        `marker_listsing_basic_dir_border_radius`      			VARCHAR(16)  NOT NULL,
        `marker_listsing_basic_dir_width`      			        VARCHAR(16)  NOT NULL,
        `marker_listsing_basic_dir_height`      			    VARCHAR(16)  NOT NULL,
        `marker_listsing_basic_dir_background_color`            VARCHAR(16)  NOT NULL,
        `marker_listsing_basic_dir_color`                       VARCHAR(16)  NOT NULL,
        `marker_advanced_title_color`                           VARCHAR(16)  NOT NULL,
        `marker_advanced_table_background`                      VARCHAR(16)  NOT NULL,
        `marker_advanced_table_border_radius`                   VARCHAR(16)  NOT NULL,
        `marker_advanced_table_color`                           VARCHAR(16)  NOT NULL,
        `marker_advanced_table_header_background`               VARCHAR(16)  NOT NULL,	
        `marker_advanced_table_header_color`                    VARCHAR(16)  NOT NULL,	
        `advanced_info_window_background`                       VARCHAR(16)  NOT NULL,
        `advanced_info_window_title_color`                      VARCHAR(16)  NOT NULL,
        `advanced_info_window_title_background_color`           VARCHAR(16)  NOT NULL,     
        `advanced_info_window_desc_color`                       VARCHAR(16)  NOT NULL,
        `advanced_info_window_dir_color`                        VARCHAR(16)  NOT NULL,
        `advanced_info_window_dir_background_color`             VARCHAR(16)  NOT NULL,
        `advanced_info_window_dir_border_radius`                VARCHAR(16)  NOT NULL,
        `carousel_item_height`                                  INT(16)      NOT NULL,
        `carousel_item_border_radius`                           INT(16)      NOT NULL,
        `carousel_items_count`                                  INT(16)      NOT NULL,
        `carousel_color`                                        VARCHAR(16)  NOT NULL,
        `carousel_background_color`                             VARCHAR(16)  NOT NULL,
        `carousel_hover_color`                                  VARCHAR(16)  NOT NULL,
        `carousel_hover_background_color`                       VARCHAR(16)  NOT NULL,
        `marker_listsing_inside_map_color`                      VARCHAR(16)  NOT NULL,
        `marker_listsing_inside_map_bgcolor`                    VARCHAR(16)  NOT NULL,
        `marker_listsing_inside_map_width`                      VARCHAR(16)  NOT NULL,
        `marker_listsing_inside_map_height`                     VARCHAR(16)  NOT NULL,
        `marker_listsing_inside_map_border_radius`              VARCHAR(16)  NOT NULL,
        `auto_generate_style_code`                              TINYINT(1)   NOT NULL, 
        `default`                                               TINYINT(1)   NOT NULL, 
        `published`                                             TINYINT(1)   NOT NULL DEFAULT '1', 

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_themes);

    $gmwd_shortcodes = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "gmwd_shortcodes` (
        `id`            INT(16) 	 NOT NULL AUTO_INCREMENT,
        `tag_text`      LONGTEXT     NOT NULL, 

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($gmwd_shortcodes);

    $exist_options = $wpdb->get_var('SELECT COUNT(id) FROM ' . $wpdb->prefix . 'gmwd_options');
    if(!$exist_options){
        $gmwd_options_insert = "INSERT INTO  `" . $wpdb->prefix . "gmwd_options` (`id`,  `name`, `value`, `default_value`) VALUES
        ('', 'map_api_key', '', '' ),
        ('', 'map_language', '', '' ),	
        ('', 'choose_marker_icon', '', '1' ),
        ('', 'marker_default_icon', '', '' ),	
        ('', 'center_address', '', 'New York, NY, United States' ),	
        ('', 'center_lat', '', '40.7127837' ),	
        ('', 'center_lng', '', '-74.00594130000002' ),	
        ('', 'zoom_level', '', '7' ),	
        ('', 'whell_scrolling', '', '0' ),	
        ('', 'map_draggable', '', '1' )	
        ";
        $wpdb->query($gmwd_options_insert);
    }
	
    if(!get_option("gmwd_version")){
        // insert map
   
        $gmwd_maps_insert = "INSERT INTO `" . $wpdb->prefix . "gmwd_maps` (`id`, `title`, `width`, `height`, `center_address`, `center_lat`, `center_lng`, `width_percent`, `map_alignment`, `border_radius`, `zoom_level`, `min_zoom`, `max_zoom`, `enable_zoom_control`, `zoom_control_position`, `enable_map_type_control`, `map_type_control_position`, `map_type_control_style`, `enable_scale_control`, `enable_street_view_control`, `street_view_control_position`, `enable_fullscreen_control`, `fullscreen_control_position`, `enable_rotate_control`, `whell_scrolling`, `map_draggable`, `map_db_click_zoom`, `enable_directions`, `directions_window_open`, `info_window_open_on`, `direction_position`, `directions_window_width`, `directions_window_width_unit`, `enable_store_locator`, `store_locator_window_width`, `store_locator_window_width_unit`, `store_locator_position`, `restrict_to_country`, `distance_in`, `show_bouncing_icon`, `enable_bicycle_layer`, `enable_traffic_layer`, `enable_transit_layer`, `georss_url`, `kml_url`, `fusion_table_id`, `geolocate_user`, `marker_listing_type`, `marker_list_position`, `enable_category_filter`, `type`, `marker_list_inside_map`, `marker_list_inside_map_position`, `advanced_info_window_position`, `circle_line_color`, `circle_line_opacity`, `circle_fill_color`, `circle_fill_opacity`, `circle_line_width`, `shortcode_id`, `theme_id`, `published`, `info_window_info`) 
        VALUES
        ('', 'My First Map', '100', '', 'R. do Celeiros 2, 7780, Portugal', '42.45362248301644', '-21.056485250000033', '%', 'left', '', 3, 2, 22, 1, 0, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 'click', 0, '100', '%', 1, '100', '%', '', '', 'km', 0, 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, '000', '0.6', '7FDF16', '0.3', 2, 1, 1, 1, 'title,address,desc,pic')";
    
        $wpdb->query($gmwd_maps_insert);
        
        // insert map markers
        $gmwd_markers_insert = "INSERT INTO `" . $wpdb->prefix . "gmwd_markers` (`id`, `map_id`, `lat`, `lng`, `category`, `title`, `address`, `animation`, `enable_info_window`, `info_window_open`, `marker_size`, `custom_marker_url`, `choose_marker_icon`, `description`, `link_url`, `pic_url`, `published`) VALUES
        ('', 1, '41.87194', '12.567379999999957', 0, 'Italia', 'Italia', 'DROP', 1, 0, 32, '', 1, '', '', '', 1),
        ('', 1, '40.6356899', '-73.60066499999999', 0, 'CIDNEY PHILLIPS, Washington Street, Baldwin, NY, United States', 'CIDNEY PHILLIPS, Washington Street, Baldwin, NY, United States', 'NONE', 1, 0, 32, '', 1, '', '', '', 1),
        ('', 1, '40.4167754', '-3.7037901999999576', 0, 'Madrid, España', 'Madrid, España', 'NONE', 1, 0, 32, '', 1, '', '', '', 1),
        ('', 1, '48.85661400000001', '2.3522219000000177', 0, 'Paris, France', 'Paris, France', 'DROP', 1, 0, 32, '', 1, '', '', '', 1),
        ('', 1, '51.5073509', '-0.12775829999998223', 0, 'London, UK', 'London, UK', 'NONE', 1, 0, 32, '', 1, '', '', '', 1),
        ('', 1, '39.9525839', '-75.16522150000003', 0, 'Philadelphia, PA, United States', 'Philadelphia, PA, United States', 'NONE', 1, 0, 32, '', 1, '', '', '', 1),
        ('', 1, '40.7127837', '-74.00594130000002', 0, 'New York, NY, United States', 'New York, NY, United States', 'BOUNCE', 1, 0, 32, '', 1, '', '', '', 1)";
        $wpdb->query($gmwd_markers_insert);
        
        //insert map polygons
        $gmwd_polygons_insert = "INSERT INTO `" . $wpdb->prefix . "gmwd_polygons` (`id`, `map_id`, `title`, `link`, `line_width`, `line_color`, `line_opacity`, `fill_color`, `fill_opacity`, `line_color_hover`, `line_opacity_hover`, `fill_color_hover`, `fill_opacity_hover`, `data`, `show_markers`, `enable_info_windows`, `published`) VALUES
        ('', 1, 'Polygon 1', '', '2', '0B0833', '0.8', '7AF6FF', '0.3', '000000', '0.9', 'FF0000', '0.4', '(48.28502057399577, -117.59765625),(37.51190453731693, -116.01562000000001),(37.37233994582321, -106.87499999999994),(50.3472131272189, -106.34764874999001),', 1, 0, 1),
        ('', 1, 'Polygon 2', '', '4', '072908', '0.8', '87FF1F', '0.3', '000000', '0.9', 'FF0000', '0.4', '(48.750756296177386, 8.96484375),(61.649466740560335, 26.19140625),(47.22143353240337, 42.714843700000074),', 0, 0, 1)";
        $wpdb->query($gmwd_polygons_insert);
        
        //insert map polylines
         $gmwd_polylines_insert = "INSERT INTO `" . $wpdb->prefix . "gmwd_polylines` (`id`, `map_id`, `title`, `line_width`, `line_color`, `line_opacity`, `line_color_hover`, `line_opacity_hover`, `data`, `show_markers`, `enable_info_windows`, `published`) VALUES
         ('', 1, 'Polyline', '3', '0C5413', '0.8', '000000', '0.9', '(-28.84226783718747, 17.40234375),(-18.393623895475326, 27.7734375),(-8.83893716666915, 34.27734375),(2.3751129338801293, 35.859375),(11.784014005457768, 33.3984375),(19.06471383653978, 25.48828125),', 0, 0, 1)";
         $wpdb->query($gmwd_polylines_insert);
         
         // insert map shortcode
         $gmwd_shortcode_insert = "INSERT INTO `" . $wpdb->prefix . "gmwd_shortcodes` (`id`, `tag_text`) VALUES (1, 'id=1 map=1')";
         $wpdb->query($gmwd_shortcode_insert);
        
       // insert map themes
        $gmwd_themes_insert = "INSERT INTO `" . $wpdb->prefix . "gmwd_themes` (`id`, `title`, `map_style_id`, `map_style_code`, `map_border_radius`, `directions_title_color`, `directions_window_background_color`, `directions_window_border_radius`, `directions_input_border_radius`, `directions_input_border_color`, `directions_label_color`, `directions_label_background_color`, `directions_label_border_radius`, `directions_button_width`, `directions_button_border_radius`, `directions_button_background_color`, `directions_button_color`, `directions_button_alignment`, `directions_columns`, `store_locator_title_color`, `store_locator_window_bgcolor`, `store_locator_window_border_radius`, `store_locator_input_border_radius`, `store_locator_input_border_color`, `store_locator_label_color`, `store_locator_label_background_color`, `store_locator_label_border_radius`, `store_locator_buttons_alignment`, `store_locator_button_width`, `store_locator_button_border_radius`, `store_locator_search_button_background_color`, `store_locator_search_button_color`, `store_locator_reset_button_background_color`, `store_locator_reset_button_color`, `store_locator_columns`, `marker_listsing_basic_title_color`, `marker_listsing_basic_bgcolor`, `marker_listsing_basic_marker_title_color`, `marker_listsing_basic_marker_desc_color`, `marker_listsing_basic_dir_border_radius`, `marker_listsing_basic_dir_width`, `marker_listsing_basic_dir_height`, `marker_listsing_basic_dir_background_color`, `marker_listsing_basic_dir_color`, `marker_advanced_title_color`, `marker_advanced_table_background`, `marker_advanced_table_border_radius`, `marker_advanced_table_color`, `marker_advanced_table_header_background`, `marker_advanced_table_header_color`, `advanced_info_window_background`, `advanced_info_window_title_color`, `advanced_info_window_title_background_color`, `advanced_info_window_desc_color`, `advanced_info_window_dir_color`, `advanced_info_window_dir_background_color`, `advanced_info_window_dir_border_radius`, `carousel_item_height`, `carousel_item_border_radius`, `carousel_items_count`, `carousel_color`, `carousel_background_color`, `carousel_hover_color`, `carousel_hover_background_color`, `marker_listsing_inside_map_color`, `marker_listsing_inside_map_bgcolor`, `marker_listsing_inside_map_width`, `marker_listsing_inside_map_height`, `marker_listsing_inside_map_border_radius`, `auto_generate_style_code`, `default`, `published`) VALUES
        ('', 'Default', 1, '', '', '000000', 'F2F2F2', '', '', '000000', '000000', 'F2F2F2', '', '100', '', '000000', 'FFFFFF', 0, 0, '000000', 'F2F2F2', '', '', '000000', '000000', 'F2F2F2', '', 0, '', '', '000000', 'FFFFFF', '000000', 'FFFFFF', 0, '000000', 'F2F2F2', '000000', '000000', '', '130', '30', '000000', 'FFFFFF', '000000', 'F2F2F2', '', '000000', '000000', 'FFFFFF', 'FFFFFF', '000000', 'F2F2F2', '000000', 'FFFFFF', '000000', '', 45, 0, 3, '000000', 'F2F2F2', 'F2F2F2', '000000', '000000', 'F2F2F2', '250', '', '', 1, 1, 1)";
		$wpdb->query($gmwd_themes_insert);
	}
}
?>