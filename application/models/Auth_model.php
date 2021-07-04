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
            'is_active' => 0,
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

    public function getUserMenu()
    {
        $userRole = $this->session->userdata('role');

        $query = "SELECT `menu`.`id`, `menu`.`name`
                    FROM `menu` JOIN `access`
                    ON `menu`.`id` = `access`.`menu_id`
                    WHERE `access`.`role_id` = $userRole
                    ";

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function userLogin()
    {
        $userData = $this->getUserData();
        $inputPassword = $this->input->post('password');

        //apakah email terdaftar
        if ($userData) {
            //apakah email sudah teraktivasi
            if ($userData['is_active'] == 1) {
                //apakah email dan password sesuai dengan yang ada di database
                if (password_verify($inputPassword, $userData['password'])) {
                    $this->session->set_userdata(['email' => $userData['email'], 'role_id' => $userData['role_id']]);
                    if ($userData['role_id'] == 1) {
                        redirect('admin/index');
                    } else if ($userData['role_id'] == 2) {
                        redirect('user/index');
                    }
                } else {
                    $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your password is wrong!']);
                }
            } else {
                $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your account has not been activated!']);
            }
        } else {
            $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your account is not registered!']);
        }

        redirect('auth/index');
    }

    public function sendEmail($type)
    {
        $email = $this->input->post('email');
        $token = base64_encode(random_bytes(32));


        $data = [
            'email' => $email,
            'token' => $token,
            'date_created' => time()
        ];

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'ci3emailsender@gmail.com',
            'smtp_pass' => 'salah021',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('ci3emailsender@gmail.com', 'CI3 Email Sender');
        $this->email->to($email);

        if ($type == 'verify') {
            //send email
            $this->email->subject('Account Activation');
            $this->email->message('Click this link to activate your account: <a href="' . base_url('auth/verify') . '?email=' . $email . '&token=' . urlencode($token) . '">Activate</a>');

            //insert data to table activation
            $this->db->insert('activation', $data);
        } else if ($type == 'forgot_password') {
            //send email
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password: <a href="' . base_url('auth/resetpassword') . '?email=' . $email . '&token=' . urlencode($token) . '">Reset Password</a>');

            //insert data to table forgot_password
            $this->db->insert('forgot_password', $data);
        }

        $this->email->send();
    }

    public function verifyAccount($email, $token)
    {
        $userData = $this->db->get_where('activation', ['email' => $email])->row_array();

        if ($userData) {
            if ($userData['token'] == $token) {
                if (time() - $userData['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('activation', ['email' => $email]);
                    $this->session->set_flashdata('flash', ['type' => 'success', 'text' => 'Your account is activated!']);
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('activation', ['email' => $email]);
                    $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your token is expired!']);
                }
            } else {
                $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your token is invalid!']);
            }
        } else {
            $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your email is wrong!']);
        }
    }


    public function verifyPassword($email, $token)
    {
        $forPassData = $this->db->get_where('forgot_password', ['email' => $email])->row_array();
        $userData = $this->db->get_where('user', ['email' => $email])->row_array();

        if (!$forPassData || !$userData) {
            $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your email is wrong!']);
            redirect('auth/forgotpassword');
        } else {
            if ($userData['is_active'] == 0) {
                $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your account is not activated!']);
                redirect('auth/forgotpassword');
            } else {
                if ($forPassData['token'] != $token) {
                    $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your token is invalid!']);
                    redirect('auth/forgotpassword');
                } else {
                    if (time() - $forPassData['date_created'] > (60 * 60 * 24)) {
                        $this->db->delete('forgot_password', ['email' => $email]);
                        $this->session->set_flashdata('flash', ['type' => 'danger', 'text' => 'Your token is expired!']);
                        redirect('auth/forgotpassword');
                    }
                }
            }
        }

    }
}
