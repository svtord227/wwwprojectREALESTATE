<?php
class ControllerExtensionModuleFeatured extends Controller {
	public function index($setting) {
		
		$this->load->language('extension/module/featured');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_tax'] = $this->language->get('text_tax');
		//xml
		$data['text_details'] = $this->language->get('text_details');
		$data['text_rent'] = $this->language->get('Rent');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_sqft'] = $this->language->get('Sq Ft');
		$data['text_amenities'] = $this->language->get('Amenities');
		$data['text_NearestPlace'] = $this->language->get('Nearest Place');
		$data['text_apartment'] = $this->language->get('text_apartment');
		$data['text_4Daysago'] = $this->language->get('text_4Daysago');
		$data['text_bedrooms'] = $this->language->get('text_bedrooms');
		$data['text_bathrooms'] = $this->language->get('text_bathrooms');
		$data['text_garge'] = $this->language->get('text_garge');
		$data['text_nearest'] = $this->language->get('text_nearest');
		//xml
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		
		$this->load->model('property/property');
		 $this->load->model('property/property_status');
		 $data['propertys'] = array();
			
		if (!$setting['limit']) {
			$setting['limit'] = 6;
		}

		if (!empty($setting['properties'])) {
			$propertys = array_slice($setting['properties'], 0, (int)$setting['limit']);	

			foreach($propertys as $property_id){
				$property = $this->model_property_property->getProperty($property_id);
				if ($property['image']) {
					$image = $this->model_tool_image->resize($property['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}	
				
				$category='';
				$category_ids=$this->model_property_property->getpropertytocategory($property['property_id']);
				if(isset($category_ids)){
					foreach($category_ids as $category_id){
						$category_info=$this->model_property_category->getCategory($category_id);
						if(isset($category_info['name'])){
							$category .=$category_info['name'];         
						}
					}
				}
				
					
				 $features_info=$this->model_property_property->getproperfeature($property['property_id']);
				$features=array();
				 foreach($features_info as $info){
					 if ($info['image']) {
						$features[]= $this->model_tool_image->resize($info['image'],30,30);
					}
				}
				
				
				$nearestplace_info=$this->model_property_property->getNeareastplace($property['property_id']);
			
				$nearestplaces=array();
				foreach($nearestplace_info as $neares){
					
				  if ($neares['image']) {
			 		$nearestplaces[] = $this->model_tool_image->resize($neares['image'],30,30);
				 } 
				}		
				$rent=$this->model_property_property_status->getOrderStatus($property['property_status_id']);
				if(isset($rent['name']))
				{
					$propertyrent=$rent['name'];         
				}else{
					$propertyrent='';
				}		
				$data['propertys'][] = array(
					'property_id'  => $property['property_id'],
					'name'  => $property['name'],
					'propertyrent'  => $propertyrent,
					'thumb'  => $image,
					'category'  => $category,
					'features'  => $features,
					'nearestplaces'  =>$nearestplaces,
					'price'  => $this->currency->format($property['price'],$this->session->data['currency']),
					'area'  => $property['area'],
					'city'  => $property['city'],
					'local_area'  => $property['local_area'],
					'neighborhood'  => $property['neighborhood'],
					'bedrooms'  => $property['bedrooms'],
					'bathrooms'  => $property['bathrooms'],
					'date_added'   => $this->timeAgo($property['date_added']),
					'href'      => $this->url->link('property/property_detail', 'property_id=' . $property['property_id']));
			}
		}
		
		
		
		
		
		
		if ($data['propertys']) {
			
			$featurelay = $this->config->get('tmdrealstate_properites');

				if($featurelay=='1'){
					return $this->load->view('extension/module/featured', $data);
					$this->response->setOutput($this->load->view('property/property_detail', $data));				
				} elseif($featurelay=='2'){
					return $this->load->view('extension/module/featured1', $data);
					$this->response->setOutput($this->load->view('property/property_detail', $data));
				} elseif($featurelay=='3'){
					return $this->load->view('extension/module/featured2', $data);
					$this->response->setOutput($this->load->view('property/property_detail', $data));							
				} else {				
					return $this->load->view('extension/module/featured', $data);
					$this->response->setOutput($this->load->view('property/property_detail', $data));			
				} 	
		
		 }
			
			
		}
	
	function timeAgo($time_ago){
		$time_ago      = strtotime($time_ago);
		$cur_time      = time();
		$time_elapsed  = $cur_time - $time_ago;
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60);
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400);
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640);
		$years      = round($time_elapsed / 31207680);
		// Seconds
		if($seconds <= 60){
			return "just now";
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return "one minute ago";
			} else {
				return "$minutes minutes ago";
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return "an hour ago";
			} else {
				return "$hours hrs ago";
			}
		}
		//Days
		else if($days <= 7){
			if($days==1){
				return "yesterday";
			} else {
				return "$days days ago";
			}
		}
		//Weeks
		else if($weeks <= 4.3){
			if($weeks==1){
				return "a week ago";
			} else {
				return "$weeks weeks ago";
			}
		}
		//Months
		else if($months <=12){
			if($months==1){
				return "a month ago";
			} else {
				return "$months months ago";
			}
		}
		//Years
		else{
			if($years==1){
				return "one year ago";
			} else {
				return "$years years ago";
			}
		}
	}
		 

}
