<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');
		$data['text_testimonial'] = $this->language->get('text_testimonial');
		
		
		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');
			

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_call'] = $this->language->get('text_call');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('agent/dashboard', '', true), $this->agent->getFirstName(), $this->url->link('agent/logout', '', true));
		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->agent->isLogged();
		
		$data['account'] = $this->url->link('agent/dashboard', '', true);
		$data['agentsignup'] = $this->url->link('agent/agentsignup', '', true);
		$data['login'] = $this->url->link('agent/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('agent/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['testimonial'] = $this->url->link('information/testimonial', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');
		
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
			
			if (isset($this->request->post['config_youtube'])) {
			$data['youtube'] = $this->request->post['config_youtube'];
			} else {
			$data['youtube'] = $this->config->get('config_youtube');
			}
			
			if (isset($this->request->post['config_blogger'])) {
			$data['blogger'] = $this->request->post['config_blogger'];
			} else {
			$data['blogger'] = $this->config->get('config_blogger');
			}

		
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['search1'] = $this->load->controller('common/search1');
		$data['cart'] = $this->load->controller('common/cart');
		
		// Mega header 
			$data['categories'] = array();
			$data['megaheaders'] = $this->load->controller('common/megaheader');
		// Mega header

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		$headerlayout = $this->config->get('tmdrealstate_header');
							
				if($headerlayout=='header1'){
					return $this->load->view('common/header_center', $data);
				} elseif($headerlayout=='header2'){
					return $this->load->view('common/header', $data);				
				} elseif($headerlayout=='header3'){
					return $this->load->view('common/header3', $data);
				} elseif($headerlayout=='header4'){
					return $this->load->view('common/header4', $data);
				} elseif($headerlayout=='header5'){
					return $this->load->view('common/header5', $data);							
				} else {				
					return $this->load->view('common/header', $data);			
				} 		
	}
}
