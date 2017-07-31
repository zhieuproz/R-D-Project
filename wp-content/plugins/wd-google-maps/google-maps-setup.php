<?php
class GMWDSetupWizard {
	// //////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                                                                 //
	// //////////////////////////////////////////////////////////////////////////////////////
	// //////////////////////////////////////////////////////////////////////////////////////
	// Constants //
	// //////////////////////////////////////////////////////////////////////////////////////
    private $steps;
	// //////////////////////////////////////////////////////////////////////////////////////
	// Variables //
	// //////////////////////////////////////////////////////////////////////////////////////
	// //////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor //
	// //////////////////////////////////////////////////////////////////////////////////////
	public function __construct() {
		add_action ( 'admin_menu', array (
				$this,
				'admin_menu' 
		) );
		add_action ( 'admin_init', array (
				$this,
				'gmwd_setup_wizard' 
		) );
        
        if(isset($_POST["task"]) && $_POST["task"] == "save_api_key"){
            $this->save_api_key();
        }        
	}
	// //////////////////////////////////////////////////////////////////////////////////////
	// Public Methods //
	// //////////////////////////////////////////////////////////////////////////////////////
	public function admin_menu() {
		add_dashboard_page ( '', '', 'manage_options', 'gmwd_setup', '' );
	}
	
	public function gmwd_setup_wizard() {
		require_once (GMWD_DIR . '/framework/GMWDHelper.php');
        $this->steps = array(
			'general' => array(
				'name'    =>  __('General Options', "gmwd"),
				'slug'    => "setup_general",
			),
			'global' => array(
				'name'    =>  __( 'Global Options', "gmwd"),
				'slug'    => "setup_default",
			),
			'ready' => array(
				'name'    =>  __('Ready!', "gmwd"),
				'slug'    => "setup_ready",
			)
		);
		
		wp_enqueue_style ( 'admin_main-css', GMWD_URL . '/css/admin_main.css', array (), '' );
		wp_enqueue_style ( 'simple_slider-css', GMWD_URL . '/css/simple-slider.css', array (), '' );
		
		wp_register_script ( 'jquery', FALSE, array ('jquery-core','jquery-migrate'), '1.10.2' );
		wp_enqueue_script ( 'jquery' );
        $map_api_url = "https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&v=3.exp";

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
        wp_register_script ('google_map-js', $map_api_url, array ('jquery'), '' );
        wp_enqueue_script('google_map-js');
        
		wp_register_script ('admin_main-js', GMWD_URL . '/js/admin_main.js', array ('jquery'), '' );
		wp_enqueue_script ('admin_main-js');
				
		wp_register_script ('admin_main_map-js', GMWD_URL . '/js/main_map.js', array ('jquery'), '' );
		wp_enqueue_script ('admin_main_map-js');
		
		wp_register_script ('options-js', GMWD_URL . '/js/options_gmwd.js', array ('jquery'), '' );
		wp_enqueue_script ('options-js');		
		
		wp_register_script ('simple_slider-js', GMWD_URL . '/js/simple-slider.js', array ('jquery'), '' );
		wp_enqueue_script ('simple_slider-js' );
		
		wp_enqueue_script ('thickbox');
        wp_enqueue_script('jquery-ui-tooltip');
		
		ob_start ();
		$this->gmwd_setup_wizard_header ();
		$this->gmwd_setup_wizard_content ();
		$this->gmwd_setup_wizard_footer ();
		exit ();
	}
   
	// //////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters //
	// //////////////////////////////////////////////////////////////////////////////////////
	// //////////////////////////////////////////////////////////////////////////////////////
	// Private Methods //
	// //////////////////////////////////////////////////////////////////////////////////////
	// //////////////////////////////////////////////////////////////////////////////////////
	// Listeners //
	// //////////////////////////////////////////////////////////////////////////////////////
	private function gmwd_setup_wizard_header() {
    ?>
        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
            <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><?php _e( 'Google Maps WD &rsaquo; Setup Wizard', 'gmwd' ); ?></title>

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
                <?php do_action( 'admin_print_styles' ); ?>
                <?php do_action( 'admin_head' ); ?>
                <?php wp_print_scripts( 'jquery' ); ?>
                <?php wp_print_scripts( 'jquery-ui-tooltip' ); ?>
                <?php wp_print_scripts( 'thickbox' ); ?>
                <?php wp_print_scripts( 'admin_main-js' ); ?>
                <?php wp_print_scripts( 'google_map-js' ); ?>
                <?php wp_print_scripts( 'admin_main_map-js' ); ?>
                <?php wp_print_scripts( 'simple_slider-js' ); ?>
                <?php wp_print_scripts( 'options-js' ); ?>
                <script> 
					var mapWhellScrolling = Number(<?php echo gmwd_get_option("whell_scrolling");?>) == 1 ? true : false;
					var zoom = Number(<?php echo gmwd_get_option("zoom_level");?>);
					var mapDragable = Number(<?php echo gmwd_get_option("map_draggable");?>) == 1 ? true : false;
					var centerLat = Number(<?php echo gmwd_get_option("center_lat");?>);
					var centerLng = Number(<?php echo gmwd_get_option("center_lng");?>);
					var centerAddress = '<?php echo gmwd_get_option("center_address");?>';
					var map;				 
                </script>           

            </head>
            <body style="background: #eee;">
                <h1 class="gmwd_wizard_title">
                    <img src="<?php echo GMWD_URL."/images/icon-map-50.png";?>">
                    Google Maps WD      
                </h1>
		<?php
	}
	private function gmwd_setup_wizard_content() {
		$step = GMWDHelper::get("step");
		switch ($step) {
			case "" :
				$this->gmwd_setup();
				break;
			case "setup_general" :
				$this->gmwd_setup_general();
				break;
			case "setup_default" :
				$this->gmwd_setup_default();
				break;
			case "setup_ready" :
				$this->gmwd_setup_ready();
				break;
		}
        ?>
        <?php

	}
    
    
	private function gmwd_setup_wizard_footer() {
    ?>    
            </body>
        </html>
    <?php
	}
    
    
	private function gmwd_setup() {
    ?>
        <div class="gmwd_edit gmwd_wizard">
            <form method="post" action="">
                <div class="gmwd_wizard_containers">
                    <?php $this->gmwd_steps();?>
                    <div class="gmwd_wizard_container gmwd_wizard_geting_start">
                        <h2><?php _e("We welcome you in Google Maps WD plugin! ","gmwd");?></h2>
                        <div>
                            <p>
                                <?php _e("We appreciate your confidence in choosing Google Maps WD! ","gmwd");?>
                            </p>

                            <p>
                                <?php _e("We will do the utmost to provide you with the best service possible. In this quick wizard we are going to help with the basic configurations of the plugin. You may skip it or follow our simple instruction, which will take couple of moments. ","gmwd");?>						
                            </p>
                            <p>
                                <?php _e("Click the \"Let's start\" button to jump into the wizard or skip it to go back to the WordPress dashboard. You will be able to come back anytime in the future!  ","gmwd");?>						
                            </p>
                        </div>
                        <div class="gmwd_wizard_btns">
                            <a class="wd-btn wd-btn-primary" id="gmwd_wizard_allow"
                                href="index.php?page=gmwd_setup&step=setup_general"><?php _e("Let's Start!","gmwd");?></a>
                            <a class="wd-btn wd-btn-secondary" id="gmwd_wizard_cancel"
                                href="admin.php?page=maps_gmwd"><?php _e("Skip for Now","gmwd");?></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    <?php
	}
	private function gmwd_setup_general() {
		$map_languages_list = array (
				"" => "Location Base",
				"ar" => "Arabic",
				"bg" => "Bulgarian",
				"bn" => "Bengali",
				"ca" => "Catalan",
				"cs" => "Czech",
				"da" => "Danish",
				"de" => "German",
				"el" => "Greek",
				"en" => "English",
				"en-AU" => "English (Australian)",
				"en-GB" => "English (Great Britain)",
				"es" => "Spanish",
				"eu" => "Basque",
				"fa" => "Farsi",
				"fi" => "Finnish",
				"fil" => "Filipino",
				"fr" => "French",
				"gl" => "Galician",
				"gu" => "Gujarati",
				"hi" => "Hindi",
				"hr" => "Croatian",
				"hu" => "Hungarian",
				"id" => "Indonesian",
				"it" => "Italian",
				"iw" => "Hebrew",
				"ja" => "Japanese",
				"kn" => "Kannada",
				"ko" => "Korean",
				"lt" => "Lithuanian",
				"lv" => "Latvian",
				"ml" => "Malayalam",
				"mr" => "Marathi",
				"nl" => "Dutch",
				"no" => "Norwegian",
				"pl" => "Polish",
				"pt" => "Portuguese",
				"pt-BR" => "Portuguese (Brazil)",
				"pt-PT" => "Portuguese (Portugal)",
				"ro" => "Romanian",
				"ru" => "Russian",
				"sk" => "Slovak",
				"sl" => "Slovenian",
				"sr" => "Serbian",
				"sv" => "Swedish",
				"ta" => "Tamil",
				"te" => "Telugu",
				"th" => "Thai",
				"tl" => "Tagalog",
				"tr" => "Turkish",
				"uk" => "Ukrainian",
				"vi" => "Vietnamese",
				"zh-CN" => "Chinese (Simplified)",
				"zh-TW" => "Chinese (Traditional)" 
		);
		$query_url_generate_key = 'https://console.developers.google.com/henhouse/?pb=["hh-1","maps_backend",null,[],"https://developers.google.com",null,["maps_backend","geocoding_backend","directions_backend","distance_matrix_backend","elevation_backend","places_backend","static_maps_backend","roads","street_view_image_backend","geolocation"],null]&TB_iframe=true&width=600&height=400';
		?>
        <div class="gmwd_edit gmwd_wizard">
            <form method="post" action="" id="setupForm">
                <div class="gmwd_wizard_containers">
                    <?php $this->gmwd_steps();?>
                    <div class="gmwd_wizard_container gmwd_wizard_general_container">
                        <h2><?php _e("General Options","gmwd");?></h2>
                        <table class="gmwd_edit_table" style="width: 100%;">
                            <tr>
                                <td colspan="2">
                                   <p style="font-size:17px;"><strong><?php _e("Important. API key is required for Google Maps to work.","gmwd"); ?></strong></p>
                                    <a class="wd-btn wd-btn-primary thickbox thickbox-preview" name="<?php _e( 'Generate API Key - ( MUST be logged in to your Google account )', 'gmwd' ); ?>" href='<?php echo $query_url_generate_key;?>'>
                                        <?php _e("Generate Key","gmwd");?>
                                    </a>
                                    or <a target="_blank" href='https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend,static_maps_backend,roads,street_view_image_backend,geolocation,places_backend&keyType=CLIENT_SIDE&reusekey=true'>click here</a>
                                    <?php echo _e( ' to Get a Google Maps API KEY', 'gmwd' ) ?>
                                </td>
                            </tr>                          
                            <tr>
                                <td width="30%"><label for="map_api_key" title="<?php _e("Set your map API key","gmwd");?>"><?php _e("Map API Key","gmwd"); ?>:</label></td>
                                <td>
                                    <input type="text" name="map_api_key" id="map_api_key" value=""  ><br>
                                    <small><?php _e("Once saved, it may take up to 5 minutes for your map to display.","gmwd"); ?></small>
                                </td>
                            </tr> 
                           
                            <tr>
                                <td><label for="map_language" title="<?php _e("Choose Your Map Language","gmwd");?>"><?php _e("Map Language","gmwd"); ?>:</label></td>
                                <td>
                                    <select name="map_language" id="map_language">
                                    <?php
                                        foreach ( $map_languages_list as $key => $value ) {
                                            echo '<option value="' . $key . '" >' . $value . '</option>';
                                        }
                    
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="gmwd_wizard_btns">
                            <button class="wd-btn wd-btn-primary"
                                id="gmwd_wizard_countinue_general"><?php _e("Continue","gmwd");?></button>
                            <a class="wd-btn wd-btn-secondary" id="gmwd_wizard_skip_general"
                                href="index.php?page=gmwd_setup&step=setup_default"><?php _e("Skip this step","gmwd");?></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
            jQuery( document ).ready(function() {               
                jQuery("#gmwd_wizard_countinue_general").click(function(){
                        jQuery("#setupForm").attr("action", "index.php?page=gmwd_setup&step=setup_default");
                        jQuery("#setupForm").submit();
                    });
            });

		</script>
    <?php
	}
	private function gmwd_setup_default() {
		$this->gmwd_setup_apply();
		?>
        <div class="gmwd_edit gmwd_wizard">
            <?php if(!gmwd_get_option("map_api_key")){
                api_key_notice();
            }
            ?>         
            <form method="post" action="" id="setupForm">
                <div class="gmwd_wizard_containers">
                    <?php $this->gmwd_steps();?>
                    <div class="gmwd_wizard_container gmwd_wizard_default_container">                   
                        <h2><?php _e("Default Options","gmwd");?></h2>
						<div class="wd-clear">
							<div class="wd-left" style="width:412px;">
								<table class="gmwd_edit_table" style="width: 100%;">
									<tr>
										<td style="width: 20%;"><label for="address" title="<?php _e("Set Center Address of your Google Map","gmwd");?>"><?php _e("Center address","gmwd");?>:</label></td>
										<td>
                                            <input type="text" name="center_address" id="address"
											value="" autocomplete="off"><br>
                                            <small><em><?php _e("Or Right Click on the Map.","gmwd");?></em></small>
                                        </td>
									</tr>
									<tr>
										<td><label for="center_lat" title="<?php _e("Google Map's Center Latitude","gmwd");?>"><?php _e("Center Lat","gmwd");?>:</label></td>
										<td><input type="text" name="center_lat" id="center_lat"
											value=""></td>
									</tr>
									<tr>
										<td><label for="center_lng" title="<?php _e("Google Map's Center Longitude","gmwd");?>"><?php _e("Center Lng","gmwd");?>:</label></td>
										<td><input type="text" name="center_lng" id="center_lng"
											value=""></td>
									</tr>
									<tr>
										<td><label for="zoom_level" title="<?php _e("Choose the Zoom Level of Your Google Maps","gmwd");?>"><?php _e("Zoom Level","gmwd");?>:</label></td>
										<td><input type="text" name="zoom_level" id="zoom_level"
											value="<?php echo gmwd_get_option("zoom_level");?>" data-slider="true"
											data-slider-highlight="true" data-slider-theme="volume"
											data-slider-values="<?php echo implode(",",range(0,22)); ?>"></td>
									</tr>
									<tr>
										<td><label title="<?php _e("Enable or Disable Mouse Scroll-Wheel Scaling","gmwd");?>"><?php _e("Wheel Scrolling","gmwd"); ?>:</label></td>
										<td><input type="radio" class="inputbox" id="whell_scrolling0"
											name="whell_scrolling"
											<?php echo ((gmwd_get_option("whell_scrolling")) ? '' : 'checked="checked"'); ?>
											value="0"> <label for="whell_scrolling0"><?php _e("Off","gmwd"); ?></label>
											<input type="radio" class="inputbox" id="whell_scrolling1"
											name="whell_scrolling"
											<?php echo ((gmwd_get_option("whell_scrolling")) ? 'checked="checked"' : ''); ?>
											value="1"> <label for="whell_scrolling1"><?php _e("On","gmwd"); ?></label>
										</td>
									</tr>
									<tr>
										<td><label title="<?php _e("Enable or Disable Google Maps Dragging","gmwd");?>"><?php _e("Map Draggable","gmwd"); ?>:</label></td>
										<td><input type="radio" class="inputbox" id="map_draggable0"
											name="map_draggable"
											<?php echo ((gmwd_get_option("map_draggable")) ? '' : 'checked="checked"'); ?>
											value="0"> <label for="map_draggable0"><?php _e("No","gmwd"); ?></label>
											<input type="radio" class="inputbox" id="map_draggable1"
											name="map_draggable"
											<?php echo ((gmwd_get_option("map_draggable")) ? 'checked="checked"' : ''); ?>
											value="1"> <label for="map_draggable1"><?php _e("Yes","gmwd"); ?></label>
										</td>
									</tr>
								</table>                        
							</div>
						
							<div class="wd-right">
								<div id="wd-options-map" class="wd-set-up-map" style="width:360px; height:300px;"></div>
							</div>
						</div>
						<div class="gmwd_wizard_btns">
                            <a class="wd-btn wd-btn-secondary" id="gmwd_wizard_skip_general"
                                href="index.php?page=gmwd_setup&step=setup_general"><?php _e("Back","gmwd");?></a>                        
                            <button class="wd-btn wd-btn-primary"
                                id="gmwd_wizard_countinue_default"><?php _e("Continue","gmwd");?></button>
                            <a class="wd-btn wd-btn-secondary" id="gmwd_wizard_skip_default"
                                href="index.php?page=gmwd_setup&step=setup_ready"><?php _e("Skip this step","gmwd");?></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
            jQuery(".gmwd_edit_table [data-slider]").each(function () {
              var input = jQuery(this);
              jQuery("<span>").addClass("output").insertAfter(jQuery(this));  
            }).bind("slider:ready slider:changed", function (event, data) {   
              jQuery(this) .nextAll(".output:first").html(data.value.toFixed(1));   
            });
            gmwdSlider(this.jQuery || this.Zepto, jQuery(".gmwd_edit_table"));
            
            jQuery( document ).ready(function() {
                jQuery(document).tooltip();
                jQuery("#gmwd_wizard_countinue_default").click(function(){
                        jQuery("#setupForm").attr("action", "index.php?page=gmwd_setup&step=setup_ready");
                        jQuery("#setupForm").submit();
                    });
            });

		</script>

    <?php
	}
	private function gmwd_setup_ready() {
		$this->gmwd_setup_apply ();
		?>
        <div class="gmwd_edit gmwd_wizard">
            <?php if(!gmwd_get_option("map_api_key")){
                api_key_notice();
            }
            ?>         
            <form method="post">
                <div class="gmwd_wizard_containers">
                    <?php $this->gmwd_steps();?>
                    <div class="gmwd_wizard_container gmwd_wizard_ready_container">                   
                        <h2><?php _e("All Set!","gmwd");?></h2>
                        <div class="gmwd_wizard_ready_text">
                            <p>
                                <?php                
                                _e ( "Now you are ready to create your first Google Map!
                                Click the blue button below and start building your awesome map!", "gmwd" );
                                ?> 
                            </p>
                        </div>

                        <div class="gmwd_wizard_table">
                            <p>
                                <a href="admin.php?page=maps_gmwd"
                                    class="gmwd_wizard_create_your_maps"><?php _e("Create Your First Map!","gmwd");?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php
	}
	private function gmwd_setup_apply() {
		global $wpdb;
		$query = "SELECT name FROM " . $wpdb->prefix . "gmwd_options";
		// get option names
		$names = $wpdb->get_col ( $query, 0 );
		
		// update options
		
		for($i = 0; $i < count ( $names ); $i ++) {
			$name = $names [$i];
			$value = isset($_POST[$name]) ? $_POST[$name] : null;
		
			if ($value !== null) {
				$data = array ();
				$data ["value"] = $value;
				$where = array ("name" => $name );
									
				$where_format = $format = array ('%s');
						 
				$wpdb->update ( $wpdb->prefix . "gmwd_options", $data, $where, $format, $where_format );
			}
		}
	}
    private function save_api_key(){
        global $wpdb;
        $data = array();
        $data["value"] = esc_html(GMWDHelper::get("gmwd_api_key_general"));
        $where = array("name"=>"map_api_key");
        $where_format = $format = array('%s');
        $wpdb->update( $wpdb->prefix . "gmwd_options", $data, $where, $format, $where_format );
        GMWDHelper::gmwd_redirect("admin.php?page=".GMWDHelper::get("page").'&step='.GMWDHelper::get("step"));
    
    }  
    private function gmwd_steps(){
    ?>
        <ul class="gmwd_wizard_tabs wd-clear">
           <?php 
            foreach($this->steps as $step){  
               $class =  $step["slug"] == GMWDHelper::get("step") ? "gmwd_wizard_active" : "gmwd_wizard_tab_notdone";
               echo ' <li class="gmwd_wizard_general '.$class.'"><span>'. $step["name"].'</span></li>';    
            }
            ?>  
        </ul>
    <?php
    }
}
new GMWDSetupWizard ();

?>