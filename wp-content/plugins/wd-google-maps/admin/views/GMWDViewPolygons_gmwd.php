<?php

class GMWDViewPolygons_gmwd extends GMWDView{

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
	public function edit($id){
		$row = $this->model->get_row($id);		
        $page =  esc_html(stripslashes($_GET["page"]));
       
	?>

		<div class="pois_wrapper gmwd_edit">
			<form method="post" action="" id="adminForm">
				<!-- header -->
                <h2 class="overlay_title wd-clear">
                    <div class="wd-left">
                        <img src="<?php echo GMWD_URL . '/images/css/polygon-active-tab.png';?>" width="30" style="vertical-align:middle;">
                        <span><?php _e("Add Polygon","gmwd");?></span>
                    </div>
                    <div class="wd-right">
                        <button class="wd-btn wd-btn-secondary" onclick="gmwdAddPoi();return false;"><?php isset($_GET["hiddenName"]) ? _e("Edit Polygon","gmwd") : _e("Add Polygon","gmwd") ;?></button>
                        <button class="wd-btn wd-btn-secondary" onclick="gmwdClosePoi();return false;"><?php  _e("Cancel","gmwd") ;?></button>
                    </div>
				</h2> 
                 
				<!-- data -->
				<div class="wd-clear">
					<div class="wd-left">
						<table class="pois_table">
							<tr>
								<td><label for="title" title="<?php _e("Add title for polygon.","gmwd");?>"><?php _e("Title","gmwd");?>:</label></td>
								<td><input type="text" name="title" id="title" value="<?php echo $row->title;?>" class="wd-form-field wd-poi-required" ></td>
 								<td><label for="line_width" title="<?php _e("Set line width for marked polygon area.","gmwd");?>"><?php _e("Line Width","gmwd");?>:</label></td>
								<td><input type="text" name="line_width" id="line_width" value="<?php echo $row->line_width;?>"data-slider="true" data-slider-highlight="true" data-slider-theme="volume" data-slider-values="<?php echo implode(",",range(1,50)); ?>" class="wd-form-field" ></td>                               
							</tr>											
							<tr>
								<td><label for="link" title="<?php _e("Link the polygon with URL.","gmwd");?>"><?php _e("Link","gmwd");?>:</label></td>
								<td>
                                    <input type="text" name="link" id="link" value="<?php echo $row->link;?>" class="wd-form-field gmwd_disabled_field" disabled readonly>
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>
                                <td><label for="line_color" title="<?php _e("Choose a color of marked polygon line area.","gmwd");?>"><?php _e("Line Color","gmwd");?>:</label></td>
								<td><input type="text" name="line_color" id="line_color" value="<?php echo $row->line_color;?>" class="color wd-form-field"></td>
							</tr>
							<tr>
								<td><label for="data" title="<?php _e("This box contains distance information of polygon area.","gmwd");?>"><?php _e("Data","gmwd");?>:</label></td>
								<td><textarea name="data" id="data"  class="wd-form-field wd-poi-required"><?php echo $row->data;?></textarea></td>
								<td><label for="line_opacity" title="<?php _e("Determine the line color opacity of polygon.","gmwd");?>"><?php _e("Line Opacity","gmwd");?>:</label></td>
								<td><input type="text" name="line_opacity" id="line_opacity"  value="<?php echo $row->line_opacity;?>" data-slider="true" data-slider-highlight="true" data-slider-theme="volume" data-slider-values="0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1" class="wd-form-field"></td>                                
							</tr>
							<tr>
								<td><label title="<?php _e("Remove/Insert markers.","gmwd");?>"><?php _e("Show markers:","gmwd"); ?></label></td>
								<td>
								  <input type="radio" class="inputbox wd-form-field" id="show_markers0" name="show_markers" <?php echo (($row->show_markers) ? '' : 'checked="checked"'); ?> value="0" >
								  <label for="show_markers0"><?php _e("No","gmwd"); ?></label>
								  <input type="radio" class="inputbox wd-form-field" id="show_markers1" name="show_markers" <?php echo (($row->show_markers) ? 'checked="checked"' : ''); ?> value="1" >
								  <label for="show_markers1"><?php _e("Yes","gmwd"); ?></label>
								</td>
                                <td><label for="fill_color" title="<?php _e("Determine polygon body color.","gmwd");?>"><?php _e("Fill Color","gmwd");?>:</label></td>
								<td><input type="text" name="fill_color" id="fill_color" value="<?php echo $row->fill_color;?>" class="color wd-form-field"></td>                                
							</tr>
							<tr>
								<td><label title="<?php _e("Choose whether to enable info windows or not.","gmwd");?>"><?php _e("Enable Info Windows","gmwd");?></label>:</td>
								<td>								
									<input type="radio" class="inputbox wd-form-field gmwd_disabled_field" id="enable_info_windows0" name="enable_info_windows" <?php echo (($row->enable_info_windows) ? '' : 'checked="checked"'); ?> value="0" disabled readonly >
									<label for="enable_info_windows0"><?php _e("No","gmwd"); ?></label>
									<input type="radio" class="inputbox wd-form-field gmwd_disabled_field" id="enable_info_windows1" name="enable_info_windows" <?php echo (($row->enable_info_windows) ? 'checked="checked"' : ''); ?> value="1" disabled readonly >
									<label for="enable_info_windows1"><?php _e("Yes","gmwd"); ?></label>
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>                                    
								</td>  
                                <td><label for="fill_opacity" title="<?php _e("Determine polygon body color opacity.","gmwd");?>"><?php _e("Fill Opacity","gmwd");?>:</label></td>
								<td><input type="text" name="fill_opacity" id="fill_opacity" value="<?php echo $row->fill_opacity;?>"data-slider="true" data-slider-highlight="true" data-slider-theme="volume" data-slider-values="0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1" class="wd-form-field"></td>                                
							</tr>                            

							<tr>
                                <td></td>
                                <td></td>                             
								<td><label for="line_color_hover" title="<?php _e("Determine polygon line color on hover.","gmwd");?>"><?php _e("Line Color Hover","gmwd");?>:</label></td>
								<td>
                                    <input type="text" name="line_color_hover" id="line_color_hover" value="<?php echo $row->line_color_hover;?>" class="color wd-form-field gmwd_disabled_field" disabled readonly>
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>
							</tr>							
							<tr>
                                <td></td>
                                <td></td>                             
								<td><label for="line_opacity_hover" title="<?php _e("Determine polygon line color opacity on hover.","gmwd");?>"><?php _e("Line Opacity Hover","gmwd");?>:</label></td>
								<td>
                                    <input type="text" name="line_opacity_hover" id="line_opacity_hover" value="<?php echo $row->line_opacity_hover;?>"  class="wd-form-field gmwd_disabled_field" disabled readonly >
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>
							</tr>	
							<tr>
                                <td></td>
                                <td></td>                             
								<td><label for="fill_color_hover" title="<?php _e("Determine polygon body color on hover.","gmwd");?>"><?php _e("Fill Color Hover","gmwd");?>:</label></td>
								<td>
                                    <input type="text" name="fill_color_hover" id="fill_color_hover" value="<?php echo $row->fill_color_hover;?>" class="color wd-form-field gmwd_disabled_field" disabled readonly>
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>
							</tr>							
							<tr>
                                <td></td>
                                <td></td>                            
								<td><label for="fill_opacity_hover" title="<?php _e("Determine polygon body color opacity on hover.","gmwd");?>"><?php _e("Fill Opacity Hover","gmwd");?>:</label></td>
								<td>
                                    <input type="text" name="fill_opacity_hover" id="fill_opacity_hover" value="<?php echo $row->fill_opacity_hover;?>" class="wd-form-field gmwd_disabled_field" disabled readonly >
                                     <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>
							</tr>									
							<tr>
								<td><label title="<?php _e("Publish your polygon.","gmwd");?>"><?php _e("Published:","gmwd"); ?></label></td>
								<td>
                                  <input type="radio" class="inputbox wd-form-field" id="publishedp1" name="published" <?php echo (($row->published) ? 'checked="checked"' : ''); ?> value="1" >
								  <label for="publishedp1"><?php _e("Yes","gmwd"); ?></label>
								  <input type="radio" class="inputbox wd-form-field" id="publishedp0" name="published" <?php echo (($row->published) ? '' : 'checked="checked"'); ?> value="0" >
								  <label for="publishedp0"><?php _e("No","gmwd"); ?></label>

								</td>
							</tr>								
							<tr>								
								<td colspan="4">
									<button class="wd-btn wd-btn-primary" onclick="gmwdAddPoi();return false;"><?php isset($_GET["hiddenName"]) ? _e("Edit Polygon","gmwd") : _e("Add Polygon","gmwd") ;?></button>
									<button class="wd-btn wd-btn-secondary" onclick="gmwdClosePoi();return false;"><?php  _e("Cancel","gmwd") ;?></button>
								</td>                                
							</tr>	
						</table>
					</div>
					<div class="wd-right">
						<div id="wd-map2" class="wd_map gmwd_follow_scroll" style="height:400px;width:472px;"></div>
                        <div class="gmwd-poi-guide" style="height:400px;width:472px;">
                            <div class="wd-row"><strong><?php _e("Right Click on the Map to Insert a Vertex. ","gmwd");?></strong></div>
                            <div class="wd-row"><strong><?php _e("Right Click on a Vertex to Remove it.","gmwd");?></strong></div>
                            <div class="wd-row"><strong><?php _e("Drag a Vertex to Move it.","gmwd");?></strong></div>  
                        </div>  
					</div>					
				</div>					
				<input id="page" name="page" type="hidden" value="<?php echo GMWDHelper::get('page');?>" />	
				<input id="task" name="task" type="hidden" value="" />	
				<input id="id" name="id" type="hidden" value="<?php echo $row->id;?>" class="wd-form-field"/>	
				<input id="map_id" name="map_id" type="hidden" value="<?php echo GMWDHelper::get('map_id');?>" class="wd-form-field"/>
				<input type="hidden" id="dragged_marker">				
			</form>
		</div>	
		<script>
       
		jQuery(".pois_wrapper [data-slider]").each(function () {
		  var input = jQuery(this);
		  jQuery("<span>").addClass("output").insertAfter(jQuery(this));  
		}).bind("slider:ready slider:changed", function (event, data) {   
		  jQuery(this) .nextAll(".output:first").html(data.value.toFixed(1));   
		});
        gmwdSlider(this.jQuery || this.Zepto, jQuery("#wd-overlays"));
		jscolor.init();
		var _type = "polygons";
		var _hiddenName = "<?php echo isset($_GET["hiddenName"]) ? esc_html(stripslashes($_GET["hiddenName"])) : ""; ?>";
        var markerDefaultIcon = "<?php echo gmwd_get_option("marker_default_icon");?>";
		</script>
        <script src="<?php echo GMWD_URL . '/js/polygons_gmwd.js'; ?>" type="text/javascript"></script> 
		<script src="<?php echo GMWD_URL . '/js/simple-slider.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo GMWD_URL . '/js/admin_main.js'; ?>" type="text/javascript"></script>
	<?php

	 die();
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