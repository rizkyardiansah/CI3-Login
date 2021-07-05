<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function getAllRole()
    {
        return $this->db->get('role')->result_array();
    }

    public function getAllMenu()
    {
        return $this->db->get_where('menu', ['name !=' => 'Admin'])->result_array();
    }

    public function getAccessByRole($roleId)
    {
        return $this->db->get_where('access', ['role_id' => $roleId])->result_array();
    }

    public function getAllAccess()
    {
        return $this->db->get('access')->result_array();
    }

    public function getRoleById($id)
    {
        return $this->db->get_where('role', ['id' => $id])->row_array();
    }

    public function addRole()
    {
        $roleName = htmlspecialchars($this->input->post('name', true));
        $this->db->insert('role', ['role' => $roleName]);
    }

    public function updateRole() {
        $roleId = $this->input->post('id');
        $roleName = $this->input->post('name');

        $this->db->set('role', $roleName);
        $this->db->where('id', $roleId);
        $this->db->update('role');
    }

    public function deleteRoleById($id) {
        $this->db->delete('role', ['id' => $id]);
    }

    public function changeAccess($roleId)
    {
        $menu = $this->getAllMenu();
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
            $menuId = $innerArr['id'];
            $oldRoleId = $roleId;
            $newRoleId = $innerArr['role_id'];

            $totalResult = $this->db->get_where('access', ['menu_id' => $menuId, 'role_id' => $oldRoleId])->num_rows();


            if ($newRoleId > 0 && $totalResult < 1) {
                $this->db->insert('access', ['role_id' => $oldRoleId, 'menu_id' => $menuId]);
            } else if ($newRoleId == 0 && $totalResult > 0) {
                $this->db->delete('access', ['role_id' => $oldRoleId, 'menu_id' => $menuId]);
            }
        }
    }
}
