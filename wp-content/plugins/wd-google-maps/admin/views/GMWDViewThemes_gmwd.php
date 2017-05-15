<?php

class GMWDViewThemes_gmwd extends GMWDView{

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

	public function display(){	
        upgrade_pro("themes");
	?>	
		<div class="gmwd">				
            <div class="gmwd_theme_imgs">
                <div>
                    <h4><b><?php _e("Map Styles","gmwd");?></b></h4>                       
                    <img src="<?php echo GMWD_URL . '/images/themes/mapstyle1.png'; ?>">
                    <img src="<?php echo GMWD_URL . '/images/themes/mapstyle2.png'; ?>">
                    <img src="<?php echo GMWD_URL . '/images/themes/mapstyle3.png'; ?>">
                </div>
                <div>
                    <h4><b><?php _e("Directions","gmwd");?></b></h4>                       
                    <img src="<?php echo GMWD_URL . '/images/themes/dir.png'; ?>">
                </div>   
                <div>
                    <h4><b><?php _e("Store Locator","gmwd");?></b></h4>                       
                    <img src="<?php echo GMWD_URL . '/images/themes/storelocator.png'; ?>">
                </div>
                <div>
                    <h4><b><?php _e("Marker Listing Basic Table","gmwd");?></b></h4>                       
                    <img src="<?php echo GMWD_URL . '/images/themes/basic.png'; ?>">
                </div>
                <div>
                    <h4><b><?php _e("Marker Listing Advanced Table","gmwd");?></b></h4>                       
                    <img src="<?php echo GMWD_URL . '/images/themes/advanced.png'; ?>">
                </div>  
                <div>
                    <h4><b><?php _e("Marker Listing Carousel","gmwd");?></b></h4>                       
                    <img src="<?php echo GMWD_URL . '/images/themes/carousel.png'; ?>">
                </div>  
                <div>
                    <h4><b><?php _e("Marker Listing Inside Map","gmwd");?></b></h4>                       
                    <img src="<?php echo GMWD_URL . '/images/themes/insidemap.png'; ?>">
                </div>                      
            </div>
        </div>


	<?php
	 
	}
	
	
    
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}