<?php
/*
Plugin Name: WC Slider
Plugin URI: 
Description: Woocommerce product slider. Shortcode [woowcms], [woowcms category="music,books,movie"]
Author: Jahur Ahmed
Version: 1.1.0
Author URI: https://thetechydots.com
Text Domain: woowcms
*/
namespace WOOWCMS;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define most essential constants.
define( 'WOOWCMS_VERSION', '1.1.0' );
define( 'WOOWCMS_PLUGIN_MAIN_FILE', __FILE__ );
define( 'WOOWCMS_PHP_MINIMUM', '5.6.0' );
define( 'WOOWCMS_DIR', plugin_dir_url(__FILE__) );


/**
 * Handles plugin activation.
 *
 * Throws an error if the plugin is activated with an insufficient version of PHP.
 *
 * @since 1.1.0
 * @access private
 *
 * @param bool $network_wide Whether to activate network-wide.
 */
function woowcms_activate_plugin( $network_wide ) {
	if ( version_compare( PHP_VERSION, WOOWCMS_PHP_MINIMUM, '<' ) ) {
		wp_die(
			/* translators: %s: version number */
			esc_html( sprintf( __( 'WC SLider requires PHP version %s', 'woowcms' ), WOOWCMS_PHP_MINIMUM ) ),
			esc_html__( 'Error Activating', 'woowcms' )
		);
	}

	if ( $network_wide ) {
		return;
	}

	do_action( 'woowcms_activation', $network_wide );
}
register_activation_hook( __FILE__, 'woowcms_activate_plugin' );

/**
 * Handles plugin deactivation.
 *
 * @since 1.1.0
 * @access private
 *
 * @param bool $network_wide Whether to deactivate network-wide.
 */

function woowcms_deactivate_plugin( $network_wide ) {
	if ( version_compare( PHP_VERSION, WOOWCMS_PHP_MINIMUM, '<' ) ) {
		return;
	}

	if ( $network_wide ) {
		return;
	}

	do_action( 'woowcms_deactivation', $network_wide );
}
register_deactivation_hook( __FILE__, 'woowcms_deactivate_plugin' );


if ( ! version_compare( PHP_VERSION, WOOWCMS_PHP_MINIMUM, '>=' ) ) {
    return false;
}




class Woowcms_Main{

    public function load_dependencies(){

        require_once 'includes/public/class_enqueue_scripts.php';
        $enqueue_scripts = new \WOOWCMS\Includes\Public\Enqueue_Scripts();

        require_once 'includes/public/class_shortcode.php';
        $shortcode = new \WOOWCMS\Includes\Public\Shortcode();
        
    }

}


function load_woowcms(){
    $pg = new Woowcms_Main();
    $pg->load_dependencies();
}

\add_action( 'plugins_loaded', 'WOOWCMS\load_woowcms' );
