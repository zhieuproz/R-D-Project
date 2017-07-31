<?php
// get option function
function gmwd_get_option($option_name){
    global $wpdb;

	if(get_option("gmwd_version")){
		$query = "SELECT * FROM ". $wpdb->prefix . "gmwd_options ";
		$rows = $wpdb->get_results($query);	

		$options = new stdClass();
		foreach ($rows as $row) {
			$name = $row->name;
			$value = $row->value !== "" ? $row->value : $row->default_value;
			$options->$name = $value;
		}
		
		return $options->$option_name;
	}
	return false;
}
function upgrade_pro($text = false){
    $page = isset($_GET["page"]) ? $_GET["page"] : "";
    $task = isset($_GET["task"]) ? $_GET["task"] : "";
?>
    <div class="gmwd_upgrade wd-clear" >
        <div class="wd-left">
        <?php
            switch($page){
                case "maps_gmwd":
                    if($task == "edit"){
                ?>
                    <div style="font-size: 14px;margin-top: 6px;">
                        <?php _e(" This section allows you to add/edit map.","gmwd");?>
                        <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank" href="https://web-dorado.com/wordpress-google-maps/creating-map.html"><?php _e("Read More in User Manual.","gmwd");?></a>
                    </div>                
                <?php
                    }
                    else{
                ?>
                    <div style="font-size: 14px;margin-top: 6px;">
                        <?php _e(" This section allows you to create, edit and delete maps.","gmwd");?>
                        <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank" href="https://web-dorado.com/wordpress-google-maps/creating-map.html"><?php _e("Read More in User Manual.","gmwd");?></a>
                    </div>
                <?php
                    }      
                break;
                case "options_gmwd":
                ?>
                    <div style="font-size: 14px;margin-top: 6px;">
                        <?php _e("This section allows you to change general options.","gmwd");?>
                        <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank" href="https://web-dorado.com/wordpress-google-maps/installation-wizard-options-menu.html"><?php _e("Read More in User Manual.","gmwd");?></a>
                    </div> 
                <?php      
                break; 
            }
        ?>
        </div>
        <div class="wd-right"> 
             <a href="https://web-dorado.com/products/wordpress-google-maps-plugin.html" target="_blank">
                <div class="wd-table">
                    <div class="wd-cell wd-cell-valign-middle">
                        <img src="<?php echo GMWD_URL; ?>/images/web-dorado.png" width="42px" >
                    </div>         
                    <div class="wd-cell wd-cell-valign-middle">                   
                        <?php _e("UPGRADE TO PAID VERSION", "gmwd"); ?>
                    </div>
                </div>
            </a>      
                            
        </div>
    </div>
    <?php if($text){
    ?>
        <div class="wd-text-right wd-row" style="color: #15699F; font-size: 20px; margin-top:10px; padding:0px 15px;">
            <?php echo sprintf(__("This is FREE version, Customizing %s is available only in the PAID version.","gmwd"), $text);?>
        </div>
    <?php
    }

}

function api_key_notice(){
    echo '<div style="width:99%">
                <div class="error">
                    <p style="font-size:18px;"><strong>'.__("Important. API key is required for Google Maps to work.","gmwd").'</strong></p>
                    <p style="font-size:18px;"><strong>'.__("To avoid limitation errors, fill in your own App key.","gmwd").'</strong></p>					
                   <p><a href=\'https://console.developers.google.com/henhouse/?pb=["hh-1","maps_backend",null,[],"https://developers.google.com",null,["maps_backend","geocoding_backend","directions_backend","distance_matrix_backend","elevation_backend","places_backend","static_maps_backend","roads","street_view_image_backend","geolocation"],null]&TB_iframe=true&width=600&height=400\' class="wd-btn wd-btn-primary thickbox" style="text-decoration:none;" name="'.__( "Generate API Key - ( MUST be logged in to your Google account )", "gmwd" ).'">'.__("Generate Key","gmwd").'</a> or <a target="_blank" href="https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend,static_maps_backend,roads,street_view_image_backend,geolocation,places_backend&keyType=CLIENT_SIDE&reusekey=true">click here</a> to Get a Google Maps API KEY</p>
                    <p>After creating the API key, please paste it here.</p>
                    <form method="post">
                        '.wp_nonce_field('nonce_gmwd', 'nonce_gmwd').'
                        <p>'.__("API Key","gmwd").' <input type="text" name="gmwd_api_key_general"> <button class="wd-btn wd-btn-primary">'.__("Save","gmwd").'</button></p>
                        <input type="hidden" name="task" value="save_api_key">
                        <input type="hidden" name="page" value="'.GMWDHelper::get("page").'">
                        <input type="hidden" name="step" value="'.GMWDHelper::get("step").'">
                    </form>
                    <p>'.__("It may take up to 5 minutes for API key change to take effect.","gmwd").'</p>
                </div>
          </div>';
}


?>