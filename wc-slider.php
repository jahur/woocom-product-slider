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


	wp_enqueue_style( 'docs-theme', plugins_url( '/assets/css/docs.theme.css', __FILE__ ), array(), '1.0.6' );

	wp_enqueue_style( 'owl-carousel', plugins_url( '/assets/owlcarousel/assets/owl.carousel.css', __FILE__ ), array(), '1.0.3' );

	wp_enqueue_style( 'owl-theme', plugins_url( '/assets/owlcarousel/assets/owl.theme.default.css', __FILE__ ), array(), '1.0.3' );

	wp_enqueue_script('script-owl-carousel', plugin_dir_url(__FILE__) . 'assets/owlcarousel/owl.carousel.js', array('jquery'), '1.0.1', true);

	wp_enqueue_script('custom.js', plugin_dir_url(__FILE__) . 'assets/owlcarousel/custom.js', array('jquery'), '1.0.3', true);

    wp_enqueue_style('docs.theme');
    wp_enqueue_style('owl.carousel');
    wp_enqueue_style('owl.theme.default');

    //wp_enqueue_script('JQuery');
    wp_enqueue_script('script-owl-carousel');
    wp_enqueue_script('custom.js');

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
                     <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                  </div>
                  <div class="wcm-cart-button-wrapper">
                   <div class="wcm-cart-button"><?php echo do_shortcode('[add_to_cart id="'.get_the_ID().'"]') ?></div>
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
       
    

<?php echo ob_get_clean();
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_shortcode( 'woowcms', 'woowcms_shortcode' );
}
 