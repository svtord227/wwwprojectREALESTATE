<?php

	class ControllerPropertyPropertyDetail extends Controller {

	private $error = array();

	public function index() {

		

		$this->load->language('property/property_detail');

		$this->load->model('tool/image');

		$this->load->model('property/property');

		$this->load->model('agent/agent');

		$this->load->model('tool/image');

		$this->load->model('property/category');

		$this->load->model('localisation/country');

		$this->load->model('localisation/zone');

		

		if (isset($this->request->get['property_id'])) {

			$property_id = $this->request->get['property_id'];

		} else {

			$property_id = '';

		}

		if (isset($this->request->get['filter_propertycategory'])) {

			$filter_propertycategory = $this->request->get['filter_propertycategory'];

		} else {

			$filter_propertycategory = '';

		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(

			'text' => $this->language->get('text_home'),

			'href' => $this->url->link('common/home')

		);

		if(!empty($filter_propertycategory))

			{

			$category_info = $this->model_property_category->getCategory($filter_propertycategory);

			if($category_info)

			{

			$data['breadcrumbs'][] = array(

				'text' => $category_info['name'],

				'href' => $this->url->link('property/category','&filter_propertycategory='.$filter_propertycategory)

			);

			}

		}

		

		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');

		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');



		if (isset($this->error['warning'])) {

			$data['error_warning'] = $this->error['warning'];

		} else {

			$data['error_warning'] = '';

		}

		

		$propertys_info=$this->model_property_property->getProperty($this->request->get['property_id']);

		if(empty($propertys_info['name'])) {

				$this->response->redirect($this->url->link('common/home', '', 'SSL'));

			}

		if (isset($propertys_info['image'])) {

			$image = $this->model_tool_image->resize($propertys_info['image'], 768,505);

		} else {

			$image = $this->model_tool_image->resize('placeholder.png',768,505);

		}

		$data['image']=$image;

		$data['name']=$propertys_info['name'];

		$data['property_id']=$propertys_info['property_id'];

		$data['price']=$propertys_info['price'];

		$data['description']=html_entity_decode($propertys_info['description']);

		$data['bedrooms']=$propertys_info['bedrooms'];

		$data['bathrooms']=$propertys_info['bathrooms'];

		$data['area']=$propertys_info['area'];

		//Contact Agent////// 

		$property_agents=$this->model_agent_agent->getouragenticon($propertys_info['property_agent_id']);



		if(isset($property_agents)){

			foreach($property_agents as $property_agent){

				$propertyagent=$this->model_property_property->getTotalPhotos($property_agent['property_agent_id']);

				if (isset($property_agent['image'])) {

					$agentimage = $this->model_tool_image->resize($property_agent['image'], 768,505);

				} else {

					$agentimage = $this->model_tool_image->resize('placeholder.png',768,505);

				}

				$data['propertycontactagent'][] = array(

					'agentimage'  => $agentimage,

					'propertyagent'	=> $propertyagent,

					'facebook'  => $property_agent['facebook'],

					'googleplus'  => $property_agent['googleplus'],

					'twitter'  => $property_agent['twitter'],

					'pinterest'  => $property_agent['pinterest'],

					'instagram'  => $property_agent['instagram'],

					'agentname'  => $property_agent['agentname'],

				);

			}

		}

		

		$data['latitude']			=$propertys_info['latitude'];

		$data['longitude']			=$propertys_info['longitude'];

		$data['pincode']			=$propertys_info['pincode'];

		$data['local_area']			=$propertys_info['local_area'];

	   $data['mapkey'] = $this->config->get('config_mapkey');

		$getZone     				= $this->model_localisation_zone->getZone($propertys_info['zone_id']);

		if(isset($getZone['name'])){

		$zonename = $getZone['name'];	

		} else{

			

		$zonename = '';	

		}

		$data['zone']		    	=$zonename;

		$getCountry  				= $this->model_localisation_country->getCountry($propertys_info['country_id']);

		$data['country']	    	=$getCountry['name'];

		// Local , pincde, zone , country;

		$data['address']='aaa';

		//$address=

		// For goggle map

		//Contact Agent end////// 

		if (isset($this->request->post['config_fburl'])) {

			$data['fburl'] = $this->request->post['config_fburl'];

		} else {

			$data['fburl'] = $this->config->get('config_fburl');

		}



		if (isset($this->request->post['config_google'])) {

			$data['google'] = $this->request->post['config_google'];

		} else {

			$data['google'] = $this->config->get('config_google');

		}



		if (isset($this->request->post['config_twet'])) {

			$data['twet'] = $this->request->post['config_twet'];

		} else {

			$data['twet'] = $this->config->get('config_twet');

		}



		if (isset($this->request->post['config_in'])) {

			$data['in'] = $this->request->post['config_in'];

		} else {

			$data['in'] = $this->config->get('config_in');

		}



		if (isset($this->request->post['config_instagram'])) {

			$data['instagram'] = $this->request->post['config_instagram'];

		} else {

			$data['instagram'] = $this->config->get('config_instagram');

		}



		if (isset($this->request->post['config_pinterest'])) {

			$data['pinterest'] = $this->request->post['config_pinterest'];

		} else {

			$data['pinterest'] = $this->config->get('config_pinterest');

		}



		$this->load->model('tool/image');

		$featuresinfo=array();

		$features_info=$this->model_property_property->getproperfeature($this->request->get['property_id']);

		if(isset($features_info)){

			foreach($features_info as $infos){

				if (isset($infos['image'])) {

					$features = $this->model_tool_image->resize($infos['image'], 30,30);

				} 

				$data['featuress'][] = array(

					'features'  => $features,

					'name'  => $infos['name'],

				);

			}	

		}

		$propertyimages=$this->model_property_property->getPropertyImages($this->request->get['property_id']);

		if(isset($propertyimages)){

			foreach($propertyimages as $propertyimage){

				if (isset($propertyimage['image'])) {

					$imagesbanner = $this->model_tool_image->resize($propertyimage['image'], 768,505);

				} 

				$data['propertyimagesbanners'][] = array(

					'imagesbanner'  => $imagesbanner,

					'title'  		=> $propertyimage['title'],

					'alt'  		=> $propertyimage['alt'],

				);



			}

		}

		$nearestplace_info=$this->model_property_property->getNeareastplace($this->request->get['property_id']);		

		if(isset($nearestplace_info)){

			foreach($nearestplace_info as $info){

				if (isset($info['image'])) {

					$nearplace = $this->model_tool_image->resize($info['image'], 30,30);

				} 

				$data['nearest'][] = array(

					'nearplace'  => $nearplace,

					'name'  => $info['name'],

				);

			}	

		}		

		$data['breadcrumbs'][] = array(

			'text' => $this->language->get($propertys_info['name']),

			'href' => $this->url->link('property/category')

		);

		$this->document->setTitle($this->language->get($propertys_info['name']));

		$data['heading_title'] 				= $this->language->get('heading_title');

		$data['text_contactagent'] 			= $this->language->get('text_contactagent');

		$data['text_contactnow'] 			= $this->language->get('text_contactnow');

		$data['text_sendmsg'] 				= $this->language->get('text_sendmsg');

		$data['entry_name'] 				= $this->language->get('entry_name');

		$data['entry_email'] 				= $this->language->get('entry_email');

		$data['entry_msg'] 					= $this->language->get('entry_msg');

		$data['button_submit'] 				= $this->language->get('button_submit');

		$data['text_sendmsg'] 				= $this->language->get('text_sendmsg');

		$data['text_image'] 				= $this->language->get('text_image');

		$data['text_name'] 					= $this->language->get('text_name');

		$data['text_sqft']					= $this->language->get('Sq Ft');

		$data['text_bedrooms'] 				= $this->language->get('text_bedrooms');

		$data['text_bathrooms'] 	 		= $this->language->get('text_bathrooms');

		$data['text_price'] 				= $this->language->get('text_price');

		$data['text_description'] 	 		= $this->language->get('text_description');

		$data['text_country'] 				= $this->language->get('text_country');

		$data['text_region'] 				= $this->language->get('text_region');

		$data['text_city'] 					= $this->language->get('text_city');

		$data['text_local_area'] 	    	= $this->language->get('text_local_area');

		$data['text_bedrooms'] 				= $this->language->get('text_bedrooms');

		$data['text_bathrooms'] 	 		= $this->language->get('text_bathrooms');

		$data['text_parking'] 				= $this->language->get('text_parking');

		$data['text_nearplace']  	    	= $this->language->get('text_nearplace');

		$data['text_pincode'] 				= $this->language->get('text_pincode');

		$data['text_area'] 					= $this->language->get('text_area');

		$data['text_amenities'] 			= $this->language->get('text_amenities');

		$data['button_cart'] 				= $this->language->get('button_cart');

		$data['button_wishlist'] 			= $this->language->get('button_wishlist');

		$data['button_compare'] 			= $this->language->get('button_compare');

		$data['button_upload'] 				= $this->language->get('button_upload');

		$data['button_continue'] 			= $this->language->get('button_continue');

		$data['text_property'] 				= $this->language->get('text_property');

		$data['column_left'] 				= $this->load->controller('common/column_left');

		$data['column_footer5'] 			= $this->load->controller('common/column_footer5');

		$data['column_right'] 				= $this->load->controller('common/column_right');

		$data['content_top'] 				= $this->load->controller('common/content_top');

		$data['content_bottom'] 			= $this->load->controller('common/content_bottom');

		$data['footer'] 				 	= $this->load->controller('common/footer');

		$data['header'] 					= $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('property/property_detail', $data));

    }

	

	public function Sendenquery(){

		$this->load->language('property/property_detail');

		$this->load->model('property/property');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$this->model_property_property->addEnquiry($this->request->post);

			$json['success'] = $this->language->get('text_success');

		}	

		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));

	 }

 }

