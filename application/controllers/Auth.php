<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //get the method that user want to access
        $method = $this->uri->segment(2);

        //if user still loged in and want to access auth controller (except logout method)
        //redirect user to its profile page
        if (!$method == 'logout' && $this->session->userdata('email')) {
            redirect('user/index');
        }

        $this->load->library('form_validation');
        $this->load->model('Auth_model', 'authMod');
    }

    public function index()
    {
        $data['title'] = 'Login Page';

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        //apabila lolos validasi
        if ($this->form_validation->run()) {
            $this->authMod->userLogin();
        } else { // jika tidak lolos validasi
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }
    }

    public function registration()
    {
        $data['title'] = 'Registration Page';

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|alpha_dash|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run()) {
            $this->authMod->insertDataRegistration();
            $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Registration success! Please activate your accont!']);
            redirect('auth/index');
        } else {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $this->authMod->verifyAccount($email, urldecode($token));
        redirect('auth/index');
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Logout success!']);
        redirect('auth/index');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
