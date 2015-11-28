<?php 
// in your Child Theme's functions.php   
// Use the after_setup_theme hook with a priority of 11 to load after the
// parent theme, which will fire on the default priority of 10
// Add Header and Extra Widget Area 
if ( ! function_exists( 'custom_sidebar' ) ) {
 
// Register Sidebar
function custom_sidebar() {
 
	$args = array(
		'id'            => 'sidebarheader',
		'name'          => __( 'Header Widget', 'twentythirteen' ),
		'description'   => __( 'Header widget area for my child theme.', 'twentythirteen' ),
		'class'         => 'sidebarheader',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
	);
	register_sidebar( $args );
 
        $args = array(
		'id'            => 'sidebarextra',
		'name'          => __( 'Extra Widget', 'twentythirteen' ),
		'description'   => __( 'Extra widget area for my child theme.', 'twentythirteen' ),
		'class'         => 'sidebarextra',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
	);
	register_sidebar( $args );
	   $args = array(
		'id'            => 'sidebarContactInfo',
		'name'          => __( 'Widget for subscribe text', 'twentythirteen' ),
		'description'   => __( 'Extra widget area for my child theme.', 'twentythirteen' ),
		'class'         => 'sidebarextra',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget'  => '</li>',
	);
	register_sidebar( $args );
 
}
 
// Hook into the 'widgets_init' action
add_action( 'widgets_init', 'custom_sidebar' );
}

/*************************************Code to add custom fields in categories******************************************************/

$link = mysql_connect('localhost', 'keyLessUser', 'Te0]%6.Qh_X0');
	mysql_select_db('db_keyLessOption', $link);
// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

function woo_add_custom_general_fields() { /*********Add all content here to display at dashboard********/

  global $woocommerce, $post;
  
  echo '<div class="options_group">';
// Custom fields will be created here...
echo "<div id='error'></div>";
// Select
woocommerce_wp_select( 
array( 
	'id'      => '_text_field1', 
	'label'   => __( 'Make', 'woocommerce' ), 
	'options' => array(
		''   => __( '--Select Make--', 'woocommerce' ),
		)
	)
);
// Select
woocommerce_wp_select( 
array( 
	'id'      => '_text_field2', 
	'label'   => __( 'Model', 'woocommerce' ), 
	'options' => array(
		''   => __( '--Select Model--', 'woocommerce' ),
		)
	)
);
// Select
woocommerce_wp_select( 
array( 
	'id'      => '_textarea3', 
	'label'   => __( 'Year', 'woocommerce' ), 
	'name' => '_textarea3[]',
	'multiple' => 'multiple',
	'options' => array(
		''   => __( '--Select Year--', 'woocommerce' ),
		)
	)
);
if(isset($_REQUEST['action']))
{
	echo "<input type='button' class='updateButton' value='Update' >"; 
}
/*******************************/ ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#_text_field2, #_textarea3").attr('disabled','disabled');
/***********Ajax call to get make**********/
	jQuery.ajax({
				type: 'POST',
				data: 'action=getMakes',
				url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/getYear.php',	
				success: function(result){
					jQuery("#_text_field1").html(result);
					}	
				});
/*************************Ajax call to get model according to make*************/
	jQuery("#_text_field1").change(function(){
			var make = jQuery("#_text_field1 option:selected").val();
			jQuery("#loaderImg").show();
			jQuery.ajax({
				type: 'POST',
				data: 'action=getModel&make='+make,
				url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/getYear.php',	
				success: function(result){
					jQuery("#loaderImg").hide();
					jQuery("#_text_field2").html(result);
					jQuery("#_text_field2").removeAttr('disabled');
					}	
				});
		});
/*******************Ajax call to get model************/
		jQuery("#_text_field2").change(function(){
			var make = jQuery("#_text_field1 option:selected").val();
			var model = jQuery("#_text_field2 option:selected").val();
			jQuery("#loaderImg").show();
			jQuery.ajax({
				type: 'POST',
				data: 'action=getYear&make='+make+'&model='+model,
				url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/getYear.php',	
				success: function(result){
					jQuery("#loaderImg").hide();
					jQuery("#_textarea3").removeAttr('disabled');
					jQuery("#_textarea3").attr({"multiple":"multiple","size":"10"});
					jQuery("#_textarea3").html(result);
					}	
				});
		});
		/*************Update  data**************/
		jQuery(".updateButton").click(function(){
				var make = jQuery("#_text_field1 option:selected").text();
				var model = jQuery("#_text_field2 option:selected").text();
				var postId = jQuery(".postId").html();
				var years = [];    
				jQuery("#_textarea3 :selected").each(function(){
				years.push(jQuery(this).val()); 
				});
				if(make == '' || model == '' || years == '')
				{
					jQuery("#message").html("Select Make, Model and Year").show();
					jQuery("#message").hide(3000);
				}
				else
				{
					jQuery.ajax({
					type: 'POST',
					data: 'action=addModels&addMake='+make+'&addYear='+years+'&addModel='+model+'&productId='+postId,
					url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',	
					success: function(result){
						jQuery("#message").html(result).show();
						jQuery("#message").hide(3000);
							jQuery("#loaderImg").show();
							jQuery.ajax({
								type: 'POST',
								data: 'action=getModelData&post='+postId,
								url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',	
								success: function(result){
									jQuery("#modelData").html(result);
									jQuery("#loaderImg").hide();
									}
								});
							}	
						});
					}
			});
	});
	/**********Delete Data**********/
	function deleteData(id)
	{
		jQuery.ajax({
				type: 'POST',
				data: 'action=deleteModels&id='+id,
				url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',	
				success: function(result){
					jQuery("#message").html(result).show();
					jQuery("#message").hide(3000);
					jQuery("#loaderImg").hide();
					var postId = jQuery(".postId").html();
					jQuery.ajax({
							type: 'POST',
							data: 'action=getModelData&post='+postId,
							url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',	
							success: function(result){
								jQuery("#modelData").html(result);
								jQuery("#loaderImg").hide();
							}
							});
					}	
				});
	}
</script>
<?php  echo "<div id='message' style='color:red;'></div>";
 /*************Code to print the meta of make model year******************/
$sql1 = mysql_query("select * from auto_automodels where product_id ='".$_REQUEST['post']."' ORDER BY make");	
echo "<div id ='modelData'>
		<table>
		<tr>
			<th>Make</th>
			<th>Model</th>
			<th>Year</th>
		</tr>";
			$pid = $_REQUEST['post'];
		echo "<div class='postId' style='display:none;'>".$pid."</div>";
while($arr = mysql_fetch_array($sql1))
{
	if(isset($_REQUEST['post'])) {
		echo "<tr>
			<td>".ucfirst($arr['make'])."</td>
			<td>".ucfirst($arr['model'])."</td>
			<td>".$arr['carYear']."</td>
			<td class='delete' id=".$arr['id']." onclick='return deleteData(".$arr['id']."); '>Delete</td>
		</tr>";
	}
}
 echo "</table></div>";
 echo '</div>'; 
 echo "<div id='loaderImg' style='display:none;'>
 <style type='text/css'>
 div#loaderImg {
  background: rgba(0, 0, 0, 0.6) none repeat scroll 0 0;
  height: 100%;
  left: 0;
  position: fixed;
  right: 0;
  top: 0;
  z-index: 9999;
}
 .sk-cube-grid {
  height:60px;
  left: 0;
  margin: -20px auto auto;
  position: fixed;
  right: 0;
  top: 50%;
  width: 60px;
}
  .sk-cube-grid .sk-cube {
    width: 33%;
    height: 33%;
    background-color: #0F75BC;
    float: left;
    -webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
            animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out; }
  .sk-cube-grid .sk-cube1 {
    -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s; }
  .sk-cube-grid .sk-cube2 {
    -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s; }
  .sk-cube-grid .sk-cube3 {
    -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s; }
  .sk-cube-grid .sk-cube4 {
    -webkit-animation-delay: 0.1s;
            animation-delay: 0.1s; }
  .sk-cube-grid .sk-cube5 {
    -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s; }
  .sk-cube-grid .sk-cube6 {
    -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s; }
  .sk-cube-grid .sk-cube7 {
    -webkit-animation-delay: 0.0s;
            animation-delay: 0.0s; }
  .sk-cube-grid .sk-cube8 {
    -webkit-animation-delay: 0.1s;
            animation-delay: 0.1s; }
  .sk-cube-grid .sk-cube9 {
    -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s; }

@-webkit-keyframes sk-cubeGridScaleDelay {
  0%, 70%, 100% {
    -webkit-transform: scale3D(1, 1, 1);
            transform: scale3D(1, 1, 1); }
  35% {
    -webkit-transform: scale3D(0, 0, 1);
            transform: scale3D(0, 0, 1); } }

@keyframes sk-cubeGridScaleDelay {
  0%, 70%, 100% {
    -webkit-transform: scale3D(1, 1, 1);
            transform: scale3D(1, 1, 1); }
  35% {
    -webkit-transform: scale3D(0, 0, 1);
            transform: scale3D(0, 0, 1); } }
.delete
{
	color: #1075BC; ]
	cursor: pointer !important;
}
 .delete:hover
 {
	 text-decoration:none;
  	color: #23527C;
 }
 
 </style>
  <div class='sk-cube-grid'>
      <div class='sk-cube sk-cube1'></div>
      <div class='sk-cube sk-cube2'></div>
      <div class='sk-cube sk-cube3'></div>
      <div class='sk-cube sk-cube4'></div>
      <div class='sk-cube sk-cube5'></div>
      <div class='sk-cube sk-cube6'></div>
      <div class='sk-cube sk-cube7'></div>
      <div class='sk-cube sk-cube8'></div>
      <div class='sk-cube sk-cube9'></div>
    </div>
 </div>";
}

function woo_add_custom_general_fields_save( $post_id ){
	 if($_POST['_text_field1'] != '')
	 {
		 	$woocommerce_text_field = $_POST['_text_field1'];
	 		$woocommerce_text_field2 = $_POST['_text_field2'];
	 		$arr = $_POST['_textarea3'];
			foreach($arr as $years)
			{
					$sql = mysql_query("insert into auto_automodels values ( '', '".$_REQUEST['post']."', '$woocommerce_text_field', '$years', '$woocommerce_text_field2')");
			}
	 }
}
/*******************************Code for custom field ends here************************************/
	register_sidebar( array(
		'name'          => __( 'Contact info', 'twentythirteen' ),
		'id'            => 'sidebar-contact',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer contact info', 'twentythirteen' ),
		'id'            => 'footer-contact',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
/******************Code to add search form in nav menus*********************/
add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );
	function your_custom_menu_item ( $items, $args ) {
	    if ($args->theme_location == 'primary') {
	        $items .= '<li><form method="get" id="searchform" class="searchForm" action="'.esc_url( home_url( '/' ) ).'" role="search">
			<input type="search" class="form-control" name="s" value="'.esc_attr( get_search_query() ).'" id="s" placeholder="Search..">
			<input type="submit" class="searchButton"  id="searchsubmit">
			</form></li>';
	    }
	    return $items;
	}
/**********************************/

add_action( 'template_redirect', 'redirect_to_specific_page' );

function redirect_to_specific_page() {

if ( is_page('order-status') && ! is_user_logged_in() ) {

wp_redirect( 'https://www.keylessoption.com/my-account/', 301 ); 
  exit;
    }
}


/****************************Add Empty cart Button on Cart Page***********************************/

if(!class_exists('WC_Empty_Cart')) 
{
	class WC_Empty_Cart 
	{
		public function __construct() 
		{

			if (get_option('display_empty_cart_button')=='before') 
			{
				add_action('woocommerce_before_cart', array($this,'pt_wc_empty_cart_button'));
			}
			else 
			{
				add_action('woocommerce_after_cart_contents', array($this,'pt_wc_empty_cart_button'));
			}

			add_action('init', array($this,'pt_wc_clear_cart_url'));

			add_filter( 'woocommerce_general_settings', array($this,'add_a_wc_setting') );	
		}

		public function pt_wc_empty_cart_button($cart) 
		{
			/* $cart = calling the cart */

			global $woocommerce;

			$cart_url = $woocommerce->cart->get_cart_url();
			$checkout_url = $woocommerce->cart->get_checkout_url();

?>		<!--	<tr>
				<td colspan="6" class="actions">
<?php 
					/*if(empty($_GET)) 
					{
?>						<a class="button emptycart" href="<?php echo $cart_url;?>?empty=empty-cart"><?php _e('Empty Cart','pt-emptycart'); ?></a>
<?php 				} */
				/*	else 
					{
?>						<a class="button emptycart" href="<?php echo $cart_url;?>&empty=empty-cart"><?php _e('Empty Cart','pt-emptycart'); ?></a>
<?php 				}*/
?>				</td>
			</tr>-->
<?php 	}

		public function pt_wc_clear_cart_url() 
		{
			global $woocommerce;

			if( isset($_REQUEST['empty']) ) 
			{
				$woocommerce->cart->empty_cart();
			}
		}

		public function add_a_wc_setting($settings) 
		{
			$settings[] = array(

							'name'		=> __( 'Empty Cart Option', 'woocommerce'),

							'desc' 		=> __( 'This controls where to display empty cart button', 'woocommerce' ),

							'id' 		=> 'display_empty_cart_button',

							'std' 		=> 'before',

							'default'	=> 'before',

							'type' 		=> 'select',

							'options'	=> array (

								'before' => __('Before Cart Table','woocommerce'),

								'after'	=> __('After Cart Table', 'woocommerce')

							)

						);

					$settings[] = array( 'type' => 'sectionend', 'id' => 'general_options');

					return $settings;
		}
	}

	$wchook = new WC_Empty_Cart();
}
/***************************************************************/
?>
