<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    private $user;

    public function __construct()
    {
        global $user;
        parent::__construct();
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
    }

    public function index()
    {
        global $user;
        $data['title'] = 'Dashboard';
        $data['user'] = $user;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
}
