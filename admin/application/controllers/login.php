<?php 

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		
		//loading model
		$this->load->model('login_model','',TRUE);
		$this->layout->setLayout('layout_ajax');
	}
	public function index()
	{
		$this->layout->view('login/login');
	}
	public function checkLogin()
	{
		$sql = "SELECT	 staffID
						,userName
						,password
						,firstName
						,lastName
						,email
						,phone
						,isActive
						
				FROM	staff
				WHERE	1=1
				  AND isActive = 1
				  AND userName = ?
				  AND   password = ?
				"; 
		$query=$this->db->query($sql, array($_REQUEST['username'], $_REQUEST['password']));
		if ($query->num_rows() == 1)
		{
			$this->session->set_userdata("logged_in","True");
			$this->session->set_userdata("userdata",$query->row());
			redirect('reservation/index');
		}
		else {
			$data['invalidlogin'] = true;
			$this->layout->view('login/login', $data);
		}
	}
	public function logout()
	{
		$this->session->unset_userdata(array('logged_in' => '', 'userdata' => ''));
		$this->session->sess_destroy();
		redirect('login');
	}
}
