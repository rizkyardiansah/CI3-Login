<?php

function restrictAccess()
{
    $ci = get_instance();

    if (!$ci->session->userdata('email')) {
        redirect('auth/index');
        die;
    }

    $roleId = $ci->session->userdata('role_id'); //get the role id of the user
    $controller = $ci->uri->segment(1); //get the name of controller that user want to access

    $menuId = $ci->db->get_where('menu', ['name' => $controller])->row_array()['id']; //get the id of controller that user want to access

    $access = $ci->db->get_where('access', ['menu_id' => $menuId, 'role_id' => $roleId]); //check if the controller can be access by the user base on its role id

    if ($access->num_rows() < 1) {
        redirect('auth/blocked');
    }
}


