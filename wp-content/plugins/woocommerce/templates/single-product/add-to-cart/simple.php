<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$orig_id = $product->id;
if(isset($_REQUEST["sel"]))
	$orig_id = $_REQUEST["sel"];
$product1 = $product;
$product = wc_get_product($orig_id);

if ( ! $product->is_purchasable() ) {
	return;
}

?>

<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 	<?php
	 	if ( ! $product->is_sold_individually() ) {
	 		$defaults = array(
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', '', $product ),
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', '1', $product ),
				'step'        => apply_filters( 'woocommerce_quantity_input_step', '1', $product ),
				'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
			);
			if ( ! empty( $defaults['min_value'] ) )
				$min = $defaults['min_value'];
			else $min = 1;
			if ( ! empty( $defaults['max_value'] ) )
				$max = $defaults['max_value'];
			else $max = 10;
			if ( ! empty( $defaults['step'] ) )
				$step = $defaults['step'];
			else $step = 1;
			if ( ! empty( $defaults['input_value'] ) )
				$input_value = $defaults['input_value'];
			else $input_value = 1;
			?>
			<div class="quantity">
				<select name="<?php echo esc_attr( $input_name ); ?>" title="<?php _ex( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="qty">
				<?php
				for ( $count = $min; $count <= $max; $count = $count+$step ) {
					if ( $count == $input_value )
						$selected = ' selected';
					else $selected = '';
					echo '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
				}
				?>
				</select>
			</div>
		<?php
			}
	 	?>

	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

	 	<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif;
$product = $product1;
?>
