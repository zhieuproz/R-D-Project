<?php

class GMWD{
   	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
    protected static $instance = null;
    protected static $params;

	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////
	public function __construct() {
		add_action('init', array($this,'gmwd_do_output_buffer'));
        // includes
        add_action('init', array($this, 'gmwd_includes'),1);
        // add scripts
        add_action('wp_enqueue_scripts', array($this,'gmwd_frontend_scripts'), 2);
        add_action('init', array($this, 'add_localization'), 1);
        add_shortcode('Google_Maps_WD', array('GMWD', 'gmwd_shortcode'));
        
	}
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	//////////////////////////////////////////////////////////////////////////////////////// 
    
	// Return an instance of this class.	 
	public static function gmwd_get_instance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	} 
  
	function gmwd_do_output_buffer() {
		ob_start();
	}    
   
	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
    
    public function gmwd_includes(){
        require_once(GMWD_DIR . '/framework/GMWDHelper.php');
        require_once(GMWD_DIR . '/frontend/controllers/GMWDControllerFrontend.php');
        require_once(GMWD_DIR . '/frontend/models/GMWDModelFrontend.php');
        require_once(GMWD_DIR . '/frontend/views/GMWDViewFrontend.php');
        $page = GMWDHelper::get("page") ? GMWDHelper::get("page") : "map";
        if($page = "map"){        
            require_once(GMWD_DIR . '/frontend/controllers/GMWDControllerFrontend' . ucfirst($page) . '.php');
        }
				
    }
    function add_localization() {
        $path = dirname(plugin_basename(__FILE__)) . '/languages/';
        $loaded = load_plugin_textdomain('gmwd', false, $path);
        if (isset($_GET['page']) && $_GET['page'] == basename(__FILE__) && !$loaded) {
            echo '<div class="error">Google Maps WD ' . __('Could not load the localization file: ' . $path, 'gmwd') . '</div>';
            return;
        }
    }   
    public static function gmwd_frontend(){

        $params = self::$params;
        $page = GMWDHelper::get("page") ? GMWDHelper::get("page") : "map";
     
        if($page = "map"){ 
            $controller_class = 'GMWDControllerFrontend' . ucfirst($page);
            $controller = new $controller_class($params);
            $controller->execute();	
        }
        
    }
    

    public function gmwd_frontend_scripts() {
        $version = get_option("gmwd_version");
        global $wp_scripts;
      
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
        if (isset($wp_scripts->registered['jquery'])) {
            $jquery = $wp_scripts->registered['jquery'];
            if (!isset($jquery->ver) OR version_compare($jquery->ver, '1.8.2', '<')) {
              wp_deregister_script('jquery');
              wp_register_script('jquery', FALSE, array('jquery-core', 'jquery-migrate'), '1.10.2' );
            }
        }
        wp_enqueue_script('jquery'); 
   
        foreach ($wp_scripts as $wp_script) {         
            if (isset($wp_script->src) && $wp_script->src && ( strpos($wp_script->src, 'maps.googleapis.com') || strpos($wp_script->src, 'maps.google.com') ) !== false) {                
               wp_deregister_script($wp_script->handle);
               wp_dequeue_script($wp_script->handle);                                                                 
            }  
        }
        $page = GMWDHelper::get("page") ? GMWDHelper::get("page") : "map";
        if($page == "map"){
            wp_enqueue_script('gmwd_map-js', $map_api_url);

            wp_enqueue_script('frontend_init_map-js', GMWD_URL . '/js/init_map.js', array(), $version, false );
            wp_enqueue_script('frontend_main-js', GMWD_URL . '/js/frontend_main.js', array(), $version, false );

            wp_enqueue_style('font_awsome-css',  GMWD_URL . '/css/font-awesome/font-awesome.css', array(), $version);
            wp_enqueue_style('bootstrap-css',  GMWD_URL . '/css/bootstrap.css', array(), $version);
            wp_enqueue_style('frontend_main-css',  GMWD_URL . '/css/frontend_main.css', array(), $version);
        }

    }   
    // Shortcode function
    public static function gmwd_shortcode($params) {

        /*if (isset($params['id'])) {
            global $wpdb;
            $shortcode = $wpdb->get_var($wpdb->prepare("SELECT tag_text FROM " . $wpdb->prefix . "gmwd_shortcodes WHERE id='%d'", $params['id']));
            if ($shortcode) {

                $shortcode_params = explode(' ', $shortcode);
                foreach ($shortcode_params as $shortcode_param) {
                    $shortcode_elem = explode('=', $shortcode_param);
                    $params[str_replace(' ', '', $shortcode_elem[0])] = $shortcode_elem[1];
                }            
            }
            else {
                die();
            }
        }*/

         shortcode_atts(array(
            'id' => "1",
            'map' => "1"

         ), $params,'Google_Maps_WD');

        ob_start();
        self::$params = $params;
        self::gmwd_frontend();
        return str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean());
    } 
    
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	//////////////////////////////////////////////////////////////////////////////////////// 

}


?>