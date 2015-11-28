<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$orig_id = $product->id;
if(isset($_REQUEST["sel"]))
	$orig_id = $_REQUEST["sel"];

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) );

?>

<?php if ( $heading ): ?>
  <h2><?php echo $heading; ?></h2>
<?php endif; ?>

<?php
$content = apply_filters( 'the_content', get_the_content($orig_id) );
$content = str_replace( ']]>', ']]&gt;', $content );
echo $content;
?>
