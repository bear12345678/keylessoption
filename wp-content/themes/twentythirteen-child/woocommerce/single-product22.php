<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) 
{
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 
global $product;?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		//do_action( 'woocommerce_before_main_content' );
	?>
<section id="productssection">
<div  class="container">
<div class="row">
		<?php while ( have_posts() ) : the_post(); ?>
		<?php $postId = get_the_ID(); ?> 
    <div class="sectionheading">
        <!--<h2> Featured Products </h2>
        <p class="subheading">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>-->
    </div>
    <?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="editProductlink">', '</span>' ); ?>
    <div class="col-sm-5 productImag">
    	<?php the_post_thumbnail('large', array('class' => 'img-responsive'));?>
    </div>
    <div class="col-sm-7">
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
        <?php /******************upsell code************************/
		global $woocommerce_loop;

$upsells = $product->get_upsells();
if ( sizeof( $upsells ) == 0 )
{
	/*echo "<pre>";
	print_r($product);
		echo "</pre>";*/
		 
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

				<?php //wc_get_template_part( 'content', 'product' ); ?>
                <a href="<?php the_permalink(); ?>">
                	<div class="upsellProduct"><?php echo get_the_post_thumbnail( $post_id, array( 'auto', 36) ); ?></div>
                    <div class="upsellPrice"><?php echo $product->get_price_html();?></div>
                 </a>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;
}
wp_reset_postdata();


		/***********************************************/?>
        <div class="priceProducts"><span class="priceMrp">Price: <span>$<?php echo $sale_price = get_post_meta( get_the_ID(), '_price', true); ?>
        </span></span> 
       </div>
       <form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart" method="post" enctype='multipart/form-data'>
  <?php      /******************Code for variations**********************/
$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();

ob_start();

?>

<table class="shop_attributes">

	<?php if ( $product->enable_dimensions_display() ) : ?>

	<?php if ( $product->has_weight() ) : $has_row = true; ?>
			<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
				<th><?php _e( 'Weight', 'woocommerce' ) ?></th>
				<td class="product_weight"><?php echo $product->get_weight() . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $product->has_dimensions() ) : $has_row = true; ?>
			<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
				<th><?php _e( 'Dimensions', 'woocommerce' ) ?></th>
				<td class="product_dimensions"><?php echo $product->get_dimensions(); ?></td>
			</tr>
		<?php endif; ?>

	<?php endif; ?>
	<?php foreach ( $attributes as $attribute ) :
		if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
			continue;
		} else {
			$has_row = true;
		}
		?>
		<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
			<th><?php echo wc_attribute_label( $attribute['name'] ); ?></th>
			<td><?php
				if ( $attribute['is_taxonomy'] ) 
				{

					$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

				} else {

					// Convert pipes to commas and display values
					$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) ); ?>
					<select data-attribute_name="attribute_<?php echo wc_attribute_label( $attribute['name'] ); ?>" name="attribute_<?php echo wc_attribute_label( $attribute['name'] ); ?>" class="" id="<?php echo wc_attribute_label( $attribute['name'] ); ?>">
					<?php foreach($values as $val)
					{ ?>
						<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
					<?php } ?>
                    </select>
					<?php //echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

				}
			?></td>
		</tr>
	<?php endforeach; ?>

</table>
<?php
if ( $has_row ) {
	echo ob_get_clean();
} else {
	ob_end_clean();
}	?>

<div class="quantity-cart">    
       

<?php global $product;
?>

<?php if ( ! $product->is_in_stock() ) : ?>

    <a href="<?php echo apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ); ?>" class="button"><?php echo apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', 'woocommerce' ) ); ?></a>

<?php else : ?>

    <?php
        $link = array(
            'url'   => '',
            'label' => 'Add To Cart',
            'class' => ''
        );

        $handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );

        switch ( $handler ) {
            case "variable" :
                //$link['url']    = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
				$link['url']    =  apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ).'?add-to-cart=186'); 
                $link['label']  = apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'woocommerce' ) );
            break;
            case "grouped" :
               $link['url']    = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
                $link['label']  = apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'woocommerce' ) );
            break;
            case "external" :
                $link['url']    = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
                $link['label']  = apply_filters( 'external_add_to_cart_text', __( 'Read More', 'woocommerce' ) );
            break;
            default :
                if ( $product->is_purchasable() ) {
                    $link['url']    = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
                    $link['label']  = apply_filters( 'add_to_cart_text', __( 'Add to cart', 'woocommerce' ) );
                    $link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button' );
                } else {
                    $link['url']    = apply_filters( 'not_purchasable_url', get_permalink( $product->id ) );
                    $link['label']  = apply_filters( 'not_purchasable_text', __( 'Read More', 'woocommerce' ) );
                }
            break;
        }
       // if ( $product->product_type == 'simple' ) {
 //echo $link['url']; 
            ?>
            
        <div class="quanity-number"> Quantity:
            <?php woocommerce_quantity_input(); ?>
        </div>
		
			
        <div class="pull-right btn btn-primary"> <i class="fa fa-shopping-cart"></i> &nbsp; 
           <input type="submit" class="button alt" value="<?php echo $link['label']; ?>"/>
  		</div> 
      
            </form>
			
			
            <?php echo do_shortcode('[wc_quick_buy]');
			

      /*  } else {
            echo apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s button product_type_%s">%s</a>', esc_url( $link['url'] ), esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_attr( $product->product_type ), esc_html( $link['label'] ) ), $product, $link );
        }*/
    ?>

<?php endif; ?>



        </div> 
        
	  
<?php
$subheadingvalues = get_the_terms( $product->id, 'pa_color');

      foreach ( $subheadingvalues as $subheadingvalue ) {
       echo $subheadingvalue->name;
        } ?>        
        
        <div class="share"> 
        	Share:<div class="shareButton"><?php echo do_shortcode( '[woocommerce_social_media_share_buttons]' ); ?></div>
        </div>
        <div class="reviews reviewstab">  
        <span id="readReview" class="reviewLink">Read Reviews</span> <span id="addReview" class="reviewLink">Write a Review</span>
        
         <?php global $woocommerce,$post, $wpdb;
		$count = $wpdb->get_var("
							SELECT COUNT(meta_value) FROM $wpdb->commentmeta
							LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
							WHERE meta_key = 'rating'
							AND comment_post_ID = $post->ID
							AND comment_approved = '1'
							AND meta_value > 0
							");
		$rating = $wpdb->get_var("
							SELECT SUM(meta_value) FROM $wpdb->commentmeta
							LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
							WHERE meta_key = 'rating'
							AND comment_post_ID = $post->ID
							AND comment_approved = '1'
							");
		if ( $count > 0 ) :
			$average = number_format($rating / $count, 2);
			$starNum = explode('.',$average);
			$starNum[0];
			echo '<span class="info-reviews"> <div class="starRate">Average Customer  <div class="star_Reviews"> Reviews: <span class="reviewsStar">';
			for($i = 0; $i < $starNum[0]; $i++)
			{
				echo '<i class="fa fa-star"></i>';
			}
			$a = 5-$i;
			if($a != 0)
			{
				
				for($z = 0; $z < $a; $z++)
				{
					echo '<i class="fa fa-star-o"></i>';
				}
			}
				echo '</span></div> </div>';
			
			echo '<div class="totalRates"> Total Reviews: '.$count.'<br /><span style="width:'.($average*16).'px"><span itemprop="ratingValue" class="rating">'.$starNum[0].'</span> '.__(' of 5', 'woocommerce').'</span></div>';
			if ( is_product() ) : 
				echo '<div class="clear"></div>';
			else :
				echo '';
			endif;
			else:
			echo 'No Reviews';
		endif;
	/*endif;  */
        /********************************************************************************************/ ?>
        </span>  </div>
    <?php $args = array( 
                'number'      => 100, 
                'status'      => 'approve', 
                'post_status' => 'publish', 
                'post_type'   => 'product',
				'post_id' => $postId,
        );

 $comments = get_comments( $args );?>
         <div id="reviews" style="display:block;">
         <?php foreach($comments as $index => $value)
         { ?>
         <div class="reviewComment">
             <div class="commentAuthor"><?php echo $value->comment_author;  ?></div>
             <div class="commentDateTime"><?php echo $value->comment_date; ?></div>
             <div class="commentData"><?php echo $value->comment_content; ?></div>
          </div>
        <?php } ?>
         </div>
         <div id="reviewForm" style="display:none;">
         <?php //comment_form(); ?>
        <?php  wc_get_template( 'single-product-reviews.php' ); ?>
         </div>
    </div>


<?php //wc_get_template_part( 'content', 'single-product' ); ?>
		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
		
?>

</div>
</div>
</section>              
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#readReview").click(function(){
			jQuery("#readReview").addClass("active");
			jQuery("#addReview").removeClass("active");
			jQuery("#reviews").show();
			jQuery("#reviewForm").hide();
			//jQuery("#reviews").toggle();
		});
		jQuery("#addReview").click(function(){
			jQuery("#addReview").addClass("active");
			jQuery("#readReview").removeClass("active");
			jQuery("#reviewForm").show();
			jQuery("#reviews").hide();
			//jQuery("#reviewForm").toggle();	
		});

	$(function() {

  $(".numbers-row").append('<div class="inc button">+</div><div class="dec button">-</div>');

  $(".button").on("click", function() {

    var $button = $(this);
    var oldValue = $button.parent().find("input").val();

    if ($button.text() == "+") {
  	  var newVal = parseFloat(oldValue) + 1;
  	} else {
	   // Don't allow decrementing below zero
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
	    } else {
        newVal = 0;
      }
	  }

    $button.parent().find("input").val(newVal);

  });

});
	});
</script>        
              
<?php get_footer( 'shop' ); ?>