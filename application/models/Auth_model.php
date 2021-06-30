<?php

class Auth_model extends CI_Model
{
    public function insertDataRegistration()
    {
        $data = [
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'profile_img' => 'default.jpg',
            'is_active' => 1,
            'role_id' => 2
        ];

        $this->db->insert('user', $data);
    }
}
