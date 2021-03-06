<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $user;

    public function __construct()
    {
        global $user;
        parent::__construct();
        restrictAccess();
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
    }

    public function index()
    {
        global $user;

        $data['title'] = 'My Profile';
        $data['user'] = $user;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        global $user;

        $data['title'] = 'Edit Profile';
        $data['user'] = $user;

        $this->form_validation->set_rules('name', 'Name', 'required|trim');

        if ($this->form_validation->run()) {
            $uploadFile = $_FILES['profile_img']['name'];

            if ($uploadFile) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['upload_path'] = './assets/img/profile/';
                $config['max_size'] = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('profile_img')) {
                    $imgName = $this->upload->data('file_name');
                    $this->db->set('profile_img', $imgName);

                    if ($user['profile_img'] != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $user['profile_img']);
                    }
                } else {
                    echo $this->upload->display_errors();
                }
            }
            $email = $this->input->post('email');
            $name = $this->input->post('name');

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            redirect('user/index');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        }
    }

    public function changePassword()
    {
        global $user;
        $data['title'] = "Change Password";
        $data['user'] = $user;

        $this->form_validation->set_rules('currentpassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('newpassword1', 'New Password', 'required|trim|min_length[3]|matches[newpassword2]');
        $this->form_validation->set_rules('newpassword2', 'Repeat New Password', 'required|trim|min_length[3]|matches[newpassword1]');

        if ($this->form_validation->run()) {
            $currPass = $this->input->post('currentpassword');
            $newPass = $this->input->post('newpassword1');

            if (password_verify($currPass, $user['password'])) {
                if ($currPass != $newPass) {
                    $this->db->set('password', password_hash($newPass, PASSWORD_DEFAULT));
                    $this->db->where('email', $user['email']);
                    $this->db->update('user');

                    redirect('user/index');
                } else {
                    redirect('user/changePassword');
                }
            } else {
                redirect('user/changePassword');
            }
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changePassword', $data);
            $this->load->view('templates/footer');
        }
    }
}
