<?php
/*
Plugin Name: WC Slider
Plugin URI: 
Description: Woocommerce product slider. Shortcode [woowcms], [woowcms category="music,books,movie"]
Author: Jahur Ahmed
Version: 1.1.1
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


if ( ! version_compare( PHP_VERSION, WOOWCMS_PHP_MINIMUM, '>=' ) ) {
    return false;
}




class Woowcms_Main{

    public function load_dependencies(){

        require_once 'includes/public/class_enqueue_scripts.php';
        $enqueue_scripts = new \WOOWCMS\Includes\Front\Enqueue_Scripts();

        require_once 'includes/public/class_shortcode.php';
        $shortcode = new \WOOWCMS\Includes\Front\Shortcode();
        
    }

}


function load_woowcms(){
    $pg = new Woowcms_Main();
    $pg->load_dependencies();
}

\add_action( 'plugins_loaded', 'WOOWCMS\load_woowcms' );
