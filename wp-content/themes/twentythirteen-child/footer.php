<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

<!-- Footer --> 
<!--***************** footer *************************************-->
<footer id="#section-4" class="">

<?php //echo get_permalink( wc_get_page_id( 'checkout' )); ?>
<div class="container">
    <div  class="col-sm-3">
        <h4 class="headingft">Your Account </h4>
        <?php wp_nav_menu( array( 'menu' => 'Your Account', 'theme_location' => 'secondary', 'menu_class' => 'footerMenu', 'menu_id' => 'your_account' ) ); ?>
    </div>
    <div  class="col-sm-3">
        <h4 class="headingft">About US </h4>
        <?php wp_nav_menu( array( 'menu' => 'About-Us', 'theme_location' => 'secondary', 'menu_class' => 'footerMenu', 'menu_id' => 'about_us' ) ); ?>
    </div>
    <div  class="col-sm-3">
        <h4 class="headingft">Customer Care </h4>
        <?php wp_nav_menu( array( 'menu' => 'customer_care', 'theme_location' => 'secondary', 'menu_class' => 'footerMenu', 'menu_id' => 'customer_care' ) ); ?>
    </div>
    <div  class="col-sm-3">
        <h4 class="headingft">Stay  Connected </h4>
        <?php echo do_shortcode('[cn-social-icon]'); ?>
        <?php dynamic_sidebar('Footer contact info'); ?>
    </div> 
</div>
<div class="copyright"> <div class="container">
    <div class="col-sm-4"> KeylessOption  </div> 
    <div class="col-sm-7 text-right"> 
        <?php wp_nav_menu( array( 'menu' => 'Footer Menu', 'theme_location' => 'secondary', 'menu_class' => 'footerSubMenu', 'menu_id' => 'footer-menu' ) ); ?>
    </div>  
</div></div>
</footer>
 <div id="loader" style="display:none;">
  <div class="sk-cube-grid">
      <div class="sk-cube sk-cube1"></div>
      <div class="sk-cube sk-cube2"></div>
      <div class="sk-cube sk-cube3"></div>
      <div class="sk-cube sk-cube4"></div>
      <div class="sk-cube sk-cube5"></div>
      <div class="sk-cube sk-cube6"></div>
      <div class="sk-cube sk-cube7"></div>
      <div class="sk-cube sk-cube8"></div>
      <div class="sk-cube sk-cube9"></div>
    </div>
 </div>
<!-- /.container --> 
<div class="modal fade lookVin" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Search by VIN</h4>
      </div>
      <div class="modal-body">
   <div class="carousel-captionVinNumbar">   <form  action="<?php echo home_url(); ?>/vin/" method="post" id="vinForm" class="vinForm">
                <div class="col-sm-9">
                    <input type="text"  placeholder="Enter your VIN" name="vin" id="vin" class="vin" required>
                </div>
                <div class="col-sm-3">
                    <input type="submit" name="goVin" value="Search" id="goVin" class="goModel">
                </div>
          </form><div class="vinError text-center" style="display:none;">Enter 17 characters VIN number</div> </div>
      </div>
    </div>
  </div>
</div>
<?php
if(isset($_POST['update_cart']))
{
	$link_checkout=get_page_link( get_page_by_title( "checkout" )->ID);
	header("location:".$link_checkout);
}	
	
?>
<!-- jQuery --> 
 <script src="<?php echo get_stylesheet_directory_uri();  ?>/js/jquery.js"></script>  

<!-- Bootstrap Core JavaScript --> 
<!-- <script src="<?php echo get_stylesheet_directory_uri();  ?>/js/bootstrap.min.js"></script>-->
 <script src="<?php echo get_stylesheet_directory_uri();  ?>/js/jquery.fittext.js"></script> 

<script src="<?php echo get_stylesheet_directory_uri();  ?>/js/creative.js"></script>

<!-- Script to Activate the Carousel --> 
<script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    });
	
	 $(document).ready(function() 
	 {
      	$('#rootwizard').bootstrapWizard({'tabClass': 'nav nav-tabs'});
    });
</script>

<script src="<?php echo get_stylesheet_directory_uri();  ?>/js/freelancer.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <?php wp_footer(); ?>
</body>
</html>