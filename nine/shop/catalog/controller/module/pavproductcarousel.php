<?php  
class ControllerModulePavproductcarousel extends Controller {
	protected function index($setting) {
		static $module = 0;
		
		$this->load->model('catalog/product'); 
		$this->load->model('tool/image');
		$this->language->load('module/pavproductcarousel');
		
		$this->data['button_cart'] = $this->language->get('button_cart');
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavproductcarousel.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavproductcarousel.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/pavproductcarousel.css');
		}
		$default = array(
			'latest' => 1,
			'limit' => 9
		);
	 
		$this->data['width'] = $setting['width'];
		$this->data['height'] = $setting['height'];
		$this->data['cols']   = (int)$setting['cols'];
		$this->data['itemsperpage']   = (int)$setting['itemsperpage'];
		$this->data['tabs'] = array();
		
	$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);
		
	
		 $setting['tabs'] = array_flip(  $setting['tabs'] );
	
		$tabs = array(
			'latest' 	 => array(),
			'featured'   => array( ),
			'bestseller' => array(),
			'special'   => array(),
			'mostviewed' => array()
		);	
		if( isset($setting['description'][$this->config->get('config_language_id')]) ) {
			$this->data['message'] = html_entity_decode($setting['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else {
			$this->data['message'] = '';
		} 
		if( isset($setting['tabs']['latest']) ){
			$products = $this->getProducts( $this->model_catalog_product->getProducts( $data ), $setting );
			$this->data['heading_title'] = $this->language->get('text_latest');
	 	}
		if( isset($setting['tabs']['bestseller']) ){
			$products = $this->getProducts( $this->model_catalog_product->getBestSellerProducts( $data ), $setting );
			$this->data['heading_title'] = $this->language->get('text_bestseller');
	 	}
		if( isset($setting['tabs']['special']) ){
			$products = $this->getProducts( $this->model_catalog_product->getProductSpecials( $data ), $setting );
			$this->data['heading_title'] = $this->language->get('text_special');
		}
		if( isset($setting['tabs']['mostviewed']) ){
			$data['sort'] = 'p.viewed';
			$products = $this->getProducts( $this->model_catalog_product->getProducts( $data ), $setting );
			$this->data['heading_title'] = $this->language->get('text_mostviewed');
		}
//	  	echo '<pre>'.print_r( $tabs['special'],1 ); die;
		$this->data['products'] = $products;
		$this->data['module'] = $module++;
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pavproductcarousel.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/pavproductcarousel.tpl';
		} else {
			$this->template = 'default/template/module/pavproductcarousel.tpl';
		}
		
		$this->render();
	}
	
	private function getProducts( $results, $setting ){
		$products = array();
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
			} else {
				$image = false;
			}
						
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
			 
			$products[] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'description'=> (html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')),
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}
		return $products;
	}
}
?>