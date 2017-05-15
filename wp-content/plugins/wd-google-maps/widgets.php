<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class GMWD_Widget extends WP_Widget {
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
    public function __construct() {
        parent::__construct(
                false, $name = __('Google Maps WD', 'gmwd'), array('description' => __('Google Maps WD', 'gmwd'))
        );
    }

	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	//////////////////////////////////////////////////////////////////////////////////////// 
    
    public function widget($args, $instance) {
        $markup = '';
        extract($args);

        //Output before widget stuff
        echo $before_widget;
        if($instance["title"]){
            echo "<p>".$instance["title"]."</p>";
        }
        if($instance["text_above_map"]){
            echo "<p>".$instance["text_above_map"]."</p>";
        }
		$params = array();
		$params ['map'] = $instance['map'];
		$params ['zoom_level'] = $instance['zoom_level'];
		$params ['type'] = $instance['type'];
		$params ['width'] = $instance['width'];
		$params ['height'] = $instance['height'];
        $params ['width_unit'] = $instance['width_unit'];
		$params ['page'] = 'map';
		$params ['id'] = $widget_id;
		$params ['widget'] = true;
	     
		$map_controller = new GMWDControllerFrontendMap($params);
		$map_controller->execute();
        
		if($instance["text_below_map"]){
            echo "<p>".$instance["text_below_map"]."</p>";
        }
        //Output after widget stuff
        echo $after_widget;
    }
	// update
    public function update($new_instance, $old_instance) {

        $instance = $old_instance;		
		$instance['title'] = esc_html( $new_instance['title'] ) ;
		$instance['map'] = esc_html( $new_instance['map'] ) ;
		$instance['zoom_level'] = esc_html( $new_instance['zoom_level'] );
		$instance['type'] = esc_html( $new_instance['type'] );
		$instance['width'] = esc_html( $new_instance['width'] );
		$instance['height'] = esc_html( $new_instance['height'] );
 		$instance['width_unit'] = esc_html( $new_instance['width_unit'] );             
		$instance['text_above_map'] = esc_html( $new_instance['text_above_map'] );
		$instance['text_below_map'] = esc_html( $new_instance['text_below_map'] ) ;

        return $instance;
    }
	// admin form
   	public function form( $instance ) {		
		$title = isset($instance[ 'title' ]) ? $instance[ 'title' ] : "";
		$map = isset($instance[ 'map' ]) ? $instance[ 'map' ] : "";
		$zoom_level = isset($instance[ 'zoom_level' ]) ? $instance[ 'zoom_level' ] : 7;
		$type = isset($instance[ 'type' ]) ? $instance[ 'type' ] : "";
		$width = isset($instance[ 'width' ]) ? $instance[ 'width' ] : "100";
		$height = isset($instance[ 'height' ]) ? $instance[ 'height' ] : "150";
		$width_unit = isset($instance[ 'width_unit' ]) ? $instance[ 'width_unit' ] : "%";
		$text_above_map = isset($instance[ 'text_above_map' ]) ? $instance[ 'text_above_map' ] : "";
		$text_below_map = isset($instance[ 'text_below_map' ]) ? $instance[ 'text_below_map' ] : "";

		
		$data = $this->get_widget_admin_data();
		$map_rows = $data["maps"];
		$map_types = $data["map_types"];
		$link_types = $data["link_types"];
		$pages = $data["pages"];

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', "gmwd" ); ?>:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'map' ); ?>"><?php _e( 'Select Map', "gmwd" ); ?>:</label><br> 
			<select id="<?php echo $this->get_field_id( 'map' ); ?>" name="<?php echo $this->get_field_name( 'map' ); ?>" style="    width: 100%;">
				<?php 
					foreach($map_rows as $map_row){						
						$selected = esc_attr( $map ) ==  $map_row->id ? "selected" : "";
						echo '<option value="'.$map_row->id.'" '.$selected.'>'.$map_row->title.'</option>';
					}				
				?>
			</select>
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Map Type', "gmwd" ); ?>:</label><br> 
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
				<?php 
					foreach($map_types as $key => $val){						
						$selected = esc_attr( $type ) ==  $key ? "selected" : "";
						echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
					}
				
				?>
			</select>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'zoom_level' ); ?>"><?php _e( 'Zoom Level', "gmwd" ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'zoom_level' ); ?>" name="<?php echo $this->get_field_name( 'zoom_level' ); ?>" type="number" value="<?php echo esc_attr( $zoom_level ); ?>" max="21" min="1">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width', "gmwd" ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="number" value="<?php echo esc_attr( $width ); ?>" min="1">
            <select id="<?php echo $this->get_field_id( 'width_unit' ); ?>" name="<?php echo $this->get_field_name( 'width_unit' ); ?>">
                <option value="%" <?php echo esc_attr( $width_unit ) == "%" ? "selected" : "" ;?>>%</option>
                <option value="px" <?php echo esc_attr( $width_unit ) == "px" ? "selected" : "" ;?>>px</option>
			</select>
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height', "gmwd" ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>"  min="1"> px         
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text_above_map' ); ?>"><?php _e( 'Text Above Map', "gmwd" ); ?>:</label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'text_above_map' ); ?>" name="<?php echo $this->get_field_name( 'text_above_map' ); ?>" ><?php echo esc_attr( $text_above_map ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'text_below_map' ); ?>"><?php _e( 'Text Below Map' , "gmwd"); ?>:</label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'text_below_map' ); ?>" name="<?php echo $this->get_field_name( 'text_below_map' ); ?>" ><?php echo esc_attr( $text_below_map ); ?></textarea>
		</p>
	
		<?php 
	}
	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
   	
	private function get_widget_admin_data(){
		global $wpdb;
		$data = array();
		// get maps
		$maps = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "gmwd_maps WHERE published = '1'  ORDER BY id ");
		$data["maps"] = $maps;

		// map types
		$map_types = array( __("Roadmap", "gmwd"),  __("Satellite", "gmwd"),  __("Hybrid", "gmwd"), __("Terrain", "gmwd"));
		$data["map_types"] = $map_types;
		
		// link types
		$link_types = array( __("Select", "gmwd"),__("Page", "gmwd"),__("Custom URL", "gmwd"),__("Lightbox", "gmwd"));
		$data["link_types"] = $link_types;
				
		// get published posts
		$pages = get_pages(array(
			'sort_order' => 'asc',
			'sort_column' => 'post_title',
			'post_type' => 'page',
			'post_status' => 'publish'
		)); 
		$data["pages"] = $pages;
		
		return $data;
	}

}

add_action('widgets_init', create_function('', 'register_widget("GMWD_Widget");'));  



