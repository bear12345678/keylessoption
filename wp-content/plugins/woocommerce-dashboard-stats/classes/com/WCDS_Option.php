<?php 
class WCDS_Option
{
	public function __construct{}
	
	 public function get_dashboard_widget_options( $widget_id='' )
    {
        //Fetch ALL dashboard widget options from the db...
        $opts = get_option( 'dashboard_widget_options' );

        //If no widget is specified, return everything
        if ( empty( $widget_id ) )
            return $opts;

        //If we request a widget and it exists, return it
        if ( isset( $opts[$widget_id] ) )
            return $opts[$widget_id];

        //Something went wrong...
        return false;
    }
	
	public function get_dashboard_widget_option( $widget_id, $option, $default=NULL ) 
	{
		$opts = $this->get_dashboard_widget_options($widget_id);

		//If widget opts dont exist, return false
		if ( ! $opts )
			return false;

		//Otherwise fetch the option or use default
		if ( isset( $opts[$option] ) && ! empty($opts[$option]) )
			return $opts[$option];
		else
			return ( isset($default) ) ? $default : false;

	}
	public function update_dashboard_widget_options( $widget_id , $args=array(), $add_only=false )
	{
		//Fetch ALL dashboard widget options from the db...
		$opts = get_option( 'dashboard_widget_options' );

		//Get just our widget's options, or set empty array
		$w_opts = ( isset( $opts[$widget_id] ) ) ? $opts[$widget_id] : array();

		if ( $add_only ) {
			//Flesh out any missing options (existing ones overwrite new ones)
			$opts[$widget_id] = array_merge($args,$w_opts);
		}
		else {
			//Merge new options with existing ones, and add it back to the widgets array
			$opts[$widget_id] = array_merge($w_opts,$args);
		}

		//Save the entire widgets array back to the db
		return update_option('dashboard_widget_options', $opts);
	}
}
?>