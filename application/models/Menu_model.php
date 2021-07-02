<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getAllMenu()
    {
        return $this->db->get('menu')->result_array();
    }

    public function addNewMenu()
    {
        $this->db->insert('menu', ['name' => htmlspecialchars($this->input->post('name', true))]);
    }

    public function deleteMenuById($id)
    {
        $this->db->delete('menu', ['id' => $id]);
    }

    public function getAllSubmenu()
    {
        $query = "SELECT `submenu`.*, `menu`.`name` AS `menuName`
                    FROM `submenu` JOIN `menu`
                    ON `submenu`.`menu_id` = `menu`.`id`";
        return $this->db->query($query)->result_array();
    }

    public function addNewSubmenu()
    {
        $data = [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'menu_id' => $this->input->post('menu_id'),
            'icon' => htmlspecialchars($this->input->post('icon', true)),
            'url' => htmlspecialchars($this->input->post('url', true)),
            'is_active' => $this->input->post('is_active') == 1 ? 1 : 0
        ];

        $this->db->insert('submenu', $data);
    }
}
