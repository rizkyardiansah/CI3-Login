<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    private $user;

    public function __construct()
    {
        global $user;
        parent::__construct();
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        $this->load->model('Menu_model', 'menuMod');
    }

    public function index()
    {
        global $user;

        $data['title'] = 'Menu Management';
        $data['user'] = $user;
        $data['menu'] = $this->menuMod->getAllMenu();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('templates/footer');
    }

    public function addMenu()
    {
        global $user;

        $data['title'] = 'Menu Management';
        $data['user'] = $user;
        $data['menu'] = $this->menuMod->getAllMenu();

        $this->form_validation->set_rules('name', 'Menu name', 'required');

        if ($this->form_validation->run()) {
            $this->menuMod->addNewMenu();
            $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Menu succesfully added!']);
            redirect('menu/index');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function deleteMenu($id)
    {
        $this->menuMod->deleteMenuById($id);
        $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Menu succesfully deleted!']);
        redirect('menu/index');
    }

    public function submenu()
    {
        global $user;

        $data['title'] = 'Submenu Management';
        $data['user'] = $user;
        $data['submenu'] = $this->menuMod->getAllSubmenu();
        $data['menu'] = $this->menuMod->getAllMenu();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/submenu', $data);
        $this->load->view('templates/footer');
    }

    public function addSubmenu()
    {
        global $user;

        $data['title'] = 'Submenu Management';
        $data['user'] = $user;
        $data['submenu'] = $this->menuMod->getAllSubmenu();
        $data['menu'] = $this->menuMod->getAllMenu();

        $this->form_validation->set_rules('name', 'Submenu name', 'required');
        $this->form_validation->set_rules('menu_id', 'Select Menu', 'required|greater_than[0]', [
            'greater_than[0]' => 'Menu option is not selected!'
        ]);
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');

        if ($this->form_validation->run()) {
            $this->menuMod->addNewSubmenu();
            $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Submenu succesfully added!']);
            redirect('menu/submenu');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        }
    }
}
