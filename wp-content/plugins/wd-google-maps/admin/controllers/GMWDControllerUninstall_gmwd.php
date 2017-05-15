<?php

class GMWDControllerUninstall_gmwd extends GMWDController{
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
	public function __construct(){
		parent::__construct();
		global  $gmwd_options;
        if(!class_exists("DoradoWebConfig")){
            include_once (GMWD_DIR . "/wd/config.php"); 	
        }
        $config = new DoradoWebConfig();

        $config->set_options( $gmwd_options );
		
		$deactivate_reasons = new DoradoWebDeactivate($config);
		//$deactivate_reasons->add_deactivation_feedback_dialog_box();	
		$deactivate_reasons->submit_and_deactivate(); 

	}	
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public function uninstall(){
		global $wpdb;
	
		// delete tables
		
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_maps");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_markers");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_markercategories");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_polygons");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_circles");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_rectangles");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_polylines");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_options");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_themes");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_shortcodes");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmwd_mapstyles");
        
        // delete options
        delete_option('gmwd_do_activation_set_up_redirect');
        delete_option('gmwd_version');
        delete_option('gmwd_download_markers');
        delete_option('gmwd_pro');
        delete_option('gmwd_subscribe_done');
		delete_transient('_transient_timeout_gmwd_remote_data');
        delete_transient('_transient_gmwd_remote_data');
        delete_option('gmwd_admin_notice');
        
		$this->view->complete_uninstalation();

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