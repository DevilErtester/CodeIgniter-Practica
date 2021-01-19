<?php

class Login_model extends CI_Model
{

    public function log_in_correctly()
    {

        $this->db->where('mail', $this->input->post('username'));
        $this->db->where('pass', $this->input->post('password'));
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $row = $query->row();
            $_POST['rol'] = $row->rol;
            return true;
        } else {
            return false;
        }
    }
}
