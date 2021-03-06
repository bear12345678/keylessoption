<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' ); ?>

		<div class="comment-text">

			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating review_rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
					<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
				
				
<?php /*Start********************** To Print Stars for Reviews 17-Nov-2015******************/
				global $wpdb;
				$count1 = $wpdb->get_var("
       SELECT meta_value FROM $wpdb->commentmeta
       WHERE meta_key = 'rating'
       AND comment_id = ".$comment->comment_ID."
       AND meta_value > 0
       ");
       if ( $count1 > 0 ) :
         echo '<span class="info-reviews1"> <div class="starRate">  <div class="star_Reviews"> Reviews: <span class="reviewsStar">';
         for($i = 0; $i < $count1; $i++)
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
          echo '</span></div> </div></span>';
		  
         else:
        endif;
/*End********************** To Print Stars for Reviews******************/  
?>
        </div>
        

			<?php endif; ?>

			<?php if ( $comment->comment_approved == '0' ) : ?>

				<p class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></p>

			<?php else : ?>

				<p class="meta">
					<strong itemprop="author"><?php comment_author(); ?></strong> <?php

						if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
							if ( wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $comment->comment_post_ID ) )
								echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';

					?>&ndash; <time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( wc_date_format() ); ?></time>:
				</p>

			<?php endif; ?>

			<div itemprop="description" class="description"><?php comment_text(); ?></div>
		</div>
	</div>
