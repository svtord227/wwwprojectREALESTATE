<?php
class ControllerExtensionModuleFindsearch extends Controller {
	public function index() {
		
		$this->load->language('extension/module/findsearch');
		$this->load->model('property/property');
		$this->load->model('catalog/category');
		$this->load->model('localisation/country');
		$this->load->model('tool/image');
		$data['text_search'] = $this->language->get('text_search');
	
		$data['text_findproperty'] 	= $this->language->get('text_findproperty');
		//$data['text_city'] 		= $this->language->get('text_city');
		$data['entry_city']      	= $this->language->get('entry_city');
		$data['entry_address']      = $this->language->get('entry_address');
		$data['entry_Neighborhood'] = $this->language->get('entry_Neighborhood');
		$data['entry_Zipcode']      = $this->language->get('entry_Zipcode');
		$data['entry_State']      	= $this->language->get('entry_State');
		$data['text_country']      	= $this->language->get('text_country');
		$data['text_Price']      	= $this->language->get('text_Price');
		$data['text_advancesearch'] = $this->language->get('text_advancesearch');
		$data['text_nearestplace']  = $this->language->get('text_nearestplace');
		$data['text_amenities']     = $this->language->get('text_amenities');
		$data['text_area']      	= $this->language->get('text_area');
		$data['text_bedrooms']      = $this->language->get('text_bedrooms');
		$data['entry_bedrooms']     = $this->language->get('entry_bedrooms');
		$data['text_SqFt']      	= $this->language->get('text_SqFt');
		$data['text_bathrooms']     = $this->language->get('text_bathrooms');
		$data['entry_bathrooms']    = $this->language->get('entry_bathrooms');
		$data['button_search']		= $this->language->get('button_search');
		$data['text_select'] 		= $this->language->get('text_select');
		$data['text_bed'] 			= $this->language->get('text_bed');
		$data['text_bath'] 			= $this->language->get('text_bath');
		
		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}
		
		if (isset($this->request->get['filter_propertystatus'])) {
			$data['filter_propertystatus'] = $this->request->get['filter_propertystatus'];
		} else {
			$data['filter_propertystatus'] = '';
		}
			
		if (isset($this->request->get['filter_propertycategory'])) {
			$data['filter_propertycategory'] = $this->request->get['filter_propertycategory'];
		} else {
			$data['filter_propertycategory'] = '';
		}
		
		
		if (isset($this->request->get['filter_city'])) {
			$data['filter_city'] = $this->request->get['filter_city'];
		} else {
			$data['filter_city'] = '';
		}
		
		if (isset($this->request->get['filter_address'])) {
			$data['filter_address'] = $this->request->get['filter_address'];
		} else {
			$data['filter_address'] = '';
		}
		
		if (isset($this->request->get['filter_neighborhood'])) {
			$data['filter_neighborhood'] = $this->request->get['filter_neighborhood'];
		} else {
			$data['filter_neighborhood'] = '';
		}
		
		if (isset($this->request->get['filter_zipcode'])) {
			$data['filter_zipcode'] = $this->request->get['filter_zipcode'];
		} else {
			$data['filter_zipcode'] = '';
		}
		
		if (isset($this->request->get['country_id'])) {
			$data['country_id'] = $this->request->get['country_id'];
		} else {
			$data['country_id'] = '';
		}
		
		
		if (isset($this->request->get['zone_id'])) {
			$data['zone_id'] = $this->request->get['zone_id'];
		} else {
			$data['zone_id'] = '';
		}
		
		if (isset($this->request->get['filter_bed_rooms'])) {
			$data['filter_bed_rooms'] = $this->request->get['filter_bed_rooms'];
		} else {
			$data['filter_bed_rooms'] = '';
		}

		if (isset($this->request->get['filter_bath_rooms'])) {
			$data['filter_bath_rooms'] = $this->request->get['filter_bath_rooms'];
		} else {
			$data['filter_bath_rooms'] = '';
		}
		
		
		$this->load->model('property/category');		
		$data['max_price']=$this->model_property_category->getPropertyPrice();
		$data['max_area']=$this->model_property_category->getPropertyArea();
		
		if(isset($this->request->get['filter_area'])) {
		
		list($area_from,$area_to)=explode(';',$this->request->get['filter_area']);
		$data['area_from'] =$area_from;
		$data['area_to'] =$range_to;
		} else {
		$data['area_from'] ='1';
		$data['area_to'] ='10';
		}
		
		if(isset($this->request->get['filter_range'])) {
		
		list($range_from,$range_to)=explode(';',$this->request->get['filter_range']);
		$data['range_from'] =$range_from;
		$data['range_to'] =$range_to;
		} else {
		$data['range_from'] ='1';
		$data['range_to'] ='10';
		}
		
		$data['cur_code'] = $this->currency->getSymbolRight($this->session->data['currency']);
		if(isset($data['cur_code'])) {
		$data['cur_code']=$this->currency->getSymbolLeft($this->session->data['currency']);
		}
		
		
		
		$category_id=array();
			if (isset($this->request->post['country_id'])){
				$data['country_id'] = $this->request->post['country_id'];
			}
	
			if (isset($this->request->post['zone_id'])){
				$data['zone_id'] = $this->request->post['zone_id'];
			}
	
		 
		 

	  $data['featuresImages']=array();
		$featuresImages= $this->model_property_property->getFeaturesImage(array());
		//print_r($featuresImages);die();
		foreach($featuresImages as $featuresImage){
			if (is_file(DIR_IMAGE .$featuresImage['image'])) {
				$image = $this->model_tool_image->resize($featuresImage['image'], 20, 20);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 20, 20);
			}
			$data['featuresImages'][]=array(
				'feature_id'  => $featuresImage['feature_id'],
				'image'  => $image,
			);
		}
		$data['nearestplaces']=array();
		$nearestplaces= $this->model_property_property->getNearestImage(array());
		foreach($nearestplaces as $nearestplace){
			if (is_file(DIR_IMAGE .$nearestplace['image'])) {
				$image = $this->model_tool_image->resize($nearestplace['image'], 20, 20);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 20, 20);
			}
			$data['nearestplaces'][]=array(
				'nearest_place_id'  => $nearestplace['nearest_place_id'],
				'image'  => $image,
				
			);
		}
		
		$this->load->model('localisation/country');
		$data['countrys'] = $this->model_localisation_country->getCountries();
		$this->load->model('property/property_status');
		$data['propertyinfo']=$this->model_property_property_status->getpropertystatus($data);
	    $data['categorys'] =$this->model_catalog_category->getCategories($category_id);
		
		
		
		return $this->load->view('extension/module/findsearch', $data);
	}
	 
	 public function findproperty(){
		 	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			  $json['success'] = $this->language->get('text_success');
			}
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
	 }
	
}