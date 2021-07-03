<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    private $user;

    public function __construct()
    {
        global $user;
        parent::__construct();
        restrictAccess();
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        $this->load->model('Admin_model', 'adminMod');
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

    public function role()
    {
        global $user;
        $data['title'] = 'Role';
        $data['user'] = $user;
        $data['role'] = $this->adminMod->getAllRole();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleaccess($id)
    {
        global $user;
        $data['title'] = 'Role Access';
        $data['user'] = $user;
        $data['specific_role'] = $this->adminMod->getRoleById($id);
        $data['menu'] = $this->adminMod->getAllMenu();
        $data['access'] = $this->adminMod->getAllAccess();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function change($roleId)
    {
        $menu = $this->adminMod->getAllMenu();
        $post = $this->input->post();

        $outerArr = [];
        foreach ($menu as $m) {
            $innerArr = $m;
            $innerArr['role_id'] = 0;
            
            foreach ($post as $k => $v) {
                if ($innerArr['role_id'] == 0 && $innerArr['name'] == $k) {
                    $innerArr['role_id'] = $roleId;
                    break;
                }
            }
            $outerArr[] = $innerArr;
        }
        
        foreach ($outerArr as $innerArr) {
            $this->adminMod->changeAccess($innerArr['id'], $roleId, $innerArr['role_id']);
        }
        $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Access has been changed!']);
        redirect('admin/roleAccess/'.$roleId);
    }
}
