<?php
function gmwd_update(){
    global $wpdb;
    $api_key = $wpdb->get_var('SELECT id FROM ' . $wpdb->prefix . 'gmwd_options WHERE name="map_api_key"');
    if(!$api_key){
        $wpdb->query("INSERT INTO  `" . $wpdb->prefix . "gmwd_options` (`id`,  `name`, `value`, `default_value`) VALUES ('', 'map_api_key', '', '' ) ");
    }
    
    $header_titles = $wpdb->get_row("SHOW COLUMNS FROM ".$wpdb->prefix . "gmwd_maps LIKE 'store_locator_header_title'");
    if(!$header_titles){
        $wpdb->query("ALTER TABLE ".$wpdb->prefix . "gmwd_maps ADD  `store_locator_header_title`  VARCHAR(256) NOT NULL ");
    }
    
    $enable_searchbox = $wpdb->get_row("SHOW COLUMNS FROM ".$wpdb->prefix . "gmwd_maps LIKE 'enable_searchbox'");
    if(!$enable_searchbox){
        $wpdb->query("ALTER TABLE ".$wpdb->prefix . "gmwd_maps ADD  `enable_searchbox`   TINYINT(1) NOT NULL ");
        $wpdb->query("ALTER TABLE ".$wpdb->prefix . "gmwd_maps ADD  `searchbox_position`  INT(16) NOT NULL ");
    } 
    $info_window_info = $wpdb->get_var("SHOW COLUMNS FROM ".$wpdb->prefix . "gmwd_maps LIKE 'info_window_info'");
    if(!$info_window_info){
        $wpdb->query("ALTER TABLE ".$wpdb->prefix . "gmwd_maps ADD  `info_window_info`  VARCHAR(32) NOT NULL ");
        $wpdb->query("UPDATE  `" . $wpdb->prefix . "gmwd_maps` SET info_window_info='title,address,desc,pic'");   
    
    }    
}


?>