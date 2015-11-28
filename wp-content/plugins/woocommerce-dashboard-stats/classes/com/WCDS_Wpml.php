<?php
class WCDS_Wpml
{
	public function __construct()
	{
	}
	public function wpml_is_active()
	{
		return class_exists('SitePress');
	}
	public function get_original_ids($items_array, $post_type = "product")
	{
		if(!class_exists('SitePress'))
			return false;
		
		global $sitepress;
		$original_ids = array();
		foreach($items_array as $item)	
		{
			if(function_exists('icl_object_id'))
				$item_translated_id = icl_object_id($item->id, $post_type, true, $sitepress->get_default_language());
			else
				$item_translated_id = apply_filters( 'wpml_object_id', $item->id, $post_type, true, $sitepress->get_default_language() );
			
			if(!in_array($item_translated_id, $original_ids))
				array_push($original_ids, $item_translated_id);
		}
			
		return $original_ids;
	}
	public function get_original_id($item_id, $post_type = "product")
	{
		if(!class_exists('SitePress'))
			return false;
		
		global $sitepress;
		if(function_exists('icl_object_id'))
			$item_translated_id = icl_object_id($item_id, $post_type, true, $sitepress->get_default_language());
		else
			$item_translated_id = apply_filters( 'wpml_object_id', $item_id, $post_type, true, $sitepress->get_default_language() );
		
		return $item_translated_id;
	}
}
?>