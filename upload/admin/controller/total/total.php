<?php
class ControllerTotalTotal extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('total/total');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('total', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->ssl('extension/total', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

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
			'href' => $this->url->ssl('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->ssl('extension/total', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->ssl('total/total', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->ssl('total/total', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->ssl('extension/total', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['total_status'])) {
			$data['total_status'] = $this->request->post['total_status'];
		} else {
			$data['total_status'] = $this->config->get('total_status');
		}

		if (isset($this->request->post['total_sort_order'])) {
			$data['total_sort_order'] = $this->request->post['total_sort_order'];
		} else {
			$data['total_sort_order'] = $this->config->get('total_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('total/total', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/total')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}