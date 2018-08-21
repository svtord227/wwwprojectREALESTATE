<?php
class ControllerExtensionModuleSearch1 extends Controller {
	public function index() {
		$this->load->language('extension/module/search1');
		$this->load->model('property/property');

		$data['text_search'] = $this->language->get('text_search');
		$data['text_findproperty'] = $this->language->get('text_findproperty');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_bedroom'] = $this->language->get('text_bedroom');
		$data['text_bathroom'] = $this->language->get('text_bathroom');
		$data['text_propertyselect'] = $this->language->get('text_propertyselect');
		$data['text_advancesearch'] = $this->language->get('text_advancesearch');
		$data['button_search'] = $this->language->get('button_search');
		$data['text_bedrooms'] = $this->language->get('text_bedrooms');
		$data['text_bathrooms'] = $this->language->get('text_bathrooms');
		$data['text_nearestplace'] = $this->language->get('text_nearestplace');
		$data['text_amenities'] = $this->language->get('text_amenities');
		$data['text_propertycatagory'] = $this->language->get('text_propertycatagory');
		$data['text_country']= $this->language->get('text_country');
		$data['text_price']= $this->language->get('text_price');
		$data['text_area']= $this->language->get('text_area');
		$data['text_SqFt']= $this->language->get('text_SqFt');
		
		
		$data['entry_city']= $this->language->get('entry_city');
		$data['entry_address']= $this->language->get('entry_address');
		$data['entry_Neighborhood']= $this->language->get('entry_Neighborhood');
		$data['entry_Zipcode']= $this->language->get('entry_Zipcode');
		$data['entry_State']= $this->language->get('entry_State');
		$data['entry_bedrooms']= $this->language->get('entry_bedrooms');
		$data['entry_bathrooms']= $this->language->get('entry_bathrooms');
		$data['button_search'] = $this->language->get('button_search');
		
		
		
		if (isset($this->request->get['filter_propertystatus'])) {
			$filter_propertystatus = $this->request->get['filter_propertystatus'];
		} else {
			$filter_propertystatus = null;
		}
		
		if (isset($this->request->get['filter_propertycategory'])) {
			$filter_propertycategory = $this->request->get['filter_propertycategory'];
		} else {
			$filter_propertycategory = null;
		}
		
		if (isset($this->request->get['filter_city'])) {
			$filter_city = $this->request->get['filter_city'];
		} else {
			$filter_city = null;
		}

		if (isset($this->request->get['filter_address'])) {
			$filter_address = $this->request->get['filter_address'];
		} else {
			$filter_address = null;
		}
		
		if (isset($this->request->get['filter_neighborhood'])) {
			$filter_neighborhood = $this->request->get['filter_neighborhood'];
		} else {
			$filter_neighborhood = null;
		}

		if (isset($this->request->get['filter_zipcode'])) {
			$filter_zipcode = $this->request->get['filter_zipcode'];
		} else {
			$filter_zipcode = null;
		}

		if (isset($this->request->get['filter_country_id'])) {
			$filter_country_id = $this->request->get['filter_country_id'];
		} else {
			$filter_country_id = null;
		}

		if (isset($this->request->get['filter_zone_id'])) {
			$filter_zone_id = $this->request->get['filter_zone_id'];
		} else {
			$filter_zone_id = null;
		}

		if (isset($this->request->get['filter_bed_rooms'])) {
			$filter_bed_rooms = $this->request->get['filter_bed_rooms'];
		} else {
			$filter_bed_rooms = null;
		}
		
		if (isset($this->request->get['filter_bath_rooms'])) {
			$filter_bath_rooms = $this->request->get['filter_bath_rooms'];
		} else {
			$filter_bath_rooms = null;
		}
		
		$this->load->model('property/category');		
		$max_prices=$this->model_property_category->getPropertyPrice();
	
		if(isset($max_prices)) {
		$data['max_price'] = $max_prices;
		} else {			
		$data['max_price'] ='1000';
		}
		
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
		
		
		$url = '';
		
		if (isset($this->request->get['filter_propertystatus'])) {
				$url .= '&filter_propertystatus=' . $this->request->get['filter_propertystatus'];
			}
		
		if (isset($this->request->get['filter_propertycategory'])) {
				$url .= '&filter_propertycategory=' . $this->request->get['filter_propertycategory'];
			}
		
		if (isset($this->request->get['filter_city'])) {
				$url .= '&filter_city=' . $this->request->get['filter_city'];
			}
			
		if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . $this->request->get['filter_address'];
			}
		
		if (isset($this->request->get['filter_neighborhood'])) {
				$url .= '&filter_neighborhood=' . $this->request->get['filter_neighborhood'];
			}
		
		if (isset($this->request->get['filter_zipcode'])) {
				$url .= '&filter_zipcode=' . $this->request->get['filter_zipcode'];
			}
		

		if (isset($this->request->get['filter_country_id'])) {
				$url .= '&filter_country_id=' . $this->request->get['filter_country_id'];
			}
		
		if (isset($this->request->get['filter_zone_id'])) {
				$url .= '&filter_zone_id=' . $this->request->get['filter_zone_id'];
			}
			
		if (isset($this->request->get['filter_bed_rooms'])) {
				$url .= '&filter_bed_rooms=' . $this->request->get['filter_bed_rooms'];
			}
		
		if (isset($this->request->get['filter_bath_rooms'])) {
				$url .= '&filter_bath_rooms=' . $this->request->get['filter_bath_rooms'];
			}
		
		
		
		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}
		
		$this->load->model('property/category');		
		$data['max_price']=$this->model_property_category->getPropertyPrice();
		
		
		if (isset($this->request->post['country_id'])){
			$data['country_id'] = $this->request->post['country_id'];
		}elseif (isset($property_info['country_id'])){
			$data['country_id'] = $property_info['country_id'];
		}else {
			$data['country_id'] = '';		
		}
		if (isset($this->request->post['zone_id'])){
			$data['zone_id'] = $this->request->post['zone_id'];
		}elseif (isset($property_info['zone_id'])){
			$data['zone_id'] = $property_info['zone_id'];
		}else {
			$data['zone_id'] = '';		
		}
		
		$this->load->model('property/property_status');
		
		$data['propertystatus']=$this->model_property_property_status->getpropertystatus($data);
		//print_r($data['propertystatus']);die();
		
		$data['featuresImages']=array(
		
		
		);
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
		
		
		$data['filter_propertystatus'] = $filter_propertystatus;
		$data['filter_propertycategory'] = $filter_propertycategory;
		$data['filter_city'] = $filter_city;
		$data['filter_address'] = $filter_address;
		$data['filter_neighborhood'] = $filter_neighborhood;
		$data['filter_zipcode'] = $filter_zipcode;
		$data['filter_country_id'] = $filter_country_id;
		$data['filter_zone_id'] = $filter_zone_id;
		$data['filter_bed_rooms'] = $filter_bed_rooms;
		$data['filter_bath_rooms'] = $filter_bath_rooms;
		
		
		$this->load->model('property/category');
		$this->load->model('property/property');
		$data['categorys'] =$this->model_property_category->getCategories($data);
		//$data['categorys'] =$this->model_property_category->getCateg($data);
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		////////////////////////  country////////////
		$this->load->model('localisation/country');
		$data['countrys'] = $this->model_localisation_country->getCountries();
		
		
		$searchlay = $this->config->get('tmdrealstate_search');
		
				if($searchlay=='1'){
					return $this->load->view('extension/module/search1', $data);				
				} elseif($searchlay=='2'){
					return $this->load->view('extension/module/search2', $data);
				} elseif($searchlay=='3'){
					return $this->load->view('extension/module/search3', $data);
				} else {				
					return $this->load->view('extension/module/search1', $data);			
				}
	}
}
