<?php 
class WCSD_Order
{
	public function __construct()
	{
		if(is_admin())
		{
			add_action('wp_ajax_wcds_earning_widget_get_earning_per_period', array(&$this, 'ajax_get_earning_per_period') );
			add_action('wp_ajax_wcds_geographic_widget_get_earning_per_area', array(&$this, 'ajax_get_earning_per_geograpic_area') );
		}
	}
	public function ajax_get_earning_per_geograpic_area()
	{
		$range = isset($_POST['view_type']) ? $_POST['view_type'] : 'country'; //country, state, city
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
		$max_results_num = isset($_POST['max_results_num']) ? $_POST['max_results_num'] : null;
		$results = $this->get_earnings_per_geographic_area($range, $start_date,$end_date, $max_results_num);
		
		$countries_translator =  WC()->countries;
		foreach($results as $index => $stat)
		{
			$results[$index]['total_earning'] = round($stat['total_earning'], 2);
			if($range == 'country')
			{
				$results[$index]['zone_name'] = $countries_translator->countries[ $stat['zone_name'] ];
				$results[$index]['zone_code'] =  strtolower( $stat['zone_name']);
			}
		}
		//wcds_var_dump($results);
		echo json_encode($results);
		wp_die();
	}
	public function ajax_get_earning_per_period()
	{
		$range = isset($_POST['view_type']) ? $_POST['view_type'] : 'daily';
		$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
		$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
		
		$stats = $this->get_earnings_per_period($range, $start_date,$end_date);
		$counter = 0;
		$totals = $order_num = $dates  ='';
		foreach($stats as $stat_per_date)
		{
			if($counter > 0)
			{
				$dates .=",";
				$totals .=",";
				$order_num .=",";
			}
			if($range == 'daily')
			{
				 /*setlocale(LC_TIME, 'it_IT');
				$temp_date =  DateTime::createFromFormat('j/m/Y', $stat_per_date['date']);
				$dates .= strftime("%a - %d/%m", $temp_date->getTimestamp()); */
				
				$temp_date =  DateTime::createFromFormat('j/m/Y', $stat_per_date['date']);
				$dates .= $temp_date->format('D - d/m');
			}
			else
				$dates .= $stat_per_date['date']; //date($date_format ,strtotime($order_date))
			$totals .= round($stat_per_date['order_total'], 2);
			$order_num .= $stat_per_date['order_num'];
			$counter++;
		}
		echo json_encode(array('dates'=>$dates, 'totals'=>$totals, 'order_num' => $order_num));
		wp_die();
	}
	public function get_earnings_per_period($range_type = 'daily', $start_date = null, $end_date = null)
	{
		global $wpdb;
		
		$group_by_string = "";
		$select_date_string = "";
		
		switch($range_type)
		{
			case 'yearly':$group_by_string = "YEAR(orders.post_date)"; 
						   $select_date_string = "YEAR(orders.post_date)";
						   break;
			case 'monthly': $group_by_string = "YEAR(orders.post_date), MONTH(orders.post_date)";   //YEAR(record_date), MONTH(record_date)
							 $select_date_string = "concat_ws('/', MONTH(orders.post_date), YEAR(orders.post_date))";
							break;
			case 'daily' :  $group_by_string = "MONTH(orders.post_date), DAY(orders.post_date)"; 
						    $select_date_string = "concat_ws('/', DAY(orders.post_date), MONTH(orders.post_date), YEAR(orders.post_date))";
							break;
		}
		if((!isset($start_date) || $start_date == "") && (!isset($end_date) || $end_date == "")) { $start_date = date('Y-m-01'); $end_date = date('Y-m-t'); } 
		
		$query_addons = $this->get_orders_query_conditions_to_exclude_bad_orders();
		
		$wpdb->query('SET SQL_BIG_SELECTS=1');
		$query = "SELECT SUM(order_total.meta_value) AS order_total, {$select_date_string} AS date, COUNT(orders.id) AS order_num
				  FROM {$wpdb->posts} AS orders
				  INNER JOIN {$wpdb->postmeta} AS order_total ON order_total.post_id = orders.ID {$query_addons['join']}
				  WHERE orders.post_type = 'shop_order' 
				  AND order_total.meta_key = '_order_total' 
				  AND orders.post_date >= '{$start_date} 00:00' 
				  AND orders.post_date <= '{$end_date} 23:59'  {$query_addons['where']}
				  GROUP BY  ".$group_by_string;
			  
		return $wpdb->get_results($query, ARRAY_A);
	}
	public function get_earnings_per_geographic_area($area_type = 'country', $start_date = null, $end_date = null, $max_results_num = 10)
	{
		global $wpdb;
		
		$group_by_string = "";
		$select_zone_string = "";
		$geographic_join = "";
		$geographic_condition = "";
		
		switch($area_type)
		{
			case 'country':$group_by_string = " billing_country.meta_value "; 
						   $select_zone_string = " billing_country.meta_value ";
						   $geographic_join = " INNER JOIN {$wpdb->postmeta} AS billing_country ON billing_country.post_id = orders.ID  ";
						   $geographic_condition = " AND billing_country.meta_key = '_billing_country' ";
						   break;
			case 'state': $group_by_string = " billing_state.meta_value "; 
						  $select_zone_string = " billing_state.meta_value ";
						  $geographic_join = " INNER JOIN {$wpdb->postmeta} AS billing_state ON billing_state.post_id = orders.ID  ";
						  $geographic_condition = " AND billing_state.meta_key = '_billing_state' ";
						  break;
			case 'city': $group_by_string = " billing_city.meta_value  ";   
						 $select_zone_string = " billing_city.meta ";
						 $geographic_join = " INNER JOIN {$wpdb->postmeta} AS billing_city ON billing_city.post_id = orders.ID  ";
						 $geographic_condition = " AND billing_city.meta_key = '_billing_city' ";
					     break;
		}
		if((!isset($start_date) || $start_date == "") && (!isset($end_date) || $end_date == "")) { $start_date = date('Y-m-01'); $end_date = date('Y-m-t'); } 
		
		$query_addons = $this->get_orders_query_conditions_to_exclude_bad_orders();
		
		$wpdb->query('SET SQL_BIG_SELECTS=1');
		$query = "SELECT SUM(order_total.meta_value) AS total_earning, {$select_zone_string} as zone_name, COUNT(orders.id) AS total_purchases
				  FROM {$wpdb->posts} AS orders
				  INNER JOIN {$wpdb->postmeta} AS order_total ON order_total.post_id = orders.ID {$query_addons['join']} {$geographic_join}
				  WHERE orders.post_type = 'shop_order' {$geographic_condition}
				  AND order_total.meta_key = '_order_total' 
				  AND orders.post_date >= '{$start_date} 00:00' 
				  AND orders.post_date <= '{$end_date} 23:59'  {$query_addons['where']}
				  GROUP BY  ".$group_by_string. "  ORDER BY order_total.meta_value ASC LIMIT {$max_results_num}";
			  
		return $wpdb->get_results($query, ARRAY_A);
	}
	public function get_orders_query_conditions_to_exclude_bad_orders($join_type = 'INNER')
	{
		global $wpdb;
		$statuses = $this->get_order_statuses();
		$result = array();
		$result['join'] = "";
		$result['where'] = "";
		$result['version'] = $statuses['version'];
		if($statuses['version'] > 2.1)
		{
			$result['statuses'] = $statuses['statuses'] = array_diff($statuses['statuses'], array('wc-cancelled', 'wc-refunded', 'wc-failed'));
			$result['where'] = " AND orders.post_status IN ('".implode( "','",$statuses['statuses'])."') ";
		}
		else 
		{
			$result['statuses'] = $statuses['statuses'] = array_diff($statuses['statuses'], array('cancelled', 'refunded', 'failed'));
			$result['join'] = " {$join_type} JOIN {$wpdb->term_relationships} AS rel ON orders.ID=rel.object_id
							  {$join_type} JOIN {$wpdb->term_taxonomy} AS tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
							  {$join_type} JOIN {$wpdb->terms} AS term ON term.term_id = tax.term_id ";
			$result['where'] .= " AND orders.post_status   = 'publish'
								 AND tax.taxonomy        = 'shop_order_status' 
								 AND term.slug           IN ( '" .implode( "','",$statuses['statuses']). "' )";
		}
		
		return $result;
	}
	public function get_order_statuses()
	{
		
		$result = array();
		$result['statuses'] = array();
		if(function_exists( 'wc_get_order_statuses' ))
		{
			
			$result['version'] = 2.2;
			//[slug] => name
			$temp  = wc_get_order_statuses();
			foreach($temp as $slug => $title)
					array_push($result['statuses'], $slug);
		}
		else
		{
			$args = array(
				'hide_empty'   => false, 
				'fields'            => 'id=>slug', 
			);
			$result['version'] = 2.1;
			
			$temp = get_terms('shop_order_status', $args);
			foreach($temp as $id => $slug)
					array_push($result['statuses'], $slug);
		}
		return $result;
	}
}
?>