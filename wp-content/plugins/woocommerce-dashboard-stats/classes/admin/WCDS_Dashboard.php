<?php 
class WCDS_Dashboard
{
	public function __construct()
	{
		 add_action( 'wp_dashboard_setup', array( &$this, 'add_presale_metabox' ) );
		 //add_action( 'woocommerce_process_product_meta',  array( &$this, 'save_widget_data') );
	}
	public function add_presale_metabox()
	{
		wp_add_dashboard_widget( 'wcds-woocommerce-dashboard-geographic', __('Geographical stats', 'woocommerce-dashboard-stats'), array( &$this, 'render_geographic_metabox' ));
		wp_add_dashboard_widget( 'wcds-woocommerce-dashboard-customers', __('Customers stats', 'woocommerce-dashboard-stats'), array( &$this, 'render_customers_metabox' ));
		wp_add_dashboard_widget( 'wcds-woocommerce-dashboard-products', __('Products stats', 'woocommerce-dashboard-stats'), array( &$this, 'render_products_metabox' ));
		wp_add_dashboard_widget( 'wcds-woocommerce-dashboard-earnings', __('Earnings stats', 'woocommerce-dashboard-stats'), array( &$this, 'render_earnings_metabox' ));
		
	}
	public function render_geographic_metabox()
	{
		$html_helper = new WCDS_Html(); 
		$html_helper->render_geographic_widget();
	}
	public function render_earnings_metabox()
	{
		$html_helper = new WCDS_Html(); 
		$html_helper->render_earnings_widget();
	}
	public function render_products_metabox()
	{
		$html_helper = new WCDS_Html(); 
		$html_helper->render_products_widget();
	}
	public function render_customers_metabox()
	{
		$html_helper = new WCDS_Html(); 
		$html_helper->render_customers_widget();
	}
}
?>