<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function websCF_check_installation_date() {
 
    $nobug = "";
    $nobug = get_option('websCF_no_bugs');
 
    if (!$nobug) {
 
            add_action( 'admin_notices', 'websCF_display_admin_notice' );
 
    }
 
}
add_action( 'admin_init', 'websCF_check_installation_date' );
 
function websCF_display_admin_notice() {
 
    $reviewurl = 'https://wordpress.org/support/plugin/contact-form-add/reviews/?rate=5#new-post';
 
    $nobugurl = get_admin_url() . '?mpspdontbug=1';

    $install_date = get_option( 'websCF_activation_date' );
 
    echo '<div class="psprev-adm-notice psprev-adm-notice-wp-rating notice">';

    echo '<h4>' . __( 'Thank you for using Contact Form', 'contact-form-add' ) . '</h4>';

    echo '<p>' . __( 'If you enjoy using <strong>Contact Form Plugin</strong> please leave us a <span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span> review. Reviews like yours help us improve the plugin.', 'contact-form-add' ) . '</p>';

    echo '<a class="psprev-adm-notice-link" href="'.$reviewurl.'" target="_blank"><span class="dashicons dashicons-edit"></span>' . __( 'Leave a Review', 'contact-form-add' ) . '</a>';

    echo '<a href="' . $nobugurl . '" type="button" class="notice-dismiss notice-dismiss-psp"><span class="screen-reader-text">Dismiss this notice.</span></a>';
 
   // echo( __( "You have been using our Posts Slider for more than a week now, do you like it? If so, please leave us a review with your feedback! <a href=".$reviewurl." target='_blank' class='button button-primary' style='margin:0 20px;'>Leave A Review</a> <a href=".$nobugurl." style='font-size:9px;'>Leave Me Alone</a>" ) ); 
 
    echo "</div>";

    echo "<style>

.psprev-adm-notice-activation { border-color: #41c4ff; }
.psprev-adm-notice-activation h4 { font-size: 1.05em; }
.psprev-adm-notice-activation a { text-decoration: none; }
.psprev-adm-notice-activation .psprev-adm-notice-link { display: inline-block; padding: 6px 8px; margin-bottom: 10px; color: rgba(52,152,219,1); font-weight: 500; background: #e9e9e9; border-radius: 2px; margin-right: 10px; }
.psprev-adm-notice-activation .psprev-adm-notice-link span { display: inline-block; text-decoration: none; margin-right: 10px; }
.psprev-adm-notice-activation .psprev-adm-notice-link:hover { color: #fff; background:#41c4ff; }

.psprev-adm-notice-wp-rating { border-color: rgba(52,152,219,0.75); }
.psprev-adm-notice-wp-rating h4 { font-size: 1.05em; }
.psprev-adm-notice-wp-rating p:last-of-type { margin-bottom: 20px; }
.psprev-adm-notice-wp-rating a { text-decoration: none; }
.psprev-adm-notice-wp-rating .psprev-adm-notice-link { display: inline-block; padding: 6px 8px; margin-bottom: 10px; color: rgba(52,152,219,1); font-weight: 500; background: #e9e9e9; border-radius: 2px; margin-right: 10px; }
.psprev-adm-notice-wp-rating .psprev-adm-notice-link span { display: inline-block; text-decoration: none; margin-right: 10px; }
.psprev-adm-notice-wp-rating .psprev-adm-notice-link:hover { color: #fff; background: rgba(52,152,219,0.75); }
.psprev-adm-notice-wp-rating .dashicons-star-filled { position: relative; top: 1px; width: 15px; height: 15px; font-size: 15px; }
.notice-dismiss-psp { top: 8% !important; right: 1.5% !important; }
    </style>";

}

function websCF_set_no_bug() {
 
    $nobug = "";
 
    if ( isset( $_GET['mpspdontbug'] ) ) {
        $nobug = esc_attr( $_GET['mpspdontbug'] );
    }
 
    if ( 1 == $nobug ) {
 
        add_option( 'websCF_no_bugs', TRUE );
 
    }
 
} add_action( 'admin_init', 'websCF_set_no_bug', 5 );

?>