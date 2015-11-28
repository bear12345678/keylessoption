<?php
/**
 * Single Product Custom Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) 
{
	$post_id = $product->post->ID;
}
else
{
$meta_query = WC()->query->get_meta_query();

$argsUpsell = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $argsUpsell );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

	<div class="upsells products">

		<h2><?php //_e( 'You may also like&hellip;', 'woocommerce' ) ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php //wc_get_template_part( 'content', 'product' );
					//$post_id = $product->post->ID;
				?>
                <a href="<?php echo get_permalink(get_the_ID()); //echo '?add-to-cart='.get_the_ID(); ?>"  
				<?php $cart_items=WC()->cart->get_cart(); 
					foreach( $cart_items as $item => $values ) 
					 {
							$cart_product = $values['data'];
						   							
							if( get_the_ID() == $cart_product->id ) 
							{
								echo 'title="Added to Your Cart"';
								echo 'class="added-to-cart"';
							}
							/*else
							{
								echo 'title="'.get_the_ID().'!='.$cart_product->id.'"';
								//echo 'class="not-in-cart"';
							}	*/ 
						}  ?> >
                	<div class="upsellProduct"><?php echo get_the_post_thumbnail( $post_id, array( 'auto', 36) ); ?></div>
                    <div class="upsellPrice"><?php $price = get_post_meta( get_the_ID(), '_regular_price', true); echo '$'.number_format($price,2); ?></div>
                 </a>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;
}
wp_reset_postdata();