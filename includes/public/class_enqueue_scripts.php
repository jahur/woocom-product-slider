<?php

namespace WOOWCMS\Includes\Public;

class Enqueue_Scripts{

    function __construct(){
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
    }

    public function enqueue_scripts(){

        wp_enqueue_style( 'owl-carousel', plugins_url( '/css/owl.carousel.min.css', __FILE__ ), array(), time() );
        wp_enqueue_script('script-owl-carousel', plugin_dir_url(__FILE__) . '/js/owl.carousel.min.js', array('jquery'), time(), true);
        wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . '/js/custom.js', array('jquery'), time(), true);
    
    }
}