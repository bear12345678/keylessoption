<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$orig_id = $product->id;
if(isset($_REQUEST["sel"]))
	$orig_id = $_REQUEST["sel"];
$post1 = get_post($orig_id);
if ( ! $post1->post_excerpt ) {
	return;
}

?>
<div itemprop="description">
	<?php echo apply_filters( 'woocommerce_short_description', $post1->post_excerpt ) ?>
</div>
