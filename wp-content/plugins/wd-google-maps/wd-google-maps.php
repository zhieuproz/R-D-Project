<?php

/**
 * Plugin Name: Google Maps WD
 * Plugin URI: https://web-dorado.com/products/wordpress-google-maps-plugin.html
 * Description: Google Maps WD is an intuitive tool for creating Google maps with advanced markers, custom layers and overlays for   your website.
 * Version: 1.0.43
 * Author: WebDorado
 * Author URI: http://web-dorado.com/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 
define('GMWD_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('GMWD_NAME', plugin_basename(dirname(__FILE__)));
define('GMWD_URL', plugins_url(plugin_basename(dirname(__FILE__))));
define('GMWD_MAIN_FILE', plugin_basename(__FILE__));

require_once( GMWD_DIR. '/framework/functions.php' );
if ( is_admin() ) {
	require_once( 'gmwd_admin_class.php' );
    register_activation_hook(__FILE__, array('GMWDAdmin', 'gmwd_activate'));
	add_action( 'plugins_loaded', array('GMWDAdmin', 'gmwd_get_instance'));

    add_action('wp_ajax_add_marker',  array('GMWDAdmin', 'gmwd_ajax'));
    add_action('wp_ajax_download_markers',  array('GMWDAdmin', 'gmwd_ajax'));
    add_action('wp_ajax_select_marker_icon', array('GMWDAdmin', 'gmwd_ajax'));
    add_action('wp_ajax_marker_size', array('GMWDAdmin', 'gmwd_ajax'));
    add_action('wp_ajax_add_polygon', array('GMWDAdmin', 'gmwd_ajax'));
    add_action('wp_ajax_add_polyline', array('GMWDAdmin', 'gmwd_ajax'));
    add_action('wp_ajax_add_circle', array('GMWDAdmin', 'gmwd_ajax'));
    add_action('wp_ajax_add_rectangle', array('GMWDAdmin', 'gmwd_ajax'));

}

require_once( 'gmwd_class.php' );

add_action( 'plugins_loaded', array('GMWD', 'gmwd_get_instance'));


add_action('wp_ajax_get_ajax_markers', array('GMWD','gmwd_frontend'));
add_action('wp_ajax_nopriv_get_ajax_markers', array('GMWD','gmwd_frontend'));
add_action('wp_ajax_get_ajax_store_loactor', array('GMWD','gmwd_frontend'));
add_action('wp_ajax_nopriv_get_ajax_store_loactor', array('GMWD','gmwd_frontend'));

function gmwd_map($shortcode_id, $map_id ){
    GMWD::gmwd_get_instance();
    $params = array();
    $params ['map'] = $map_id;
    $params ['id'] = $shortcode_id;

    $map_controller = new GMWDControllerFrontendMap($params);
    $map_controller->display();
}
require_once( GMWD_DIR. '/widgets.php' );


function wd_gmwd_init(){
	if( !isset($_REQUEST['ajax']) && is_admin() ){
		if( !class_exists("DoradoWeb") ){
			require_once(GMWD_DIR . '/wd/start.php');
		}
		global $gmwd_options;
		$gmwd_options = array (
			"prefix" => "gmwd",
			"wd_plugin_id" => 147,
			"plugin_title" => "Google Maps WD", 
			"plugin_wordpress_slug" => "wd-google-maps", 
			"plugin_dir" => GMWD_DIR,
			"plugin_main_file" => __FILE__,  
			"description" => __('Plugin for creating Google maps with advanced markers, custom layers and overlays for   your website.', 'gmwd'), 
		   // from web-dorado.com
		   "plugin_features" => array(
				0 => array(
					"title" => __("Easy set up", "gmwd"),
					"description" => __("After installation a set-up guide will help you configure general options and get started on the dashboard. The plugin also displays tooltips in the whole admin area and settings. Moreover, you get instant live previews of changes you make in the working area, so you don’t have to save and publish maps to see the results.", "gmwd"),
				),
				1 => array(
					"title" => __("Unlimited Everything", "gmwd"),
					"description" => __("Display unlimited maps on any page or post. Same is true for markers, rectangles, circles, polygons and polylines.", "gmwd"),
				),
				2 => array(
					"title" => __("100+ Marker Icons", "gmwd"),
					"description" => __("Choose from 100+ readymade marker icons with different shapes and colors. Can’t find what you need? Create your own icons with the icon marker editor, setting background color and icon color or upload your own image.", "gmwd"),
				),
				3 => array(
					"title" => __("Beautiful Maps Theme", "gmwd"),
					"description" => __("Select or create a beautiful map theme that best fits your business and website needs. Choose from readymade themes or design your own map skin, by using the advanced editor.", "gmwd"),
				), 
				4 => array(
					"title" => __("Multilevel Marker Categories", "gmwd"),
					"description" => __("Do you have a large number of markers on locations? Then the marker clustering option is for you! Add multiple marker categories and subcategories. Assign categories to markers quickly and easily by choosing from a dropdown menu.", "gmwd"),
				)                     
		   ),
		   // user guide from web-dorado.com
		   "user_guide" => array(
				0 => array(
					"main_title" => __("Installation Wizard/ Options Menu", "gmwd"),
					"url" => "https://web-dorado.com/wordpress-google-maps/installation-wizard-options-menu.html",
					"titles" => array(
						array(
							"title" => __("Configuring Map API Key", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/installation-wizard-options-menu/configuring-api-key.html"
						) 
					)
				),
				1 => array(
					"main_title" => __("Creating Map", "gmwd"),
					"url" => "https://web-dorado.com/wordpress-google-maps/creating-map.html",
					"titles" => array()
				),
				2 => array(
					"main_title" => __("Settings", "gmwd"),
					"url" => "https://web-dorado.com/wordpress-google-maps/settings.html",
					"titles" => array(
						array(
							"title" => __("General", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/settings/general.html",
						),
						array(
							"title" => __("Controls", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/settings/controls.html",
						), 
						array(
							"title" => __("Layers", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/settings/layers.html",
						),					
						array(
							"title" => __("Directions", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/settings/directions.html",
						),
						array(
							"title" => __("Store Locator", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/settings/store-locator.html",
						),
						array(
							"title" => __("Marker Listing", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/settings/marker-listing.html",
						),		
					)
				),
				3 => array(
					"main_title" => __("Map", "gmwd"),
					"url" => "https://web-dorado.com/wordpress-google-maps/map.html",
					"titles" => array(
						array(
							"title" => __("Adding Marker", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/map/adding-marker.html",
						),
						array(
							"title" => __("Adding Circle", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/map/adding-circle.html",
						),
						array(
							"title" => __("Adding Rectangle", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/map/adding-rectangle.html",
						),
						array(
							"title" => __("Adding Polygon", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/map/adding-polygon.html",
						),
						array(
							"title" => __("Adding Polylines", "gmwd"),
							"url" => "https://web-dorado.com/wordpress-google-maps/map/adding-polylines.html",
						),					
					)
				), 
				4 => array(
					"main_title" => __("Preview/Themes", "gmwd"),
					"url" => "https://web-dorado.com/wordpress-google-maps/preview-themes.html",
					"titles" => array()
				), 
				5 => array(
					"main_title" => __("Creating Marker Categories", "gmwd"),
					"url" => "https://web-dorado.com/wordpress-google-maps/creating-marker-categories.html",				
					"titles" => array()
				),                     
		   ),
		   "overview_welcome_image" => null, 
		   "video_youtube_id" => "acaexefeP7o",  // e.g. https://www.youtube.com/watch?v=acaexefeP7o youtube id is the acaexefeP7o
		   "plugin_wd_url" => "https://web-dorado.com/products/wordpress-google-maps-plugin.html", 
		   "plugin_wd_demo_link" => "http://wpdemo.web-dorado.com/google-maps/?_ga=1.55907819.1794949467.1468394897", 	 
		   "plugin_wd_addons_link" => "https://web-dorado.com/products/wordpress-google-maps-plugin/add-ons/marker-clustering.html", 
		   "after_subscribe" => "admin.php?page=overview_gmwd", // this can be plagin overview page or set up page
		   "plugin_wizard_link" => admin_url('index.php?page=gmwd_setup'), 
		   "plugin_menu_title" => "Google Maps WD", 
		   "plugin_menu_icon" => GMWD_URL . '/images/icon-map-20.png', 
		   "deactivate" => true, 
		   "subscribe" => true, 
		   "custom_post" => "maps_gmwd",  // if true => edit.php?post_type=contact
		   "menu_capability" => "manage_options",  
		   "menu_position" => 9,  
		);
		
		dorado_web_init($gmwd_options);
	}	

}

add_action( 'init', "wd_gmwd_init" ); 


?>
