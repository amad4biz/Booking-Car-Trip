<?php 

class Autoemails extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="req">', '</div>');
		
		$this->load->library('session');
		$this->session->set_userdata("breadcrumb","Auto Emails");
		$this->session->set_userdata("menuItem","Auto Emails");
		//loading model
		$this->load->model('autoemail_model','',TRUE);
	}
	public function index(){
		$data['qryAutoEmails'] = $this->autoemail_model->get_autoemails();
		$this->layout->view('autoemail/autoemail_list',$data);
	}
	
	public function edit($autoEmailID = NULL) {		
		$data['autoEmailID']=$autoEmailID;
		$data['action']=site_url('autoemails/save/'. $autoEmailID);
		$data['autoEmailEvents']=$this->autoemail_model->get_autoEmailEvents(1);
		$data['qryPlaceholders'] = $this->autoemail_model->get_placeholders();		
		$this->_set_rules();
		if ($autoEmailID > 0) {
			// lets query db and get the data
			$data['title']="Edit Auto Email";
			$data['qryAutoEmail']=(array)$this->autoemail_model->get_autoemail($autoEmailID)->row();
		} else {
			$data['title']="New Auto Email";
			$data['qryAutoEmail']=array(
				'autoEmailID'	=> $autoEmailID,
				'autoEmailEventID' => '',
				'subject' => '',
				'ccEmail' => '',
				'bccEmail' => '',
				'textBody' => '',
				'htmlBody'	=> '',
				'isActive' => 1
			);
		}
		$this->layout->view('autoemail/form_autoemail', $data);
	}
	public function save($autoEmailID=null) {
		//$this->_set_fields();
		if ($autoEmailID > 0) {
			$data['title']="Edit Auto Email";
		} else {
			$data['title']="New Auto Email";
		}
		$data['action']=site_url('autoemail/save/'. $autoEmailID);
		$data['autoEmailEvents']=$this->autoemail_model->get_autoEmailEvents(1);		
		$data['qryPlaceholders'] = $this->autoemail_model->get_placeholders();
        $this->_set_rules();
		$autoEmail_info = array(
			'autoEmailID'	=> $autoEmailID,
			'autoEmailEventID' => $this->input->post('autoEmailEventID'),
			'subject' => $this->input->post('subject'),
			'ccEmail' => $this->input->post('ccEmail'),
			'bccEmail' => $this->input->post('bccEmail'),
			'textBody' => $this->input->post('textBody'),
			'htmlBody'	=> $this->input->post('htmlBody'),
			'isActive' => $this->input->post('isActive'),
		);
		$data['qryAutoEmail']=$autoEmail_info;
		
		$blnSuccess=$this->form_validation->run();
		
		$data['blnSuccess']=$blnSuccess;
		
		if ($blnSuccess){
			
			if ($autoEmailID > 0) {
				$this->autoemail_model->update_autoEmail($autoEmail_info);
			} else {
				$this->autoemail_model->insert_autoEmail($autoEmail_info);
			}
		}
		
		if ($blnSuccess) {
			redirect('autoemails/index/' . $autoEmailID);
		} else {
			$this->layout->view('autoemail/form_autoemail', $data);
		}
	}
	public function delete($autoEmailID = NULL) {
		$delete=$this->autoemail_model->delete_autoemail($autoEmailID);
		redirect('autoemails/index/' . $autoEmailID);
	}
	
	function _set_rules(){
		//Rules
		$fields = array(
			array(
            	'field'   => 'subject', 
                'label'   => 'subject', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'isActive', 
                'label'   => 'Active', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			)
		);
		$this->form_validation->set_rules($fields);
	}
}
