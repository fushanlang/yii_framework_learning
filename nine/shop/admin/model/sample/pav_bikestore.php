<?php 
if( !class_exists("ModuleSample") ) {
	class ModuleSample { 
		public static function getModules(){ 
			$modules = array(
				'pavcustom',
				'pavproductcarousel',
				'special',
				'pavcontentslider',
				'bestseller',
				'pavmegamenu'
			);
			
			return $modules;
		}
		
		public static function getModulesQuery(){
			$query = array();
			require( dirname(__FILE__).'/pav_bikestore_query.php' );
			return $query;
		}
		
		public static function getStoreConfigs(){
			return array(
					'config_image_category_width' =>700,
					'config_image_category_height' => 258,
					
					'config_image_thumb_width' =>300,
					'config_image_thumb_height' => 250,
					
					'config_image_popup_width' =>500,
					'config_image_popup_height' => 416,
					
					'config_image_product_width' =>202,
					'config_image_product_height' => 168,
					
					'config_image_additional_width' =>92,
					'config_image_additional_height' => 77,
					
					'config_image_related_width' =>202,
					'config_image_related_height' => 168,
					
					'config_image_compare_width' =>202,
					'config_image_compare_height' => 168,
					
					'config_image_wishlist_width' =>55,
					'config_image_wishlist_height' => 46,
					
					'config_image_cart_width' =>55,
					'config_image_cart_height' => 46,
			);
		}
	
	}
}
?>