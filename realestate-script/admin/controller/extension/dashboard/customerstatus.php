<?php
class ControllerExtensionDashboardCustomerstatus extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/customerstatus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('dashboard_customerstatus', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=dashboard', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=dashboard', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/dashboard/customerstatus', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/dashboard/customerstatus', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=dashboard', true);

		if (isset($this->request->post['dashboard_customerstatus_width'])) {
			$data['dashboard_customerstatus_width'] = $this->request->post['dashboard_customerstatus_width'];
		} else {
			$data['dashboard_customerstatus_width'] = $this->config->get('dashboard_customerstatus_width');
		}

		$data['columns'] = array();
		
		for ($i = 3; $i <= 12; $i++) {
			$data['columns'][] = $i;
		}
				
		if (isset($this->request->post['dashboard_customerstatus_status'])) {
			$data['dashboard_customerstatus_status'] = $this->request->post['dashboard_customerstatus_status'];
		} else {
			$data['dashboard_customerstatus_status'] = $this->config->get('dashboard_customerstatus_status');
		}

		if (isset($this->request->post['dashboard_customerstatus_sort_order'])) {
			$data['dashboard_customerstatus_sort_order'] = $this->request->post['dashboard_customerstatus_sort_order'];
		} else {
			$data['dashboard_customerstatus_sort_order'] = $this->config->get('dashboard_customerstatus_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/dashboard/customerstatus_form', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/analytics/google_analytics')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function dashboard() {
		$this->load->language('extension/dashboard/customerstatus');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['text_enable'] = $this->language->get('text_enable');
		$data['text_disable'] = $this->language->get('text_disable');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_image'] = $this->language->get('column_image');
		$data['column_property_status'] = $this->language->get('column_property_status');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_view'] = $this->language->get('column_view');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_edit'] = $this->language->get('button_edit');
		
		$data['token'] = $this->session->data['token'];
		$this->load->model('property/property');
		$this->load->model('tool/image');
		$this->load->model('property/property_status');
		$filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5
		);
		$url='';
		$results=$this->model_property_property->getPropertys($filter_data);
		foreach($results as $result){
			if (!$result['approved']) {
				$approve = $this->url->link('property/property/approve', 'token=' . $this->session->data['token'] . '&property_id=' . $result['property_id'] . $url, true);
			} else {
				$approve = '';
			}
			if ($result['status']){
				$status = $this->language->get('text_enable');
			} else {
				$status = $this->language->get('text_disable');
			}
			if (is_file(DIR_IMAGE . $result['image'])){
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
			$propertstatus_info=$this->model_property_property_status->getOrderStatus($result['property_status_id']);
			if(isset($propertstatus_info['name'])){
				$property_status=$propertstatus_info['name'];         
			} else {
				$property_status='';
			}
			$data['propertys'][]=array(
				'property_id'		=>$result['property_id'],
				'property_status' 	=>$property_status,
				'image' 			=> $image,
				'name'				=>$result['name'],
				'price'				=>$result['price'],
				'sort_order'		=>$result['sort_order'],
				'status'			=>$status,
				'approve'			=>$approve,
				'edit'				=> $this->url->link('property/property/edit', 'token=' . $this->session->	data['token'] . '&property_id=' .$result['property_id'] . $url, true)
			);
		}
		return $this->load->view('extension/dashboard/customerstatus_info', $data);
	}
	
}
