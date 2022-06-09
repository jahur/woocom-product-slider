<?php

namespace WOOWCMS\Includes\Public;

class Shortcode{

    function __construct(){
        add_shortcode( 'woowcms', array($this, 'woowcms_shortcode') );
    }


    public function woowcms_shortcode( $atts ) {

        $params = shortcode_atts( array(
            'category' => '',
            'items' => -1,
        ), $atts ); 
   
        ob_start(); 
       
        // The Query
        if(!$params['category']){

            $the_query = new \WP_Query( array(
                'post_type' => 'product',
                'posts_per_page' => $params['items'],
            ));

        } else {

            $cat_arr = explode (",", $params['category']);
            $the_query = new \WP_Query( array(
                'post_type' => 'product',
                'posts_per_page' => $params['items'],
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $cat_arr,
                    ),
                ),
            ));
        }

        $this->slider_template($the_query);
       
        $output = ob_get_clean();

        return $output;
   }

    public function slider_template($slider_query){ ?>

        <section id="woowcms" class="woowcms">
            <div class="row">
                <div class="large-12 columns">
                    <div class="owl-carousel owl-theme"> 
                        <?php
                        if($slider_query->have_posts()):
                            while($slider_query->have_posts()):

                                $slider_query->the_post(); 
                                $product = wc_get_product(get_the_ID());
                        ?>
                                    <div class="item wcm-product-wrapper">
    
                                        <div class="wcm-thumb">
                                            <?php $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($slider_query->post->ID)); ?>
                                                <?php if($featured_image) { ?>
                                                <a href="<?php the_permalink(); ?>">
                                                    <img src="<?php echo $featured_image[0]; ?>" data-id="<?php echo $slider_query->post->ID; ?>">
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
                                            </div>
                                                
                                        </div>             

                                    </div> 
                        
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;

                        ?>
                    </div>
            </div>
            </div>
        </section>

   <?php
   }
}