<?php
/*
Plugin Name: WC Slider
Plugin URI: 
Description: Woocommerce product slider. Shortcode [woowcms], [woowcms category="music"]
Author: Jahur Ahmed
Version: 1.0.2
Author URI: http://pressiva.com
Text Domain: woowcms
*/


//script $ css
function woowcms_scripts() {

	wp_enqueue_style( 'owl-carousel', plugins_url( '/assets/owlcarousel/assets/owl.carousel.css', __FILE__ ), array(), '1.0.17' );

	wp_enqueue_script('script-owl-carousel', plugin_dir_url(__FILE__) . 'assets/owlcarousel/owl.carousel.js', array('jquery'), '1.0.1', true);

	wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . 'assets/owlcarousel/custom.js', array('jquery'), '1.0.7', true);

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

    $sattr_arr = explode (",", $sattr['category']);
	$the_query = new WP_Query( array(
	'post_type' => 'product',
	'tax_query' => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $sattr_arr,
		),
	),
));
}


if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
        $the_query->the_post(); 
        $product = wc_get_product(get_the_ID());
        ?>
		
            
            <div class="item wcm-product-wrapper">

            <div class="wcm-thumb">
                <?php $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($the_query->post->ID)); //var_dump($featured_image[0]);?>
					<?php if($featured_image) { ?>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $featured_image[0]; ?>" data-id="<?php echo $the_query->post->ID; ?>">
                    </a>
					<?php } ?>
            </div> 
            <div class="wcm-text-wrapper">
                  <div class="wcm-product-title">
                     <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </div>
                  <div class="wcm-cart-button-wrapper">
                  <div class="wcm-flexbox-container">
	<div class="price-wrapper"><?php echo $product->get_price_html(); ?></div>
	<div class="cart-button-wrapper">
    <a href="<?php echo $product->add_to_cart_url(); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo get_the_ID(); ?>" aria-label="Add “<?php echo get_the_title(); ?>” to your cart" rel="nofollow">Add to cart</a>
    </div>
</div>
                   <div class="wcm-cart-button">
                       <?php //echo do_shortcode('[add_to_cart id="'.get_the_ID().'"]');
                       
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
 