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

    public function changeAccess($menuId, $oldRoleId, $newRoleId)
    {
        $totalResult = $this->db->get_where('access', ['menu_id' => $menuId, 'role_id' => $oldRoleId])->num_rows();

        //return $totalResult;

        if ($newRoleId > 0 && $totalResult < 1) {
            $this->db->insert('access', ['role_id' => $oldRoleId, 'menu_id' => $menuId]);
            return $menuId . $newRoleId . ' inserted';
            die;
        }

        if ($newRoleId == 0 && $totalResult > 0) {
            $this->db->delete('access', ['role_id' => $oldRoleId, 'menu_id' => $menuId]);
            return $menuId . $newRoleId . ' deleted';
            die;
        }
    }
}
