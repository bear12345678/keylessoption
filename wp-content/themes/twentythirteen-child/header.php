<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
    <!-- Bootstrap Core CSS -->
   <link href="<?php echo get_stylesheet_directory_uri();  ?>/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- C5+ustom CSS -->
    <link href="<?php echo get_stylesheet_directory_uri();  ?>/style.css" rel="stylesheet">
    
    <!-- Custom Fonts -->
    <link href="<?php echo get_stylesheet_directory_uri();  ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,100,700,500,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/rupyainr/1.0.0/rupyaINR.min.css?5f3697">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();  ?>/css/bootstrap.vertical-tabs.css">
<meta name="google-site-verification" content="sGdzvmgQmdGC57Hl_wcrYRU4COaYoRMmrJUhLv7Tnr0" />
	<?php wp_head(); ?>
        <script type="text/javascript">
		jQuery(document).ready(function()
		{
			/**************Code to toggle Filter form***************/
			 $('#filter_vehicle_form').hide(); //Initially form wil be hidden.
			 $('#toggle_filter').click(function() 
			 {
				$('#filter_vehicle_form').toggle();
			 });


			/**************Code for makes in dropdown***************/
			jQuery(".mega-dropdown a").addClass("dropdown-toggle");
			jQuery(".mega-dropdown a").attr("data-toggle", "dropdown");
			jQuery.ajax({
								type:'POST',
								data:'action=getModelForMenu',
								url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',		
								success:function(result){ 
									jQuery("li.mega-dropdown").append(result);
								}
							 });
			/******************************************/
			var make = jQuery("#make").val();
			if(make == '')
			{
				jQuery("#year").attr('disabled','disabled');
				jQuery("#model").attr('disabled','disabled');
			}
			jQuery("#make").change(function(){
				var makeval = jQuery("#make option:selected").val();
				if(makeval != '')
				{
					jQuery("#model").attr('disabled',false);
					var UrlToPass= "action=getModel&make="+makeval;
					jQuery("#loader").show();
					jQuery("body").css("overflow","hidden");
					jQuery.ajax({
								type:'POST',
								data:UrlToPass,
								url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',		
								success:function(result){ 
									jQuery("#model").html(result);
									jQuery("#loader").hide();
									jQuery("body").css("overflow","visible");
								}
							 });
				}
				else
				{
					jQuery("#model").attr('disabled','disabled');
				}
			});
			jQuery("#model").change(function(){
				var makeval = jQuery("#make option:selected").val();
				var modelval = jQuery("#model option:selected").val();
				if(modelval != '')
				{
					jQuery("#year").attr('disabled',false);
					var UrlToPass="action=getYear&yearMake="+makeval+"&yearModel="+modelval;
					jQuery("#loader").show();
					jQuery("body").css("overflow","hidden");
					jQuery.ajax({
								type:'POST',
								data:UrlToPass,
								url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',		
								success:function(result){ 
									jQuery("#year").html(result);
									jQuery("#loader").hide();
									jQuery("body").css("overflow","visible");
								}
							 });
				}
				else
				{
					jQuery("#year").attr('disabled','disabled');
				}
			});
			jQuery("#year").change(function(){
				var make = jQuery("#make option:selected").text();
				var year = jQuery("#year option:selected").text();
				var model = jQuery("#model option:selected").text();
				var makeval = jQuery("#make option:selected").val();
				var yearval = jQuery("#year option:selected").val();
				var modelval = jQuery("#model option:selected").val();
				if(make != '' && year != '' && model != '')
				{
					var UrlToPass="action=selectProduct&productMake="+make+"&productYear="+year+"&productModel="+model;
					jQuery("#loader").show();
					jQuery("body").css("overflow","hidden");
					jQuery.ajax({
						type:'POST',
						data:UrlToPass,
						url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',
						success:function(result){
							window.location = "filter-result?search="+result+"&selectedMake="+makeval+"&selectedCarYear="+yearval+"&selectedModel="+modelval;
							}
						});
				}
				});
			jQuery("#goModel").click(function(){
				var make = jQuery("#make option:selected").text();
				var year = jQuery("#year option:selected").text();
				var model = jQuery("#model option:selected").text();
				var makeval = jQuery("#make option:selected").val();
				var yearval = jQuery("#year option:selected").val();
				var modelval = jQuery("#model option:selected").val();
				if(make != '' && year != '' && model != '')
				{
					var UrlToPass="action=selectProduct&productMake="+make+"&productYear="+year+"&productModel="+model;
					jQuery("#loader").show();
					jQuery("body").css("overflow","hidden");
					jQuery.ajax({
						type:'POST',
						data:UrlToPass,
						url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',
						success:function(result){
							window.location = "filter-result?search="+result+"&selectedMake="+makeval+"&selectedCarYear="+yearval+"&selectedModel="+modelval;
							}
						});
				}
				});
		});
jQuery(document).on('submit','form#vinForm',function(){  
	var vin = jQuery(".vin").val();
	if(vin.length < 17 || vin.length > 17)
	{
		jQuery(".vinError").show();
		jQuery(".vinError").fadeOut(5000);
		return false;
	}
	jQuery(".shopVehicle").click(function(){
		alert("Hello");
		});
});
function getValue(a)
{
	jQuery.ajax({
			type:'POST',
			data:'action=getDatabyMakesMenu&makeMenu='+a,
			url:'<?php echo home_url(); ?>/wp-content/themes/twentythirteen-child/ajax.php',
			success:function(result)
			{
				window.location = "filter-result?search="+result;
			}
		});
}
	</script>
</head>

<body id="page-top" class="index">

<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="topHeader">  <div class="container"> <div class="row"> <div class="col-sm-7 col_lk ">
<?php dynamic_sidebar('Contact info'); ?>
</div> <div class="col-sm-5">
<ul class="adminManu pull-right">
<li><a href="#" data-toggle="modal" data-target="#myModal">Search by Vin</a></li>
<li><a href="<?php if ( is_user_logged_in() ){ echo home_url()."/my-account/customer-logout/"; } else { echo home_url()."/my-account/"; }?>">
<?php if ( is_user_logged_in() ){ echo "Logout"; } else { echo "Login"; }?></a></li>
<?php if ( !is_user_logged_in() ) { ?>
<li class="register"><a href="<?php echo wp_registration_url(); ?>">Register</a></li>
<?php } ?>
<?php
global $woocommerce;
// get cart quantity
$qty = $woocommerce->cart->get_cart_contents_count();
// get cart total
$total = $woocommerce->cart->get_cart_total();
// get cart url
$cart_url = $woocommerce->cart->get_checkout_url()
?>
<li class="cart"><a href="<?php echo $cart_url; ?>" class="<?php if($qty > 0) echo 'cartFill'; ?>">Cart <i class="cartbag"><?php echo $qty; ?></i> </a> </li>
</ul>
</div> </div> </div> </div>

 
<div class="headermenu">
<div class="container"> 
<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-menu"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
<?php lm_display_logo(); ?>
<form method="get" id="searchform" class="searchForm" action="<?php esc_url( home_url( '/' ) )?>" role="search">
			<input type="search" class="form-control" name="s" value="<?php esc_attr( get_search_query() ) ?>" id="s" placeholder="Search..">
			<input type="submit" class="searchButton"  id="searchsubmit">
			</form>
</div>
<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu text-center collapse navbar-right', 'menu_id' => 'primary-menu' ) ); 
//get_search_form();
?>
<!-- /.navbar-collapse --> 
</div>
</div>
<!-- /.container --> 
<section id="selectVehicle">
    <div class="container">
        <div class="row">
             <div class="selectVehicle">
                	<div class="select_text">SELECT YOUR VEHICLE
						<h5>to view all compatible parts</h5>
					</div>
					<span id="toggle_filter" class="fa fa-bars"></span>
                </div>
				
				<form id="filter_vehicle_form" action="#" method="post">
             	
                <?php if(!isset($_REQUEST['selectedMake'])) {?>
                <div class="col-md-4">
                <div class=" appearance">
                <?php 
				$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/makes?state=new&fmt=json&api_key=c8ektqg3jrxzyd73duwm74ne&state=new&view=full');
				$arraynew = json_decode($myobj);
				$num = count($arraynew->makes);/***It counts array elements for loop***/  ?>
                    <select id="make" class="make">
                        <option value="">--Select Make--</option>
                        <?php for($i = 0; $i < $num; $i++)  { ?>
                            <option value="<?php echo $arraynew->makes[$i]->niceName; ?>"><?php echo trim($arraynew->makes[$i]->name); ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                <div class=" appearance">
                    <select id="model" class="model">
                        <option value="">--Select Model--</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                <div class=" appearance">
                    <select id="year" class="year">
                        <option value="">--Select Year--</option>
                    </select>
                    </div>
                </div>
                <?php }
				else
				{ ?>
                <div class="col-md-4">
                <div class=" appearance">
                <?php 
				$myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/makes?state=new&fmt=json&api_key=c8ektqg3jrxzyd73duwm74ne&state=new&view=full');
				$arraynew = json_decode($myobj);
				$num = count($arraynew->makes);/***It counts array elements for loop***/  ?>
                    <select id="make" class="make">
                        <option value="">--Select Make--</option>
                        <?php for($i = 0; $i < $num; $i++)  { ?>
                            <option value="<?php echo $arraynew->makes[$i]->niceName; ?>" <?php if($_REQUEST['selectedMake'] == trim($arraynew->makes[$i]->niceName)){ echo "selected"; }?> ><?php echo trim($arraynew->makes[$i]->name); ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                <div class=" appearance">
					<?php $myobj= file_get_contents('https://api.edmunds.com/api/vehicle/v2/'.$_REQUEST['selectedMake'].'/models?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
                    $arraynew = json_decode($myobj);
                    $num = count($arraynew->models);/***It counts array elements for loop***/ 
                    ?>
                        <select id="model" class="model">
                            <option value="">--Select Model--</option>
                            <?php for($i = 0; $i < $num; $i++)  { ?>
                            <option value="<?php echo $arraynew->models[$i]->niceName; ?>" <?php if($_REQUEST['selectedModel'] == trim($arraynew->models[$i]->niceName)){ echo "selected"; }?>><?php echo trim($arraynew->models[$i]->name);?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                <div class=" appearance">
					<?php $myobj = file_get_contents('http://api.edmunds.com/api/vehicle/v2/'.$_REQUEST['selectedMake'].'/'.$_REQUEST['selectedModel'].'/years?fmt=json&api_key=pzuapzj3seygzqg6p6t6exrs');
                    $arraynew = json_decode($myobj);
                    $num = count($arraynew->years);/***It counts array elements for loop***/ 
						for($i = 0; $i < $num; $i++)  { 
							$yearArr[] = $arraynew->years[$i]->year;/*******Code to get year*******/ 
						} ?>
                <select id="year" class="year">
                    <option value="">--Select Year--</option>
                    <?php foreach($yearArr as $index => $year)  { ?>
                    <option value="<?php echo $year;?>"  <?php if($_REQUEST['selectedCarYear'] == $year){ echo "selected"; }?>><?php echo trim($year);?></option>
                    <?php } ?>
                </select>
                    </div>
                </div> 
				<?php }?>
                <div class="goButton">
                	<input type="button" class="goModel" id="goModel" value="GO" />
                 </div>
             </form>
        </div>
    </div>
</section>
</nav>
<?php if(is_home()) {?>
 <header id="myCarousel" class="carousel slide"> 
    <div class="homeSlider">
	    <?php echo do_shortcode('[metaslider id=217]');?>
    </div>
</header>
<?php }
		?>