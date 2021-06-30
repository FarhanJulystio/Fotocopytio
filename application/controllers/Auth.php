<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index(){

		$this->load->view('admin/_template/auth_header');
		$this->load->view('auth/login');
		$this->load->view('admin/_template/auth_footer');
	}

	public function registration(){

		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
			'matches' => 'password dont match!', 'min_length' => 'password too short!']);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

		if ( $this->form_validation->run() == false){
			$this->load->view('admin/_template/auth_header');
			$this->load->view('auth/registration');
			$this->load->view('admin/_template/auth_footer');
		} else {
			$data = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'image' => 'default.jpg',
				'password' => password_hash( $this->input->post('password'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 1,
				'date_created' => time()
			];

			$this->db->insert('user', $data);
			redirect('auth');
		}

	}
}