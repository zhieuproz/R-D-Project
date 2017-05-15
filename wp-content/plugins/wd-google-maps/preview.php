<?php
class GMWDPreview {
	// //////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                              //
	// //////////////////////////////////////////////////////////////////////////////////////
	// //////////////////////////////////////////////////////////////////////////////////////
	// Constants //
	// //////////////////////////////////////////////////////////////////////////////////////
	// //////////////////////////////////////////////////////////////////////////////////////
	// Variables //
	// //////////////////////////////////////////////////////////////////////////////////////
    private $map;
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
				'gmwd_preview' 
		) );
        $this->map = GMWDHelper::get("map_id");
	}
	// //////////////////////////////////////////////////////////////////////////////////////
	// Public Methods //
	// //////////////////////////////////////////////////////////////////////////////////////
	public function admin_menu() {
		add_dashboard_page ( '', '', 'manage_options', 'gmwd_preview', '' );
	}
	
	public function gmwd_preview() {
        $version = get_option("gmwd_version");
		$this->gmwd_includes();

		wp_register_script ( 'jquery', FALSE, array ('jquery-core','jquery-migrate'), '1.10.2' );
		wp_enqueue_script ( 'jquery' );
                
        $map_api_url = "https://maps.googleapis.com/maps/api/js?libraries=places,geometry&sensor=false&v=3.exp";
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
        
        wp_register_script ('frontend_init_map-js', GMWD_URL . '/js/init_map.js', array(), $version);
        wp_enqueue_script('frontend_init_map-js');
        
        wp_register_script ('frontend_main-js', GMWD_URL . '/js/frontend_main.js', array(), $version);
        wp_enqueue_script('frontend_main-js');
        

        wp_enqueue_style('font_awsome-css',  GMWD_URL . '/css/font-awesome/font-awesome.css');
        wp_enqueue_style('bootstrap-css',  GMWD_URL . '/css/bootstrap.css');
        wp_enqueue_style('frontend_main-css',  GMWD_URL . '/css/frontend_main.css');      

       
		ob_start ();
		$this->gmwd_preview_header();
		$this->gmwd_preview_content ();
		$this->gmwd_preview_footer ();
		exit ();
	}
	// //////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters //
	// //////////////////////////////////////////////////////////////////////////////////////
	// //////////////////////////////////////////////////////////////////////////////////////
	// Private Methods //
	// //////////////////////////////////////////////////////////////////////////////////////

	private function gmwd_preview_header() {
    ?>
        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
            <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><?php _e( 'Google Maps WD &rsaquo; Setup Wizard', 'gmwd' ); ?></title>

                <link media="all" type="text/css" href="<?php echo get_admin_url(); ?>load-styles.php?c=1&amp;dir=ltr&amp;load=admin-bar,wp-admin,dashicons,buttons,wp-auth-check" rel="stylesheet">
                <?php if (get_bloginfo('version') < '3.9') { ?>
                <link media="all" type="text/css" href="<?php echo get_admin_url(); ?>css/colors<?php echo ((get_bloginfo('version') < '3.8') ? '-fresh' : ''); ?>.min.css" id="colors-css" rel="stylesheet">
                <?php } ?>           
                <?php do_action( 'admin_print_styles' ); ?>
                <?php do_action( 'admin_head' ); ?>
                <?php wp_print_scripts( 'jquery' ); ?>
                <?php wp_print_scripts( 'google_map-js' ); ?>
                <?php wp_print_scripts( 'frontend_init_map-js' ); ?>
                <?php wp_print_scripts( 'frontend_main-js' ); ?>
                   
            </head>
            <body style="background:#fff;">
		<?php
	}
	private function gmwd_preview_content() {
        GMWD::gmwd_get_instance();
        $params = array();
        $params ['map'] = $this->map;
        $params ['id'] = "preview";
         
        $map_controller = new GMWDControllerFrontendMap($params);
        $map_controller->display();
	}
        
	private function gmwd_preview_footer() {
    ?>    
            </body>
        </html>
    <?php
	}
    
    private function gmwd_includes(){
        require_once(GMWD_DIR . '/framework/GMWDHelper.php');
        require_once(GMWD_DIR . '/frontend/controllers/GMWDControllerFrontend.php');
        require_once(GMWD_DIR . '/frontend/models/GMWDModelFrontend.php');
        require_once(GMWD_DIR . '/frontend/views/GMWDViewFrontend.php');       
        require_once(GMWD_DIR . '/frontend/controllers/GMWDControllerFrontendMap.php');
			
    }
	// //////////////////////////////////////////////////////////////////////////////////////
	// Listeners //
	// //////////////////////////////////////////////////////////////////////////////////////    
}
    
   
new GMWDPreview();

?>