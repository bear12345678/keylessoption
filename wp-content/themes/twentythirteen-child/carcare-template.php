<?php
/**
 * Template Name: Car Care
 */
get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post();  ?>
            	<div class="sectionheading innerPageTitle">
						<h2><?php the_title(); ?></h2>
					</div>
            <?php endwhile;?>
          
 <div class="container carcare-section">
      <div  class="col-sm-12">
         <div class="col-xs-3 tabs-list"> <!-- required for floating -->
          <!-- Nav tabs -->
          <ul class="nav nav-tabs tabs-left">
            <?php $wcatTerms = get_terms('product_cat', array('hide_empty' => 0, 'orderby' => 'ASC', 'parent' => 27, )); 
			$num=1;
        foreach($wcatTerms as $wcatTerm) : ?> 
            <li <?php if($num == 1) { echo "class='active'"; } ?>><a href="#<?php echo $wcatTerm->slug; ?>" data-toggle="tab"><?php echo $wcatTerm->name; ?></a></li>
            <?php $num++; ?>
            <?php endforeach; ?> 
          </ul>
        </div>

        <div class="col-xs-9 products-list">
          <!-- Tab panes -->
          <div class="tab-content">
          <?php $wcatTerms = get_terms('product_cat', array('hide_empty' => 0, 'orderby' => 'ASC', 'parent' => 27, )); 
		  $numtab=1;
        foreach($wcatTerms as $wcatTerm) : ?> 
        <div class="tab-pane <?php if($numtab == 1) { echo "active"; } ?>" id="<?php echo $wcatTerm->slug; ?>">
			<ul class="products">
				<div class="row">
		<?php $product_cat= $wcatTerm->slug;
		   $args = array( 'post_type' => 'product', 'stock' => 1, 'posts_per_page' => -1, 'orderby' =>'date', 'product_cat' => $product_cat, 'order' => 'DESC' );
                    $loop = new WP_Query( $args );
					$i = 1;
                    while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
					if($i <= 3)
					{ ?>
                    	<li class="col-md-4 col-sm-6 productsItem" style="margin-top:0px;">
					<?php } else
					{ ?>
                    	<li class="col-md-4 col-sm-6 productsItem" style="margin-top:58px;">
    				<?php }?>
                                <a href="<?php the_permalink(); ?>" class="ItemImages">
									<div id="id-<?php the_id(); ?>" title="<?php the_title(); ?>" class="productsImages" >
									<?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'small'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" />'; ?>
										<span class="btn btn-primary btnDetails"> Details</span> 
								   </div>
								   </a>
                                    <div class="productsDetails"> 
										<div class="MRP">
											 <a href="<?php the_permalink(); ?>" class="productsName"><?php the_title(); ?></a>
										</div>
										  <div class="cartDetails">
											<span class="add_to_cart_span"><a href="?add-to-cart=<?php echo $loop->post->ID; ?>" rel="nofollow" data-product_id="<?php echo $loop->post->ID; ?>" class="btn btn-primary">Add to cart</a></span>
											<!--<span class="btn btn-primary pull-left"><?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?></span>-->
											<div class="productsPrice"> <?php echo $product->get_price_html(); ?></div>                                    
										  </div>
									</div>
                     		</li>
							<?php  $i++;
				endwhile;  wp_reset_query($args); ?>
           
				</div>
			</ul>	  
        </div> <!-- tab-pane-->
 <?php $numtab++; endforeach; ?> 

      </div> <!-- tab-content -->
	</div> <!-- col-xs-9-->
		
    </div> <!-- col-sm-12-->
  </div><!-- container -->
  
  
<?php get_sidebar(); ?>
<?php get_footer(); ?>