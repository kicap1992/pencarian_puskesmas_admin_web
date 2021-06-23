<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model');
		$this->load->model('m_tabel_ss');
	}
	
	function index()
	{
		if ($this->input->post('proses') == 'login') {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if ($username == 'admin' and $password == 'admin') {
				$this->session->set_userdata('level', 'admin');
				$array = array('ket' => 1);
			}else{
				$array = array('ket' => 0);
			}
			print_r(json_encode($array));
		}

		else{
			$this->session->unset_userdata('level');
			$this->load->view('login/login');
		}
		
	}


	
}
?>