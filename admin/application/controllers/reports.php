<?php 

class Reports extends MY_Controller {

	public function index()
	{
		$this->load->library('session');
		$this->session->set_userdata("breadcrumb","Reports");
		$this->session->set_userdata("menuItem","Reports");
		$this->layout->view('reports');
	}
}
