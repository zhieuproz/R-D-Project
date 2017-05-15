<?php

class GMWDViewUninstall_gmwd extends GMWDView{

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
	public function display() {
		global $wpdb;
		$prefix = $wpdb->prefix;

	?>		
		<form method="post" action="" id="adminForm">
            <?php wp_nonce_field('nonce_gmwd', 'nonce_gmwd'); ?>  
			<div class="gmwd">
				<h2>
                    <img src="<?php echo GMWD_URL . '/images/uninstall.png';?>" width="30" style="vertical-align:middle;">
                    <span><?php _e("Uninstall Google Maps WD","gmwd"); ?></span>
                </h2>
                <div class="goodbye-text">
                    <?php
                    $support_team = '<a href="https://web-dorado.com/support/contact-us.html?source=wd-google-maps" target="_blank">' . __('support team', 'bwg_back') . '</a>';
                    $contact_us = '<a href="https://web-dorado.com/support/contact-us.html?source=wd-google-maps" target="_blank">' . __('Contact us', 'bwg_back') . '</a>';
                    
                    echo sprintf(__("Before uninstalling the plugin, please Contact our %s. We'll do our best to help you out with your issue. We value each and every user and value what's right for our users in everything we do.<br />
                    However, if anyway you have made a decision to uninstall the plugin, please take a minute to %s and tell what you didn't like for our plugins further improvement and development. Thank you !!!", "gmwd"), $support_team, $contact_us); ?>
                </div>                 
				<p>
				  <?php _e("Deactivating Google Maps WD plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.","gmwd"); ?>
				</p>
				<p style="color: red;">
				  <strong><?php _e("WARNING:","gmwd"); ?></strong>
				  <?php _e("Once uninstalled, this can't be undone. You should use a Database Backup plugin of WordPress to back up all the data first.","gmwd"); ?>
				</p>
				<p style="color: red">
					<strong><?php _e("The following Database Tables will be deleted:","gmwd"); ?></strong>
				</p>
				<table class="widefat">
					<thead>
						<tr>
							<th><?php _e("Database Tables","gmwd"); ?></th>
						</tr>
					</thead>
					<tr>
						<td valign="top">
							<ol>
							  <li><?php echo $prefix; ?>gmwd_maps</li>
							  <li><?php echo $prefix; ?>gmwd_markers</li>
							  <li><?php echo $prefix; ?>gmwd_polygons</li>
							  <li><?php echo $prefix; ?>gmwd_polylines</li>
							  <li><?php echo $prefix; ?>gmwd_shortcodes</li>
							  <li><?php echo $prefix; ?>gmwd_options</li>
							</ol>
						</td>
					</tr>
	
				</table>
				<p style="text-align: center;">	<?php _e("Do you really want to uninstall Google Maps WD?","gmwd"); ?></p>
				<p style="text-align: center;">
					<input type="checkbox" name="unistall_gmwd" id="check_yes" value="yes" />&nbsp;
					<label for="check_yes"><?php _e("Yes","gmwd"); ?></label>
				</p>
				<p style="text-align: center;">
				<input type="button" value="<?php _e("UNINSTALL","gmwd"); ?>" class="wd-btn wd-btn-primary" onclick="if (check_yes.checked) { 
																					if (confirm('You are About to Uninstall Google Maps WD from WordPress.\nThis Action Is Not Reversible.')) {
																						gmwdFormSubmit('uninstall');;
																					} else {
																						return false;
																					}
																				  }
																				  else {
																					return false;
																				  }" />
				</p>				
			</div>	
			
			<input id="page" name="page" type="hidden" value="<?php echo GMWDHelper::get('page');?>" />							
			<input id="task" name="task" type="hidden" value="" />


		</form>
	<?php  
	}

	public function complete_uninstalation(){
		global $wpdb;
	
		$prefix = $wpdb->prefix;
		$deactivate_url = wp_nonce_url('plugins.php?action=deactivate&amp;plugin='.GMWD_NAME.'/wd-google-maps.php', 'deactivate-plugin_'.GMWD_NAME.'/wd-google-maps.php');
			
		?>
		<div id="message" class="updated fade">
			<p><?php _e("The following Database Tables successfully deleted:","gmwd"); ?></p>
			<p><?php echo $prefix; ?>gmwd_maps</p>
			<p><?php echo $prefix; ?>gmwd_markers</p>
			<p><?php echo $prefix; ?>gmwd_polygons</p>
			<p><?php echo $prefix; ?>gmwd_polylines</p>
			<p><?php echo $prefix; ?>gmwd_shortcodes</p>
			<p><?php echo $prefix; ?>gmwd_options</p>
		</div>
		<div class="wrap">
		  <h2><?php _e("Uninstall Google Maps WD","gmwd"); ?></h2>
		  <p><strong><a href="#" class="gmwd_deactivate_link" data-uninstall="1"><?php _e("Click Here","gmwd"); ?></a><?php _e(" To Finish the Uninstallation and Google Maps WD will be Deactivated Automatically.","gmwd"); ?></strong></p>

		</div>
	
		<?php		
		
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