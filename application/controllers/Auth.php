<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_model', 'authMod');
    }

    public function index()
    {
        $data['title'] = 'Login Page';

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        //apabila lolos validasi
        if ($this->form_validation->run()) {
            $this->userLogin();
        } else { // jika tidak lolos validasi
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }
    }

    private function userLogin()
    {
        $userData = $this->authMod->getUserData();
        $inputPassword = $this->input->post('password');

        //apakah email terdaftar
        if ($userData) {
            //apakah email sudah teraktivasi
            if ($userData['is_active'] == 1) {
                //apakah email dan password sesuai dengan yang ada di database
                if (password_verify($inputPassword, $userData['password'])) {
                    $this->session->set_userdata(['email' => $userData['email'], 'role_id' => $userData['role_id']]);
                    if ($userData['role_id'] == 1) {
                        redirect('admin/index');
                    } else if ($userData['role_id'] == 2) {
                        redirect('user/index');
                    }
                } else {
                    $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your password is wrong!']);
                }
            } else {
                $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your account has not been activated!']);
            }
        } else {
            $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your account is not registered!']);
        }

        redirect('auth/index');
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
            $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Registration success!']);
            redirect('auth/index');
        } else {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Logout success!']);
        redirect('auth/index');
    }

    public function blocked() {
        $this->load->view('auth/blocked');
    }
}
