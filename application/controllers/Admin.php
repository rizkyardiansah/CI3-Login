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

    public function addRole()
    {
        $this->form_validation->set_rules('name', 'Role Name', 'required|trim');
        if ($this->form_validation->run()) {
            $this->adminMod->addRole();
            $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Role succesfully added!']);
        } else {
            $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Role name is required']);
        }
        redirect('admin/role');
    }

    public function deleteRole($id)
    {
        $this->adminMod->deleteRoleById($id);
        $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Role succesfully deleted!']);
        redirect('admin/role');
    }

    public function getRoleById()
    {
        echo json_encode($this->adminMod->getRoleById($this->input->post('id')));
    }

    public function editRole()
    {
        $this->adminMod->updateRole();
        $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Role has been updated!']);
        redirect('admin/role');
    }


    public function roleaccess($id)
    {
        global $user;
        $data['title'] = 'Role Access';
        $data['user'] = $user;
        $data['specific_role'] = $this->adminMod->getRoleById($id);
        $data['menu'] = $this->adminMod->getAllMenu();
        $data['access'] = $this->adminMod->getAllAccess();

        if ($this->input->post('submit') == "on") {
            $this->adminMod->changeAccess($id);
            $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Access has been changed!']);
            redirect('admin/roleAccess/' . $id);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }
}
