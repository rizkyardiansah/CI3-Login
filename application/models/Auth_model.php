<?php

class Auth_model extends CI_Model
{
    public function insertDataRegistration()
    {
        $data = [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'profile_img' => 'default.jpg',
            'is_active' => 1,
            'role_id' => 2,
            'date_created' => time()
        ];

        $this->db->insert('user', $data);
    }

    public function getUserData()
    {
        $email = htmlspecialchars($this->input->post('email', true));

        return $this->db->get_where('user', ['email' => $email])->row_array();
    }

    public function getUserMenu() {
        $userRole = $this->session->userdata('role');

        $query = "SELECT `menu`.`id`, `menu`.`name`
                    FROM `menu` JOIN `access`
                    ON `menu`.`id` = `access`.`menu_id`
                    WHERE `access`.`role_id` = $userRole
                    ";

        $result = $this->db->query($query)->result_array();
        return $result;
    }
}
