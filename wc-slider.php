<?php
/*
Plugin Name: WC Slider
Plugin URI: 
Description: Woocommerce product slider. Shortcode [woowcms], [woowcms category="music"]
Author: Jahur Ahmed
Version: 1.0.1
Author URI: http://pressiva.com
Text Domain: woowcms
*/


//script $ css
function woowcms_scripts() {

	wp_enqueue_style( 'owl-carousel', plugins_url( '/assets/owlcarousel/assets/owl.carousel.css', __FILE__ ), array(), '1.0.5' );

	//wp_enqueue_style( 'owl-theme', plugins_url( '/assets/owlcarousel/assets/owl.theme.default.css', __FILE__ ), array(), '1.0.3' );

	wp_enqueue_script('script-owl-carousel', plugin_dir_url(__FILE__) . 'assets/owlcarousel/owl.carousel.js', array('jquery'), '1.0.1', true);

	wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . 'assets/owlcarousel/custom.js', array('jquery'), '1.0.4', true);



}
add_action( 'wp_enqueue_scripts', 'woowcms_scripts' );


function woowcms_shortcode( $atts ) {
     $sattr = shortcode_atts( array(
         'category' => '',
     ), $atts ); 

    ob_start(); ?>

<section id="woowcms" class="woowcms">
      <div class="row">
        <div class="large-12 columns">
          <div class="owl-carousel owl-theme">
	<?php
// The Query
if(!$sattr['category']){
	$the_query = new WP_Query( array(
	'post_type' => 'product',
));
} else {
	$the_query = new WP_Query( array(
	'post_type' => 'product',
	'tax_query' => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $sattr['category'],
		),
	),
));
}


if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post(); ?>
		 
            
            <div class="item wcm-product-wrapper">

            <div class="wcm-thumb">
                <?php $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($the_query->post->ID)); //var_dump($featured_image[0]);?>
					<?php if($featured_image) { ?>
					<img src="<?php echo $featured_image[0]; ?>" data-id="<?php echo $the_query->post->ID; ?>">
					<?php } ?>
            </div> 
            <div class="wcm-text-wrapper">
                  <div class="wcm-product-title">
                     <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </div>
                  <div class="wcm-cart-button-wrapper">
                   <div class="wcm-cart-button">
                       <?php echo do_shortcode('[add_to_cart id="'.get_the_ID().'"]');
                       
                      // $produc = wc_get_product(get_the_ID());
                      //  echo "<a href='" . $produc->add_to_cart_url() ."'>add to cart</a>";
                       
                       ?>
                    </div>
                  </div>
                  
            </div>             



             <!--  <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
               <?php $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($the_query->post->ID)); //var_dump($featured_image[0]);?>
        <?php if(!$featured_image) { ?>
        <img src="<?php echo $featured_image[0]; ?>" data-id="<?php echo $the_query->post->ID; ?>">
        <?php } ?>
        <div class="cart"><?php echo do_shortcode('[add_to_cart id="'.get_the_ID().'"]') ?></div> -->
            </div> 
          
	<?php }

	
	wp_reset_postdata();
} ?>

			</div>
        </div>
      </div>
    </section>
       
    

<?php $output = ob_get_clean();
    return $output;
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_shortcode( 'woowcms', 'woowcms_shortcode' );
}
 
/*
add_action( 'elementor/element/section/section_advanced/after_section_end', 'RH_custom_section_elementor', 10, 2);

function RH_custom_section_elementor( $obj, $args ) {
  $id = get_the_ID();
  $obj->start_controls_section(
      'section_rh_stickyel',
      array(
          'label' => esc_html__( 'Link tab', 'rehub-theme' ),
          'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
      )
  );

  $obj->add_control(
      'rh_stickyel_section_sticky',
      array(
          'label'        => esc_html__( $id, 'rehub-theme' ),
          'description' => esc_html__( 'You must have minimum two columns. Smart scroll is visible only on frontend site and not visible in Editor mode of Elementor', 'rehub-theme' ),
          'type'         => Elementor\Controls_Manager::SWITCHER,
          'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
          'label_off'    => esc_html__( 'No', 'rehub-theme' ),
          'return_value' => 'true',
          'prefix_class' => 'rh-elementor-sticky-',
      )
  );

  $obj->add_control(
      'rh_stickyel_top_spacing',
      array(
          'label'   => esc_html__( 'Top Spacing', 'rehub-theme' ),
          'type'    => Elementor\Controls_Manager::NUMBER,
          'min'     => 0,
          'max'     => 500,
          'step'    => 1,
          'condition' => array(
              'rh_stickyel_section_sticky' => 'true',
          ),
      )
  );

  $obj->add_control(
      'rh_stickyel_bottom_spacing',
      array(
          'label'   => esc_html__( 'Bottom Spacing', 'rehub-theme' ),
          'type'    => Elementor\Controls_Manager::NUMBER,
          'min'     => 0,
          'max'     => 500,
          'step'    => 1,
          'condition' => array(
              'rh_stickyel_section_sticky' => 'true',
          ),
      )
  );

  $obj->add_control(
      'rh_parallax_bg',
      array(
          'label'        => esc_html__( 'Enable parallax for background image', 'rehub-theme' ),
          'description' => esc_html__( 'Add background in Style section', 'rehub-theme' ),
          'type'         => Elementor\Controls_Manager::SWITCHER,
          'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
          'label_off'    => esc_html__( 'No', 'rehub-theme' ),
          'return_value' => 'true',
          'prefix_class' => 'rh-parallax-bg-',
      )
  );

  $obj->add_control(
      'rh_parallax_bg_speed',
      array(
          'label'   => esc_html__( 'Parallax speed', 'rehub-theme' ),
          'type'    => Elementor\Controls_Manager::NUMBER,
          'min'     => 1,
          'max'     => 200,
          'step'    => 1,
          'default' => 10,
          'condition' => array(
              'rh_parallax_bg' => 'true',
          ),
          'prefix_class' => 'rh-parallax-bg-speed-',
      )
  );      

  $obj->end_controls_section();
}*/