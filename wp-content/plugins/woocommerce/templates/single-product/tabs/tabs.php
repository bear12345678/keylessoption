<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		
<?php
/*Start**********************  To Print Stars for Average Reviews 17-Nov-2015******************/
		global $woocommerce,$post, $wpdb;
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
   echo '<span class="product_average_reviews"> <div class="starRate">Average Customer  <div class="star_Reviews"> Reviews: <span class="reviewsStar">';
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
    echo '<div class="clear"></div></span>';
   else :
    echo '';
   endif;
   else:
   echo '<span class="product_average_reviews no_average_reviews">No Reviews</span>';
  endif;
 /*endif;  */
 /*End********************** To Print Stars for Average Reviews******************/
 ?>
		<ul class="tabs wc-tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			</div>
		<?php endforeach; ?>
		
		
		<!-- Script to add Review rating stars --> 
<script>
  	
	jQuery(document).ready(function()
	{
		alert("hello");
		$('.comment-form-rating .stars').find( 'i' ).click(function() 
		{
			alert(jQuery(this).parent().prop('id') );
		});
		//setTimeout(function(){ alert("Hello"); }, 2000); // alert("mmmm");
				//.find( 'li.reviews_tab a' ).click()
		/*$( '.comment-form-rating .stars i').each(function() 
		{
			//jQuery(this).click(function()
			//{
				//alert("hell55o");
				//
				//var $this = $(this);  .stars a
				//if ($this.hasClass('fa-star-o')) 
				//{
					setTimeout(function()
					{ 
						alert("hell55o");
						//$this.removeClass('fa-star-o');
						//$this.addClass('fa-star');
					}, 500);
			/*} 
			else 
			{
				setTimeout(function()
				{
					$this.removeClass('fa-star');
					$this.addClass('fa-star-o');
				}, 500);
			}*/
		  
		   // var id = jQuery(this).parent().prop('id');
		  //  alert(id);
			//});
		});
	});
	
</script>
	</div>

<?php endif; ?>
