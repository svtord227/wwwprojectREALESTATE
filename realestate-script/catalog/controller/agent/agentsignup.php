<?php  
class ControlleragentAgentsignup  extends Controller {
	private $error = array();
	public function index() {
		if ($this->agent->isLogged()) {
			$this->response->redirect($this->url->link('agent/dashboard', '', true));
		}
		$this->load->language('agent/agentsignup');
		$this->load->model('agent/agent');
		$this->load->model('tool/image');	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_agent_agent->addAgent($this->request->post);
			$this->agent->login($this->request->post['email'], $this->request->post['password']);
		
			$this->response->redirect($this->url->link('agent/agentsuccess'));
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_register'),
			'href' => $this->url->link('agent/agentsignup')
		);
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['agentname'])) {
			$data['error_agentname'] = $this->error['agentname'];
		} else {
			$data['error_agentname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = '';
		}
	  	if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}
	  	if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}
		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}
	  	if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}
   	 	if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}
		if (isset($this->error['positions'])) {
			$data['error_positions'] = $this->error['positions'];
		} else {
			$data['error_positions'] = '';
		}
	  	if (isset($this->error['contact'])) {
			$data['error_contact'] = $this->error['contact'];
		} else {
			$data['error_contact'] = '';
		}	
	  	if (isset($this->error['pincode'])) {
			$data['error_postcode'] = $this->error['pincode'];
		} else {
			$data['error_postcode'] = '';
		}
	
	
	
		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}
		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int)$this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_address']['country_id'])) {
			$data['country_id'] = $this->session->data['shipping_address']['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}
		
		if (isset($this->request->post['agentname'])) {
			$data['agentname'] = $this->request->post['agentname'];
		} else {
			$data['agentname'] = '';
		}
	  	if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} else {
			$data['description'] = '';
		}
		
		
	  	if (isset($this->request->post['thumb'])) {
			$data['thumb'] = $this->request->post['thumb'];
		} else {
			$data['thumb'] = '';
		}
		
		
		if (isset($this->request->post['positions'])) {
			$data['positions'] = $this->request->post['positions'];
		} else {
			$data['positions'] = '';
		}
	  	if (isset($this->request->post['image'])) {
		$data['image'] = $this->request->post['image'];
		} else {
		$data['image'] = '';
		}
	  	if (isset($this->request->post['contact'])) {
			$data['contact'] = $this->request->post['contact'];
		} else {
			$data['contact'] = '';
		}
		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} else {
			$data['city'] = '';
		}
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}	
	  	if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} else {
			$data['address'] = '';
		}
		if (isset($this->request->post['pincode'])) {
			$data['pincode'] = $this->request->post['pincode'];
		} else {
			$data['pincode'] = '';
		}
		
		
		if (isset($this->request->post['plans_id'])) {
			$data['plans_id'] = $this->request->post['plans_id'];
		} else {
			$data['plans_id'] = '';
		}
		
		
		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = (int)$this->request->post['zone_id'];
		} elseif (isset($this->session->data['shipping_address']['zone_id'])) {
			$data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
		} else {
			$data['zone_id'] = '';
		}
	
		 ////plans ////
		 $this->load->model('membership/plans');
		$data['memberships']=$this->model_membership_plans->getPlansies($data);
		
	 ////plans ////

		$this->load->model('localisation/country');
 		$data['countries']                      = $this->model_localisation_country->getCountries();
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title']   				=$this->language->get('heading_title');
		$data['text_account_already']           =$this->language->get('text_account_already');
		$data['text_your_details']   		    =$this->language->get('text_your_details');
		$data['entry_firstname']   			    =$this->language->get('entry_firstname');
		$data['entry_lastname']   			    =$this->language->get('entry_lastname');
		$data['entry_email']   					=$this->language->get('entry_email');
		$data['entry_telephone']   			    =$this->language->get('entry_telephone');
		$data['entry_image']   					=$this->language->get('entry_image');
		$data['entry_fax']   					=$this->language->get('entry_fax');
		$data['entry_company']   				=$this->language->get('entry_company');
		$data['entry_address_1']   			    =$this->language->get('entry_address_1');
		$data['entry_address_2']   			    =$this->language->get('entry_address_2');
		$data['entry_postcode']   			    =$this->language->get('entry_postcode');
		$data['entry_city']   					=$this->language->get('entry_city');
		$data['entry_country']   				=$this->language->get('entry_country');
		$data['button_upload']   				=$this->language->get('button_upload');
		$data['text_loading']  				 	=$this->language->get('text_loading');
		$data['entry_agent']   					=$this->language->get('entry_agent');
	    $data['entry_zone']   					=$this->language->get('entry_zone');
		$data['entry_newsletter']   		    =$this->language->get('entry_newsletter');
		$data['entry_password']   			    =$this->language->get('entry_password');
		$data['text_none']   					=$this->language->get('text_none');
		$data['entry_descriptions']   	        =$this->language->get('entry_descriptions');
		$data['entry_contact']   				=$this->language->get('entry_contact');
		$data['entry_confirm']   				=$this->language->get('entry_confirm');
		$data['text_your_address']   		    =$this->language->get('text_your_address');
		$data['text_your_password']   	        =$this->language->get('text_your_password');
		$data['text_newsletter']   		        =$this->language->get('text_newsletter');
		$data['entry_newsletter']  			    =$this->language->get('entry_newsletter');
		$data['entry_newsletter']   		    =$this->language->get('entry_newsletter');
		$data['entry_positions']   			    =$this->language->get('entry_positions');
		$data['entry_address']   				=$this->language->get('entry_address');
		$data['button_submit']					=$this->language->get('button_submit');
		$data['enter_number']                   = $this->language->get('enter_number');
		$data['text_day']						=$this->language->get('text_day');
		$data['text_month']						=$this->language->get('text_month');
		$data['text_years']						=$this->language->get('text_years');
		$data['text_select']					=$this->language->get('text_select');
		$data['entry_validate']					=$this->language->get('entry_validate');
		$data['text_selectplans']   		   	=$this->language->get('text_selectplans');
		$data['entry_plans']   					=$this->language->get('entry_plans');
		$data['text_name']   					=$this->language->get('text_name');
		$data['text_price']   					=$this->language->get('text_price');
		$data['text_month']   					=$this->language->get('text_month');
		$data['entry_facebook']   				=$this->language->get('entry_facebook');
		$data['entry_instagram']   				=$this->language->get('entry_instagram');
		$data['entry_social']   				=$this->language->get('entry_social');
		$data['button-upload']   				=$this->language->get('button-upload');
			
		$data['entry_twitter']   				=$this->language->get('entry_twitter');
		$data['entry_googleplus']   			=$this->language->get('entry_googleplus');
		$data['entry_pinterest']   				=$this->language->get('entry_pinterest');
		$data['column_images'] 					= $this->language->get('column_images');
		
		$data['column_left'] 					= $this->load->controller('common/column_left');
		$data['column_right'] 					= $this->load->controller('common/column_right');
		$data['content_top']	 				= $this->load->controller('common/content_top');
		$data['content_bottom'] 				= $this->load->controller('common/content_bottom');
		$data['footer'] 						= $this->load->controller('common/footer');
		$data['header'] 						= $this->load->controller('common/header');
		
		$this->response->setOutput($this->load->view('agent/agentsignup', $data));
	}
	private function validate() {
		
		if ((utf8_strlen(trim($this->request->post['agentname'])) < 1) || (utf8_strlen(trim($this->	request->post['agentname'])) > 32)) {
			$this->error['agentname'] = $this->language->get('error_agentname');
		}
		
		if ((utf8_strlen(trim($this->request->post['pincode'])) < 1) || (utf8_strlen(trim($this->	request->post['pincode'])) > 32)) {
			$this->error['pincode'] = $this->language->get('error_postcode');
		}
		
		if ((utf8_strlen(trim($this->request->post['positions'])) < 1) || (utf8_strlen(trim($this->request->post['positions'])) > 32)) {
			$this->error['positions'] = $this->language->get('error_positions');
		}
		
		if ((utf8_strlen(trim($this->request->post['contact'])) < 10) || (utf8_strlen(trim($this->request->post['contact'])) > 32)) {
			$this->error['contact'] = $this->language->get('error_contact');
		}
		
		if ((utf8_strlen(trim($this->request->post['description'])) < 1) || (utf8_strlen(trim($this->request->post['description'])) > 400)) {
			$this->error['description'] = $this->language->get('error_description');
		}
		
		if ($this->request->post['image'] == '') {
			$this->error['image'] = $this->language->get('error_image');
		}
		
		if ($this->request->post['country_id'] == '') {
			$this->error['country'] = $this->language->get('error_country');
		}

	
		 
		
		
		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
			$this->error['zone'] = $this->language->get('error_zone');
		}
		
		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}
		
		if ((utf8_strlen(trim($this->request->post['address'])) < 3) || (utf8_strlen(trim($this->request->post['address'])) > 128)) {
			$this->error['address'] = $this->language->get('error_address');
		}
		
		if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}
		
		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}
		
		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}
		return !$this->error;
 }
	public function country() {
		$json = array();
		$this->load->model('localisation/country');
		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		if ($country_info) {
			$this->load->model('localisation/zone');
			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
 }
	public function upload(){
		$this->load->language('tool/upload');
		$json = array();
		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
				$json['error'] = $this->language->get('error_filename');
			}
			// Allowed file extension types
			$allowed = array();
			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));
			$filetypes = explode("\n", $extension_allowed);
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Allowed file mime types
			$allowed = array();
			$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));
			$filetypes = explode("\n", $mime_allowed);
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');

			}
			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['file']['tmp_name']);
			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Return any upload error
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
		if (!$json) {
			$targetDir = DIR_IMAGE.'catalog/';
			$file = $filename;
			$location = $targetDir.$file;
			$location1 = 'catalog/'.$file;
			move_uploaded_file($this->request->files['file']['tmp_name'], $location);
			$json['location1'] =$location1;
			$json['success'] = $this->language->get('text_upload');
		}
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		} 
	
	public function autocomplete() {
		$json = array();
		if (isset($this->request->get['filter_name'])) 
		{
			$this->load->model('agent/agent');
			$filter_data = array(
			'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'agentname',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);
			$results = $this->model_agent_agent->getAgents($filter_data);
			foreach ($results as $result) {
				$json[] = array(
					'property_agent_id' => $result['property_agent_id'],
					'agentname'        => strip_tags(html_entity_decode($result['agentname'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$sort_order = array();
		foreach ($json as $key => $value) 
		{
			$sort_order[$key] = $value['agentname'];
		}
		array_multisort($sort_order, SORT_ASC, $json);
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
	}
	
 }
