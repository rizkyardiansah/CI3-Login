<?php 

class Auth extends CI_Controller {
    public function index() {
        $data['title'] = 'Login Page';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
        
    }
    
    public function registration() {
        $data['title'] = 'Registration Page';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/registration');
        $this->load->view('templates/auth_footer');
    }
}