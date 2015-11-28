<?php
/**
 * Template Name: Filter Product
 */
get_header(); 
if($_REQUEST['search'] != '')
{
?>
        <section id="productssection">
            <div  class="container">
                <div class="row">
                    <div class="sectionheading">
                    <h2> Search Result </h2>
                    </div>
                    <?php /*******************Code to list allcategories**************************/
					$args = array(
						'number'     => $number,
						'orderby'    => $orderby,
						'order'      => ASC,
						'hide_empty' => $hide_empty,
						'include'    => $ids,
						'parent' => 0
					);
					$product_categories = get_terms( 'product_cat', $args ); ?>
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs searchCat" role="tablist">
							<?php /*******************Loop to list all categories****************************/ 
                            foreach( $product_categories as $cat ) {
                            $category_thumbnail = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
                            $image = wp_get_attachment_url($category_thumbnail); ?>
                                <li role="presentation" class="active page-scroll col-sm-2">
                                <a href="#<?php echo $cat->slug; ?>" aria-controls="<?php echo $cat->name; ?>" role="tab" data-toggle="tab"> 
                                <?php  $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => $cat->name, 'orderby' => 'rand' );
        										$loop = new WP_Query( $args ); 
												 while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                                                 <?php the_post_thumbnail('thumbnail', array('class' => 'thumbImg')); ?>
                                                 <span><?php echo $cat->name; ?></span>
                                                 <?php endwhile; ?>
   												 <?php wp_reset_query(); ?>
                                    <?php //echo '<img src="'.$image.'" width="100px" height="100px" class="thumbImg">'; ?>  
                                    <span><?php //echo $cat->name; ?></span>
                                 </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php  /*******************Loop to list products by category****************************/ 
					
					 foreach( $product_categories as $cat ) { ?>
                       <div class="searchResult" id="<?php echo $cat->slug; ?>">
                        <div class="col-lg-12"><h3><?php echo $cat->name; ?></h3></div>
                        <?php $catName = trim($cat->name);?>
                    <?php $related_id_list = $_REQUEST['search']; /**********Getting product ids from url***********/
                    $related_product_ids = explode(",", trim($related_id_list,','));
                    $_pf = new WC_Product_Factory();  
					$i = 1;
                    foreach ($related_product_ids as $id) {
                    $product = wc_get_product( $id ); 
					if(isset($product->id))
					{ 
					if($i > 8)
						{ ?>
                        <button class="pull-right productMore">See More</button>
							<?php break;
						}
						/******************************code to call product according to category************************/
						$catName = $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); 
						$array = explode('/product-category/', $catName);
						$name = explode('</a>', $array[1]); 
						$name2 = explode('>', $name[0]);
						 if(trim($name2[1]) == trim($cat->name))
						 /******************************************************************************************************/
							{
							if($i <= 4)
							{ ?>
								<div class="col-md-3 col-sm-6 productsItem" style="margin-top:0px;">
							<?php } else
							{ ?>
								<div class="col-md-3 col-sm-6 productsItem" style="margin-top:58px;">
							<?php }?>
									<div class="searchImage">
										<a href="<?php echo $product->post->guid; ?>" class="productsImages"><?php echo $product->get_image('medium'); ?> </a>
									</div>
									<div class="productsDetails"> <a href="<?php echo $product->post->guid; ?>" class="productsName"><?php echo $product->get_title(); ?></a>
										<div class="productsPrice"> <?php echo $product->get_price_html(); ?> </div>
										<div class="productsid"><?php $i++; ?>
										<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' );  ?>
										</div>
										<span class="btn btn-primary pull-left"><?php woocommerce_template_loop_add_to_cart( $product->post, $product ); ?></span>
										<a href="<?php echo $product->post->guid; ?>" class="btn btn-primary  pull-right"> Details </a> 
									</div>
								</div>
							<?php }
					}
					}  ?>
                     </div>
                    <div class="col-lg-12"><hr /></div>
				  <?php }?>
                  
                </div>
                <!-- /.row --> 
               
            </div>
        </section>
         <?php }
				else
				{ ?>
                <section id="productssection">
                    <div  class="container">
                        <div class="row">
                            <div class="sectionheading">
                            <h2 class="noResultNmessage"> No Results Found </h2>
                            </div>
                         </div>
                      </div>
                   </section>
				<?php }?>
<?php get_footer(); ?>