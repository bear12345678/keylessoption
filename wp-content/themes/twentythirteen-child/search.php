<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); 
 ?>

	<div id="primary" class="content-area container">
		<div id="content" class="site-content row" role="main">
		<?php if ( have_posts() ) : ?>
			<div class="sectionheading searchjHeading">
				<h2><?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?></h2>
			</div>

			<?php /* The loop */ 
			$i =1; ?>
			<?php while ( have_posts() ) : the_post(); ?>
                     <?php /***************************************/?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <div class="col-md-3 col-sm-6 productsItem" <?php if($i <= 4){ echo 'style="margin-top:0px; margin-bottom:10px;"'; } else { echo 'style="margin-top:58px; margin-bottom:10px;"';}?>>
			<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
                <div class="entry-thumbnail">
                	<a class="productsImages" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
                    <span class="btn btn-primary btnDetails"> Details</span></a>
                </div>
            <?php endif; ?>
            <div class="productsDetails"> 
                <div class="MRP">
                <?php if ( is_single() ) : ?>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                <?php else : ?>
                        <a class="productsName" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                <?php endif; // is_single() ?>
                <div class="entry-meta">
                <?php twentythirteen_entry_meta(); ?>
                </div><!-- .entry-meta -->
                </div>
                <div class="cartDetails">
                 <span class="btn btn-primary pull-left"><?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?></span>
                       <div class="productsPrice"> <?php echo $product->get_price_html(); ?></div>  
                </div>       
            </div>
        </div>
    </header><!-- .entry-header -->
</article><!-- #post -->
					 <?php /*************************************/ ?>
			<?php $i++;
			endwhile; ?>
			<?php twentythirteen_paging_nav(); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>