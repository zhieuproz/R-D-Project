<?php

class GMWDControllerMarkers_gmwd extends GMWDController{
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
	public function select_icon(){
		$this->view->select_icon();
	}
    public function change_marker_size(){
        global $wpdb;
        $size = GMWDHelper::get("size");
        $file_path = GMWDHelper::get("image_url");
        
       
        if(strpos($file_path,"data:image/png;") !== false){
            $filename = 'marker_'.time().'.png';            
            $uri =  substr($file_path , strpos($file_path ,",")+1);	
            $file_path = GMWD_URL.'/images/markers/custom/customcreated/'.$filename;           
            file_put_contents(GMWD_DIR.'/images/markers/custom/customcreated/'.$filename, base64_decode($uri));               
        }

        $base_name = substr(substr(substr($file_path, strpos($file_path, "markers")),7),0,-4);
        $base_name = explode("_",$base_name);
        
        $file_path = GMWD_URL.'/images/markers'.$base_name[0]."_".$base_name[1].".png";

        $new_file_path_url = GMWD_URL.'/images/markers'.$base_name[0]."_".$base_name[1]."_".$size.".png";
        $new_file_path_dir = GMWD_DIR.'/images/markers'.$base_name[0]."_".$base_name[1]."_".$size.".png";
        
       
        if(file_exists($new_file_path_dir)){
            echo $new_file_path_url; die();
        }   
        
		list($img_width, $img_height, $type) = @getimagesize(htmlspecialchars_decode($file_path, ENT_COMPAT | ENT_QUOTES));

		if (!$img_width || !$img_height) {          
			return false;
		}		
		else{
			$ratio = $img_width/$img_height;
			$max_width =  $size;
			$max_height =  $size/$ratio;
 
			if (!function_exists('imagecreatetruecolor')) {
				error_log('Function not found: imagecreatetruecolor');
				return false;
			}

			ini_set('memory_limit', '-1');

			if (($img_width / $img_height) >= ($max_width / $max_height)) {
				$new_width = $img_width / ($img_height / $max_height);
				$new_height = $max_height;
			} 
			else {
				$new_width = $max_width;
				$new_height = $img_height / ($img_width / $max_width);
			}

			$dst_x = 0 - ($new_width - $max_width) / 2;
			$dst_y = 0 - ($new_height - $max_height) / 2;
			$new_img = @imagecreatetruecolor($max_width, $max_height);

            @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
            @imagealphablending($new_img, false);
            @imagesavealpha($new_img, true);
            $src_img = @imagecreatefrompng($file_path);
            $write_image = 'imagepng';
            $image_quality = 9;
					

           
            $success = $src_img && @imagecopyresampled($new_img, $src_img, $dst_x, $dst_y, 0, 0, $new_width, $new_height, $img_width,$img_height) && $write_image($new_img, $new_file_path_dir, $image_quality);	
            // Free up memory (imagedestroy does not delete files):
            @imagedestroy($src_img);
            @imagedestroy($new_img);
            ini_restore('memory_limit');
			
            echo $new_file_path_url; die();
		}

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