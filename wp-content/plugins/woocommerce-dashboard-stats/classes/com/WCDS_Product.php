<?php 
class WCDS_Product
{
	public function __construct()
	{
		if(is_admin())
		{
			add_action('wp_ajax_wcds_products_widget_get_products_per_period', array(&$this, 'ajax_get_products_per_period') );
		}
	}
	public function ajax_get_products_per_period()
	{
		$product_num = isset($_POST['product_num']) ? $_POST['product_num'] : 10;
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
		
		$results = [];
		$stats = $this->get_products_per_period(100 /* $product_num */, $start_date, $end_date);
		//wcds_var_dump($stats);
		
		/*Format:
		array(4) {
		  [0]=>
		  array(4) {
			["total_earning"]=>
			string(1) "4"
			["total_purchases"]=>
			string(1) "4"
			["prod_id"]=>
			string(2) "12"
			["prod_variation_id"]=>
			string(1) "0"
		  }
		  */
		$counter = 0;
		$wpml_helper = new WCDS_Wpml();
		foreach($stats as $prod_id => $product)
		{
			//WPML: Merge product stats by id
			$stats[$prod_id]['total_earning'] = round($product['total_earning'], 2);
			$stats[$prod_id]['permalink'] = get_permalink( $prod_id );
			
			if($wpml_helper->wpml_is_active())
			{
				$original_id = $wpml_helper->get_original_id($prod_id);
				$product_temp = new WC_Product($original_id);
				$stats[$prod_id]['prod_title'] = $product_temp->get_title( ) ;
				$stats[$prod_id]['permalink'] = get_permalink( $original_id );
				
				//wcds_var_dump($prod_id." -> ".$original_id);
				if(!isset($results[$original_id]))
				{
					//wcds_var_dump("new");
					$results[$original_id] = $stats[$prod_id];
				}
				else
				{
					//wcds_var_dump("update");
					$results[$original_id]["total_earning"] += $product["total_purchases"];
					$results[$original_id]["total_earning"] += $product["total_earning"];
					$results[$original_id]["total_earning"] = round($results[$original_id]['total_earning'], 2);
				}
			}
			else
				$results[$prod_id] = $stats[$prod_id];
			
			if(++$counter == $product_num )
				break;
		} 
		
		usort($results, function($a, $b) {
				return $b['total_earning'] - $a['total_earning'];
			});
		
		echo json_encode($results);
		wp_die();
	}
	public function get_products_per_period($product_num = 10, $start_date = null, $end_date = null)
	{
		global $wpdb, $wcds_order_model;
		$ordered_result = [];
		if((!isset($start_date) || $start_date == "") && (!isset($end_date) || $end_date == "")) { $start_date = date('Y-m-01'); $end_date = date('Y-m-t'); } 
		
		$query_addons = $wcds_order_model->get_orders_query_conditions_to_exclude_bad_orders();
		
		$wpdb->query('SET SQL_BIG_SELECTS=1');
		$query = "SELECT SUM(product_total.meta_value) AS total_earning, product.post_title AS prod_title, SUM(product_quantity.meta_value) AS total_purchases, product_id.meta_value AS prod_id ".//, product_variation.meta_value AS prod_variation_id
				  "FROM {$wpdb->posts} AS orders
				  INNER JOIN {$wpdb->postmeta} AS order_total ON order_total.post_id = orders.ID				
				  INNER JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON order_items.order_id = orders.ID
				  INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS product_id ON product_id.order_item_id = order_items.order_item_id ".
				  //INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS product_variation ON product_variation.order_item_id = order_items.order_item_id
				  "INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS product_quantity ON product_quantity.order_item_id = order_items.order_item_id
				  INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS product_total ON product_total.order_item_id = order_items.order_item_id
				  INNER JOIN {$wpdb->posts} AS product ON product.ID = product_id.meta_value {$query_addons['join']}
				  WHERE orders.post_type = 'shop_order' 
				  AND order_total.meta_key = '_order_total' 
				  AND product_id.meta_key = '_product_id' ".
				  //AND product_variation.meta_key = '_variation_id' 
				  "AND product_quantity.meta_key = '_qty' 
				  AND product_total.meta_key = '_line_total' 
				  AND orders.post_date >= '{$start_date} 00:00' 
				  AND orders.post_date <= '{$end_date} 23:59'  {$query_addons['where']}
				  GROUP BY product_id.meta_value ORDER BY SUM(product_total.meta_value) DESC LIMIT ".$product_num;
		
		$result = $wpdb->get_results($query, ARRAY_A);
		$result = isset($result) && !empty($result) ? $result : array();
		
		foreach($result as $product) 
		{
			$ordered_result[$product['prod_id']] = $product;
		}
		//wcds_var_dump($ordered_result);
		return $ordered_result;
	}
	
}
?>