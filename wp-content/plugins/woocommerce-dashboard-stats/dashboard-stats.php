<?php 
/*
Plugin Name: WooCommerce Dashboard Widgets Stats
Description: Dashboard widgets thats help the shop admin to keep an eye on shop stats.
Author: Lagudi Domenico
Version: 1.4
*/

//define('WCDS_PLUGIN_URL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
define('WCDS_PLUGIN_URL', rtrim(plugin_dir_url(__FILE__), "/") ) ;
define('WCDS_PLUGIN_ABS_PATH', dirname( __FILE__ ) );

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
	load_plugin_textdomain('woocommerce-dashboard-stats', false, basename( dirname( __FILE__ ) ) . '/languages' );
	
	if(!class_exists('WCDS_Html'))
		require_once('classes/com/WCDS_Html.php');
	
	if(!class_exists('WCDS_Wpml'))
		require_once('classes/com/WCDS_Wpml.php');
	
	if(!class_exists('WCDS_Customer'))
		require_once('classes/com/WCDS_Customer.php');
	$wcds_customer_model = new WCDS_Customer();
	
	if(!class_exists('WCDS_Order'))
		require_once('classes/com/WCDS_Order.php');
	$wcds_order_model = new WCSD_Order();
	
	if(!class_exists('WCDS_Product'))
		require_once('classes/com/WCDS_Product.php');
	$wcds_product_model = new WCDS_Product();
	
	if(!class_exists('WCDS_Dashboard'))
		require_once('classes/admin/WCDS_Dashboard.php');
	$wcps_dashboard_widgets = new WCDS_Dashboard();
	
	//add_action('admin_menu', 'wcds_init_admin_panel');
	add_action('admin_init', 'wcds_register_settings');
}

function wcds_register_settings()
{
	register_setting('wcds_options_group', 'wcds_options');
}
function wcds_init_admin_panel()
{ 
	$place = wcds_get_free_menu_position(56 , .1);
	//add_menu_page( __('Dashboard', 'woocommerce-dashboard-stats'), __('Dashboard', 'woocommerce-dashboard-stats'), 'manage_woocommerce', 'wcps-dashboard-stats', 'wcds_load_bulk_editor_page', 'dashicons-tag', $place);
	//add_submenu_page('wcps-dashboard-stats',  __('Orders/Coupons finder', 'woocommerce-dashboard-stats'), __('Orders finder', 'woocommerce-dashboard-stats'), 'manage_woocommerce', 'woocommerce-dashboard-stats-orders-finder', 'wcds_load_orders_finder_page');
}
function wcds_load_orders_finder_page()
{
	/* if(!class_exists('wcds_Finder'))
		require_once('classes/admin/wcds_Finder.php');
	$orders_finder = new wcds_Finder();
	$orders_finder->render_page(); */
}
function wcds_get_free_menu_position($start, $increment = 0.3)
{
	foreach ($GLOBALS['menu'] as $key => $menu) {
		$menus_positions[] = $key;
	}

	if (!in_array($start, $menus_positions)) return $start;

	/* the position is already reserved find the closet one */
	while (in_array($start, $menus_positions)) {
		$start += $increment;
	}
	return $start;
}
function wcds_var_dump($var)
{
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}
?>