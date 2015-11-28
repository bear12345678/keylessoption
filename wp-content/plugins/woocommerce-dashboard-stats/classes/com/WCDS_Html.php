<?php 
class WCDS_Html
{
	public function __construct()
	{
		 
	}
	private function common_css_and_js()
	{
		wp_enqueue_style('datepicker-classic', WCDS_PLUGIN_URL.'/css/datepicker/classic.css');   
		wp_enqueue_style('datepicker-date-classic', WCDS_PLUGIN_URL.'/css/datepicker/classic.date.css');   
		wp_enqueue_style('datepicker-time-classic', WCDS_PLUGIN_URL.'/css/datepicker/classic.time.css');   
		wp_enqueue_style('wcds-widget-general', WCDS_PLUGIN_URL.'/css/admin-widget-general.css');
		
		wp_enqueue_script('wcds-ui-chart', WCDS_PLUGIN_URL.'/js/Chart.min.js', array( 'jquery' ));
		wp_enqueue_script('wcds-ui-chart-stackedbar', WCDS_PLUGIN_URL.'/js/Chart.StackedBar.js', array( 'jquery' ));
		wp_enqueue_script('wcds-ui-picker', WCDS_PLUGIN_URL.'/js/picker.js', array( 'jquery' ));
		wp_enqueue_script('wcds-ui-timepicker', WCDS_PLUGIN_URL.'/js/picker.date.js', array( 'jquery' ));
	}
	public function render_geographic_widget()
	{
		global $wcds_order_model;
		$wcds_geographic_view_type = 'country';
		
		$this->common_css_and_js();
		//wp_enqueue_style('wcds-widget-geographic', WCDS_PLUGIN_URL.'/css/admin-widget-geographic.css');  
		wp_enqueue_script('wcds-geographic-widget', WCDS_PLUGIN_URL.'/js/admin-geographic-widget.js', array( 'jquery' ));
		?>
		<script>
		var wcds_flags_path = "<?php echo WCDS_PLUGIN_URL.'/img/flags/'; ?>";
		var wcds_geographic_currency = "<?php echo get_woocommerce_currency_symbol(); ?>";
		var wcds_geographic_widget_date_error = "<?php _e('Start date cannot be greater than End date.', 'woocommerce-dashboard-stats'); ?>";
		</script>
		<p>
		<?php _e('If a data range is not selected, the displayed stats are relative to the current month: ', 'woocommerce-dashboard-stats'); echo '<strong>'.date('F').'</strong>'; ?>
		</p>
		<!-- conf -->
		
		<select id="wcds_max_results_num">
			<option value="10"><?php _e('Max results', 'woocommerce-dashboard-stats' ); ?></value>
			<option value="10">10</value>
			<option value="20">20</value>
			<option value="40">40</value>
			<option value="50">50</value>
		</select>
		
		<select id="wcds_geographic_view_type" name='wcds_geographic_view_type'>
		  <option value="country" <?php if($wcds_geographic_view_type === 'country') echo 'selected="selected"' ?>><?php _e('Country', 'woocommerce-dashboard-stats' ); ?></option>
		  <option value="state" <?php if($wcds_geographic_view_type === 'state') echo 'selected="selected"' ?>><?php _e('State/Province', 'woocommerce-dashboard-stats' ); ?></option>
		</select>
		
		
		<!-- range data selection (changes according to earing_period_range type) -->
		<input class="wcds_range_datepicker" type="text" id="wcds_geographic_picker_start_date" name="wcds_start_date" value="" placeholder="<?php _e('Start date', 'woocommerce-dashboard-stats' ); ?>" />
		<input class="wcds_range_datepicker" type="text" id="wcds_geographic_picker_end_date" name="wcds_end_date" value="" placeholder="<?php _e('End date', 'woocommerce-dashboard-stats' ); ?>" />
		<div class="wcds_spacer"></div>
		<input class="button-primary wcds_filter_button" id="wcds_geographic_chart_filter_button" type="submit" value="<?php _e('Filter', 'woocommerce-dashboard-stats' ); ?>" >  </input>
	
		
		<div class="chart">
			<h2 class="stat-title"><?php _e('Earnings per area', 'woocommerce-dashboard-stats' ); ?></h2>
			<div id="wcds_geographic_wait_box" class="wcds_wait_box">
					<?php _e('Computing data, please wait...', 'woocommerce-dashboard-stats' ); ?>
					<img class="wcds_preloader_image" src="<?php echo WCDS_PLUGIN_URL.'/img/preloader.gif' ?>" ></img>
			</div>
			<div id="wcds_geographic_stats_canvas_box">
				<canvas id="wcds_geographic_stats" ></canvas>
			</div>			
		</div>
		<div class="wcds_spacer2"></div>
		<div id="wcds_geographic_stats_table" class="wcds_table">
				<table class="wp-list-table widefat striped">
					<thead>
						<tr>
							<th style="" class="manage-column column-date" scope="col"><?php _e('Date', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-count" scope="col"><?php _e('Item Sales Count', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-earnings num" scope="col"><?php _e('Earnings', 'woocommerce-dashboard-stats' ); ?></th>
						</tr>
					</thead>
					 
						<tbody id="wcds_geographic_table_body">
							
						</tbody>
					<tfoot>
						<tr>
							<th style="" class="manage-column column-date" id="wcds_geographic_foot_total" scope="col"><?php _e('Total', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-count" id="wcds_geographic_foot_total_count" scope="col"></th>
							<th style="" class="manage-column column-earnings num" id="wcds_geographic_foot_total_earnings" scope="col"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		<?php 
	}
	public function render_customers_widget()
	{
		$this->common_css_and_js();
		wp_enqueue_script('wcds-customers-widget', WCDS_PLUGIN_URL.'/js/admin-customers-widget.js', array( 'jquery' ));
		?>
		<script>
		var wcds_customers_widget_date_error = "<?php _e('Start date cannot be greater than End date.', 'woocommerce-dashboard-stats'); ?>";
		var wcds_customers_currency = "<?php echo get_woocommerce_currency_symbol(); ?>"; 
		</script>
		<!-- range data selection (changes according to earing_period_range type) -->
		<p>
		<?php _e('If a data range is not selected, the displayed stats are relative to the current month: ', 'woocommerce-dashboard-stats'); echo '<strong>'.date('F').'</strong>'; ?>
		</p>
		<select id="wcds_customers_num">
			<option value="10"><?php _e('Max customers', 'woocommerce-dashboard-stats' ); ?></value>
			<option value="10">10</value>
			<option value="20">20</value>
			<option value="40">40</value>
			<option value="50">50</value>
		</select>
		<input class="wcds_range_datepicker" type="text" id="wcds_customers_picker_start_date" value="" placeholder="<?php _e('Start date', 'woocommerce-dashboard-stats' ); ?>" />
		<input class="wcds_range_datepicker" type="text" id="wcds_customers_picker_end_date"  value="" placeholder="<?php _e('End date', 'woocommerce-dashboard-stats' ); ?>" />
		<div class="wcds_spacer"></div>
		<input class="button-primary wcds_filter_button" id="wcds_customers_chart_filter_button" type="submit" value="<?php _e('Filter', 'woocommerce-dashboard-stats' ); ?>" >  </input>
		
		<div class="chart">
			<h2 class="stat-title"><?php _e('Customers', 'woocommerce-dashboard-stats' ); ?></h2>
			<div id="wcds_customers_wait_box" class="wcds_wait_box">
				<?php _e('Computing data, please wait...', 'woocommerce-dashboard-stats' ); ?>
				<img class="wcds_preloader_image" src="<?php echo WCDS_PLUGIN_URL.'/img/preloader.gif' ?>" ></img>
			</div>
			<div id="wcds_customers_stats_canvas_box">
				<canvas id="wcds_customers_stats" ></canvas>
			</div>			
		</div>
		<div class="wcds_spacer2"></div>
		<div id="wcds_customers_stats_table" class="wcds_table">
				<table class="wp-list-table widefat striped">
					<thead>
						<tr>
							<th style="" class="manage-column column-namr" scope="col"><?php _e('Name', 'woocommerce-dashboard-stats' ); ?></th>							
							<th style="" class="manage-column column-guest" scope="col"><?php _e('Guest', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-count" scope="col"><?php _e('Orders Count', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-spent num" scope="col"><?php _e('Spent', 'woocommerce-dashboard-stats' ); ?></th>
						</tr>
					</thead>
					 
						<tbody id="wcds_customers_table_body">
							
						</tbody>
					<tfoot>
						<tr>
							<th style="" class="manage-column column-name" id="wcds_customers_foot_total" scope="col"><?php _e('Total', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column scope="col"></th>
							<th style="" class="manage-column column-count" id="wcds_customers_foot_total_count" scope="col"></th>
							<th style="" class="manage-column column-spent num" id="wcds_customers_foot_total_spent" scope="col"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		<?php 
	}
	public function render_products_widget()
	{
		$this->common_css_and_js();
		wp_enqueue_script('wcds-products-widget', WCDS_PLUGIN_URL.'/js/admin-products-widget.js', array( 'jquery' ));
		?>
		<script>
		var wcds_products_widget_date_error = "<?php _e('Start date cannot be greater than End date.', 'woocommerce-dashboard-stats'); ?>";
		var wcds_products_currency = "<?php echo get_woocommerce_currency_symbol(); ?>"; 
		var wcds_yes = "<?php _e('Yes', 'woocommerce-dashboard-stats'); ?>"; 
		var wcds_no = "<?php _e('No', 'woocommerce-dashboard-stats'); ?>"; 
		</script>
		<!-- range data selection (changes according to earing_period_range type) -->
		<p>
		<?php _e('If a data range is not selected, the displayed stats are relative to the current month: ', 'woocommerce-dashboard-stats'); echo '<strong>'.date('F').'</strong>'; ?>
		</p>
		<select id="wcds_products_num">
			<option value="10"><?php _e('Max products', 'woocommerce-dashboard-stats' ); ?></value>
			<option value="10">10</value>
			<option value="20">20</value>
			<option value="40">40</value>
			<option value="50">50</value>
		</select>
		<input class="wcds_range_datepicker" type="text" id="wcds_products_picker_start_date" value="" placeholder="<?php _e('Start date', 'woocommerce-dashboard-stats' ); ?>" />
		<input class="wcds_range_datepicker" type="text" id="wcds_products_picker_end_date"  value="" placeholder="<?php _e('End date', 'woocommerce-dashboard-stats' ); ?>" />
		<div class="wcds_spacer"></div>
		<input class="button-primary wcds_filter_button" id="wcds_products_chart_filter_button" type="submit" value="<?php _e('Filter', 'woocommerce-dashboard-stats' ); ?>" >  </input>
		
		<div class="chart">
			<h2 class="stat-title"><?php _e('Products', 'woocommerce-dashboard-stats' ); ?></h2>
			<div id="wcds_products_wait_box" class="wcds_wait_box">
				<?php _e('Computing data, please wait...', 'woocommerce-dashboard-stats' ); ?>
				<img class="wcds_preloader_image" src="<?php echo WCDS_PLUGIN_URL.'/img/preloader.gif' ?>" ></img>
			</div>
			<div id="wcds_products_stats_canvas_box">
				<canvas id="wcds_products_stats" ></canvas>
			</div>			
		</div>
		<div class="wcds_spacer2"></div>
		<div id="wcds_products_stats_table" class="wcds_table">
				<table class="wp-list-table widefat striped">
					<thead>
						<tr>
							<th style="" class="manage-column column-namr" scope="col"><?php _e('Name', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-count" scope="col"><?php _e('Item Sales Count', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-earnings num" scope="col"><?php _e('Earnings', 'woocommerce-dashboard-stats' ); ?></th>
						</tr>
					</thead>
					 
						<tbody id="wcds_products_table_body">
							
						</tbody>
					<tfoot>
						<tr>
							<th style="" class="manage-column column-name" id="wcds_products_foot_total" scope="col"><?php _e('Total', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-count" id="wcds_products_foot_total_count" scope="col"></th>
							<th style="" class="manage-column column-earnings num" id="wcds_products_foot_total_earnings" scope="col"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		<?php 
	}
	public function render_earnings_widget()
	{
		global $wcds_order_model;
		$wcds_earning_period_range = 'daily';
		
		$this->common_css_and_js();
		//wp_enqueue_style('wcds-widget-earnings', WCDS_PLUGIN_URL.'/css/admin-widget-earnings.css');  
		wp_enqueue_script('wcds-earnings-widget', WCDS_PLUGIN_URL.'/js/admin-earnings-widget.js', array( 'jquery' ));
		
		//$stats = $wcds_order_model->get_earnings_per_period();
		//wcds_var_dump($stats);
		?>
		<script>
		var wcds_earning_chart_labels =[<?php 
										  $counter = 0;
										  $totals = '';
										  $count_per_date ='';
										  /* foreach($stats as $stat_per_date): 
												if($counter > 0)
												{
													echo ",";
													$totals .=",";
													$count_per_date .=",";
												}
												echo '"'.$stat_per_date['date'].'"'; //date($date_format ,strtotime($order_date))
												$totals .= round($stat_per_date['order_total'], 2);
												$count_per_date .= $stat_per_date['order_num'];
												$counter++;
										 endforeach;   */
									?>];
		var wcds_earnings_currency = "<?php echo get_woocommerce_currency_symbol(); ?>";
		var wcds_total_earnings = [<?php echo $totals; ?>];
		var wcds_count_per_date = [<?php echo $count_per_date; ?>];
		var wcds_earning_widget_date_error = "<?php _e('Start date cannot be greater than End date.', 'woocommerce-dashboard-stats'); ?>";
		</script>
		<p>
		<?php _e('If a data range is not selected, the displayed stats are relative to the current month: ', 'woocommerce-dashboard-stats'); echo '<strong>'.date('F').'</strong>'; ?>
		</p>
		<!-- conf -->
		<!--<form method="post"> -->
			<select id="wcds_earning_period_range" name='wcds_earning_period_range'>
			  <option value="daily" <?php if($wcds_earning_period_range === 'daily') echo 'selected="selected"' ?>><?php _e('Daily View', 'woocommerce-dashboard-stats' ); ?></option>
			  <option value="monthly" <?php if($wcds_earning_period_range === 'monthly') echo 'selected="selected"' ?>><?php _e('Monthly View', 'woocommerce-dashboard-stats' ); ?></option>
			  <option value="yearly" <?php if($wcds_earning_period_range === 'yearly') echo 'selected="selected"' ?>><?php _e('Yearly View', 'woocommerce-dashboard-stats' ); ?></option>
			</select>
			
			<!-- range data selection (changes according to earing_period_range type) -->
			<input class="wcds_range_datepicker" type="text" id="wcds_earning_picker_start_date" name="wcds_start_date" value="" placeholder="<?php _e('Start date', 'woocommerce-dashboard-stats' ); ?>" />
			<input class="wcds_range_datepicker" type="text" id="wcds_earning_picker_end_date" name="wcds_end_date" value="" placeholder="<?php _e('End date', 'woocommerce-dashboard-stats' ); ?>" />
			<div class="wcds_spacer"></div>
			<input class="button-primary wcds_filter_button" id="wcds_earnings_chart_filter_button" type="submit" value="<?php _e('Filter', 'woocommerce-dashboard-stats' ); ?>" >  </input>
		<!-- </form> -->
		<!-- end conf -->
		
		<div class="chart">
			<h2 class="stat-title"><?php _e('Earnings', 'woocommerce-dashboard-stats' ); ?></h2>
			<div id="wcds_earning_wait_box" class="wcds_wait_box">
					<?php _e('Computing data, please wait...', 'woocommerce-dashboard-stats' ); ?>
					<img class="wcds_preloader_image" src="<?php echo WCDS_PLUGIN_URL.'/img/preloader.gif' ?>" ></img>
			</div>
			<div id="wcds_earning_stats_canvas_box">
				<canvas id="wcds_earning_stats" ></canvas>
			</div>			
		</div>
		<div class="wcds_spacer2"></div>
		<div id="wcds_earning_stats_table" class="wcds_table">
				<table class="wp-list-table widefat striped">
					<thead>
						<tr>
							<th style="" class="manage-column column-date" scope="col"><?php _e('Date', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-count" scope="col"><?php _e('Item Sales Count', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-earnings num" scope="col"><?php _e('Earnings', 'woocommerce-dashboard-stats' ); ?></th>
						</tr>
					</thead>
					 
						<tbody id="wcds_table_body">
							
						</tbody>
					<tfoot>
						<tr>
							<th style="" class="manage-column column-date" id="wcds_foot_total" scope="col"><?php _e('Total', 'woocommerce-dashboard-stats' ); ?></th>
							<th style="" class="manage-column column-count" id="wcds_foot_total_count" scope="col"></th>
							<th style="" class="manage-column column-earnings num" id="wcds_foot_total_earnings" scope="col"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		<?php 
	}
	
}
?>