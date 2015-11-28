<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); 
global $woocommerce, $wpdb;?>

<!-- Shipping Section  -->
<section id="shippingSection">
<div class="container text-center">
<div class="row">
  <div class="col-sm-4"> <div class="offerIcon"><img src="<?php echo get_stylesheet_directory_uri();  ?>/img/transport759.png"   alt="" /> </div> 
  <h4>Free Shipping</h4></div>
  
  <div class="col-sm-4"> <div class="offerIcon"> <img src="<?php echo get_stylesheet_directory_uri();  ?>/img/badges3.png" alt="" /></div> <h4>90 Days Warranty</h4> </div>
  <div class="col-sm-4"> <div class="offerIcon"><img src="<?php echo get_stylesheet_directory_uri();  ?>/img/return8.png"   alt="" /> </div>  <h4>Hassle Free Returns</h4></div>
  
   </div>
        <!-- /.row --> 
    </div>
</section>


<!-- products Section -->
<section id="specialtyShopsSection">
    <div  class="container">
        <div class="row">
            <div class="sectionheading">
                <h2> Our Specialty Shops </h2>
                <!--<p class="subheading">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>-->
            </div>
            <div class="col-sm-4 specialtyItem">
            	<?php $id = 42;
				if( $term = get_term_by( 'id', $id, 'product_cat' ) ){ ?>
					
				<?php } ?>
            
                <div class="specialty"> <img src="<?php echo get_stylesheet_directory_uri();  ?>/img/zuok619s.png" alt=""></div>
                <h3>Replacements Remotes and Keys </h3>
                <p>Shop from any device in as little as 
                5 minutes.</p>
            </div>
            <div class="col-sm-4 specialtyItem">
                <div class="specialty"> <img src="<?php echo get_stylesheet_directory_uri();  ?>/img/electric2.png"  alt=""></div>
                <h3>LED Light Conversions</h3>
                <p>Shop from any device in as little as 
                5 minutes.</p>
            </div>
            <div class="col-sm-4 specialtyItem">
                <div class="specialty"> <img src="<?php echo get_stylesheet_directory_uri();  ?>/img/cleaning.png"  alt=""></div>
                <h3>Car Care Products </h3>
                <p>Shop from any device in as little as 
                5 minutes.</p>
            </div>
        </div>
        <!-- /.row --> 
    </div>
</section>






<!-- Shipping Section  -->
<section id="submitTicketSection">
<div class="SectionPattern"> </div>
<div class="container text-center">
<div class="row">
 <div class="col-sm-12">   <h2>Submit a Ticket for Technical Support</h2>   <a href="#" class="clickHere">Click Here </a>  </div>
  
   </div>
        <!-- /.row --> 
    </div>
</section>

<!-- products Section -->
<section id="productssection">
    <div  class="container">
        <div class="row">
            <div class="sectionheading">
            	<h2> Featured Products </h2>
            </div>
         	<?php $args = array( 'post_type' => 'product', 'stock' => 1, 'posts_per_page' => 8, 'orderby' =>'date','order' => 'DESC' );
                    $loop = new WP_Query( $args );
					$i = 1;
                    while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
					if($i <= 4)
					{ ?>
                    	<div class="col-md-3 col-sm-6 productsItem" style="margin-top:0px;">
					<?php } else
					{ ?>
                    	<div class="col-md-3 col-sm-6 productsItem" style="margin-top:58px;">
    				<?php }?>
                                <a href="<?php the_permalink(); ?>" class="ItemImages"><div id="id-<?php the_id(); ?>" title="<?php the_title(); ?>" class="productsImages" >
                                   <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'small'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" /></a>'; ?><span class="btn btn-primary btnDetails"> Details</span> </div></a>
                                    <div class="productsDetails"> 
                                    <div class="MRP">
                                         <a href="<?php the_permalink(); ?>" class="productsName"><?php the_title(); ?></a>
                                         <!--<div class="productsPrice"> <?php echo $product->get_price_html(); ?></div>-->
                                    </div>
                                  <div class="cartDetails">
                                    <span class="btn btn-primary pull-left"><?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?></span>
									<div class="productsPrice"> <?php echo $product->get_price_html(); ?></div>                                    
                                    <!--<a href="<?php the_permalink(); ?>" class="btn btn-primary  pull-right"> Details </a>--></div>
                                     </div>
                             </div>
                <?php  $i++;
				endwhile;  wp_reset_query($args); ?>
        </div>
        <!-- /.row --> 
    </div>
</section>
               <?php $args = array( 
                'number'      => 100, 
                'status'      => 'approve', 
                'post_status' => 'publish', 
                'post_type'   => 'product',
				'post_id' => $postId,
        );
 $comments = get_comments( $args );
 ?>
    <!-- ***********************************************************************************-->
<section id="carousel" class="carouselCustomSlider">   
    <div class="SectionPattern"> </div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="carousel slide" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
				  <!-- Carousel indicators -->
                  <ol class="carousel-indicators">
				    <li data-target="#fade-quote-carousel" data-slide-to="0" class="active"></li>
				    <li data-target="#fade-quote-carousel" data-slide-to="1"></li>
				    <li data-target="#fade-quote-carousel" data-slide-to="2"></li>
				  </ol>
				  <!-- Carousel items -->
				  <div class="carousel-inner">
                   <?php foreach($comments as $index => $value)
         			{ ?>
				    <div class="<?php if($index == 0) { echo "active";}?> item">
				    	<blockquote>
                        	<div class="allProduct Ratings">
								<?php $count = $wpdb->get_var("
									SELECT COUNT(meta_value) FROM $wpdb->commentmeta
									LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
									WHERE meta_key = 'rating'
									AND comment_post_ID = ".$value->comment_post_ID."
									AND comment_approved = '1'
									AND meta_value > 0
									");
									$rating = $wpdb->get_var("
									SELECT SUM(meta_value) FROM $wpdb->commentmeta
									LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
									WHERE meta_key = 'rating'
									AND comment_post_ID = ".$value->comment_post_ID."
									AND comment_approved = '1'
									");
                                if ( $count > 0 ) :
									$average = number_format($rating / $count, 2);
									$starNum = explode('.',$average);
									$starNum[0];
									echo '<span class="info-reviews"> <span class="starRate"> <span class="adminName"> Average Customer </span>  
									<span class="star_Reviews homeReview"> Reviews: <span class="reviewsStar">';
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
									echo '</span> </span></span></span>';
									echo '<span class="totalRates"> Total Reviews: '.$count.'<br /><span style="width:'.($average*16).'px"><span itemprop="ratingValue" class="rating">'.$starNum[0].'</span> '.__(' of 5', 'woocommerce').'</span></span>';
                                else:
                                endif; ?></div>
                                 <div class="authormeta"><div class="carouselsingleReview"><?php $count1 = $wpdb->get_var("
							SELECT meta_value FROM $wpdb->commentmeta
							WHERE meta_key = 'rating'
							AND comment_id = ".$value->comment_ID."
							AND meta_value > 0
							");
							if ( $count1 > 0 ) :
									echo '<span class="info-reviews"> <span class="starRate">  <span class="star_Reviews"> Reviews: <span class="reviewsStar">';
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
										echo '</span></span> </span></span>';
									else:
								endif; ?></div>                        
                            <div class="carouselDate"><?php echo $value->comment_date; ?></div>
                            </div>
				    		<div class="crauselCommentContent">
							<div class="crauselCommentAuthor">Reviewer: <?php echo $value->comment_author;  ?></div>
							<?php echo $value->comment_content; ?></div>
				    	</blockquote>
				    </div>
                    <?php } ?>
				  </div>
				</div>
			</div>							
		</div>
	</div>
</section>


    
    
    <!-- ***********************************************************************************-->

<!-- Blog Thumb section -->
<section id="postSection">
<div class="container content">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> <!-- Indicators -->
    <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="row">
                    <div class="sectionheading">
                        <h2> Blog Thumb </h2>
                    </div>
                    <?php query_posts('cat=18&posts_per_page=2');
                    while (have_posts()) : the_post(); ?>
                    <div class="col-sm-6">
                        <div class="thumbnail adjust1 ">
                            <div class="circle_img">
                                <a href="<?php the_permalink();?>"><?php the_post_thumbnail('thumbnail', array('class' => 'media-object img-rounded img-responsive'));?></a>
                            </div>
                            <div class="caption">
                                <a href="<?php the_permalink(); ?>" class="text-info lead adjust2" ><?php the_title();?></a>
                                <?php  the_content(); ?>
                                <div class="adjust2">
                                <small>
                                    <a href="<?php the_permalink();?>"><?php the_author(); ?></a>
                                    <a href="<?php the_permalink();?>"><?php the_date(); ?></a>
                                </small> 
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>