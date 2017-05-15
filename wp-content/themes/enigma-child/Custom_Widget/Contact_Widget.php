<?php

	// Creating the widget 

class wpb_widget extends WP_Widget {



function __construct() {

parent::__construct(

// Base ID of your widget

'wpb_widget', 



// Widget name will appear in UI

__('Contact Form', 'wpb_widget_domain'), 



// Widget description

array( 'description' => __( 'Contact Widget For Footer', 'wpb_widget_domain' ), ) 

);

}



// Creating widget front-end

// This is where the action happens

public function widget( $args, $instance ) { // Updated

$title = apply_filters( 'widget_title', $instance['title'] );

$Phone = apply_filters( 'widget_Phone', $instance['Phone'] );

$Email = apply_filters( 'widget_Email', $instance['Email'] );

$Time = apply_filters( 'widget_Time', $instance['Time'] );

$Location = apply_filters( 'widget_Location', $instance['Location'] );



// before and after widget arguments are defined by themes

echo $args['before_widget'];

if ( ! empty( $title ) )

echo $args['before_title'] . $title . $args['after_title'];



// This is where you run the code and display the output 		//Updated (Font Awesome + information)

?>

<font color="#FFFFFF" style="font-size:18px;">

 <i class="fa fa-mobile" aria-hidden="true"></i> <?php echo($Phone); ?> <br /><br /> <?php

?> <i class="fa fa-envelope"></i> <?php echo ($Email);?> <br /><br /> <?php

?> <i class="fa fa-clock-o"></i> <?php echo ($Time);?> <br /><br /> <?php

?> <i class="fa fa-map-marker"></i> <?php echo ($Location);?> <br /><br />

</font>

 <?php

echo $args['after_widget'];

}

		

// Widget Backend 

public function form( $instance )  // Updated

{

	if ( isset( $instance[ 'title' ] ) ) 

	{

		$title = $instance[ 'title' ];

	}

	else 

	{

		$title = __( 'New title', 'wpb_widget_domain' );

	}

	

	if ( isset( $instance[ 'Phone' ] ) ) 

	{

		$Phone = $instance[ 'Phone' ];

	}

	else 

	{

		$Phone = __( 'New Phone', 'wpb_widget_domain' );

	}

	

	if ( isset( $instance[ 'Email' ] ) ) 

	{

		$Email = $instance[ 'Email' ];

	}

	else 

	{

		$Email = __( 'New Email', 'wpb_widget_domain' );

	}

	

	if ( isset( $instance[ 'Time' ] ) ) 

	{

		$Time = $instance[ 'Time' ];

	}

	else 

	{

		$Time = __( 'New Time', 'wpb_widget_domain' );

	}

	

	if ( isset( $instance[ 'Location' ] ) ) 

	{

		$Location = $instance[ 'Location' ];

	}

	else 

	{

		$Location = __( 'New Location', 'wpb_widget_domain' );

	}	

	

	

// Widget admin form // Updated

?>

<p> 

<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 

<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />





<label for="<?php echo $this->get_field_id( 'Phone' ); ?>"><?php _e( 'Phone:' ); ?></label> 

<input class="widefat" id="<?php echo $this->get_field_id( 'Phone' ); ?>" name="<?php echo $this->get_field_name( 'Phone' ); ?>" type="text" value="<?php echo esc_attr( $Phone ); ?>" />



<label for="<?php echo $this->get_field_id( 'Email' ); ?>"><?php _e( 'Email:' ); ?></label> 

<input class="widefat" id="<?php echo $this->get_field_id( 'Email' ); ?>" name="<?php echo $this->get_field_name( 'Email' ); ?>" type="text" value="<?php echo esc_attr( $Email ); ?>" />



<label for="<?php echo $this->get_field_id( 'Time' ); ?>"><?php _e( 'Time:' ); ?></label> 

<input class="widefat" id="<?php echo $this->get_field_id( 'Time' ); ?>" name="<?php echo $this->get_field_name( 'Time' ); ?>" type="text" value="<?php echo esc_attr( $Time ); ?>" />



<label for="<?php echo $this->get_field_id( 'Location' ); ?>"><?php _e( 'Location:' ); ?></label> 

<input class="widefat" id="<?php echo $this->get_field_id( 'Location' ); ?>" name="<?php echo $this->get_field_name( 'Location' ); ?>" type="text" value="<?php echo esc_attr( $Location ); ?>" />

</p>

<?php 

}

	

// Updating widget replacing old instances with new



public function update( $new_instance, $old_instance ) { // Updated

$instance = array();

$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

$instance['Phone'] = ( ! empty( $new_instance['Phone'] ) ) ? strip_tags( $new_instance['Phone'] ) : '';

$instance['Email'] = ( ! empty( $new_instance['Email'] ) ) ? strip_tags( $new_instance['Email'] ) : '';

$instance['Time'] = ( ! empty( $new_instance['Time'] ) ) ? strip_tags( $new_instance['Time'] ) : '';

$instance['Location'] = ( ! empty( $new_instance['Location'] ) ) ? strip_tags( $new_instance['Location'] ) : '';

return $instance;

}

} // Class wpb_widget ends here



// Register and load the widget

function wpb_load_widget() {

	register_widget( 'wpb_widget' );

}

add_action( 'widgets_init', 'wpb_load_widget' );