<?php
/**
 * Single Product Meta
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



$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">
   
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
	<table>
    	
	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		<tr><td><?php _e( '<b>Product Code</b>:', 'woocommerce' ); ?></td><td><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></td></tr>
		<!--<span class="sku_wrapper"><?php // _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php //echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>-->

	<?php endif; 
	//echo "<pre>";
	//print_r($product);
	//echo "</pre>";?>
    <?php $fccId = get_post_meta($orig_id, 'FCC ID', true); 
	if(isset($fccId))
	{
		echo '<tr><td><b>FCC ID</b>:</td><span class="sku_wrapper"><td>'.$fccId.'</span></td></tr>';
	}?>
    <?php $condition = get_post_meta($orig_id, 'condition', true); 
	if(isset($condition))
	{
		echo '<tr><td><b>Condition</b>:</td><span class="sku_wrapper"><td>'.$condition.'</span></td></tr>';
	}?>
     <?php $ICOther = get_post_meta($orig_id, 'IC/Other', true); 
	if(isset($ICOther))
	{
		echo '<tr><td><b>IC/Other</b>:</td><span class="sku_wrapper"><td>'.$ICOther.'</span></td></tr>';
	}?>
     <?php $Part_Number = get_post_meta($orig_id, 'Part_Number', true); 
	if(isset($Part_Number))
	{
		echo '<tr><td><b>Part Number</b>:</td><span class="sku_wrapper"><td>'.$Part_Number.'</span></td></tr>';
	}?>
       <?php $Programming = get_post_meta($orig_id, 'Programming', true); 
	if(isset($Programming))
	{
		echo '<tr><td><b>Programming</b>:</td><span class="sku_wrapper"><td>'.$Programming.'</span></td></tr>';
	}?>


	<?php //echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>
	 </table>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
