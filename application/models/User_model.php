<?php

class User_model extends CI_Model
{
    public function newUser($user)
    {
        $this->db->insert('users', $user);
    }
    public function getIdUser($mail)
    {
        $this->db->select('userid');
        $this->db->from('users');
        $this->db->where('mail', $mail);

        $query = $this->db->get();
        return $query;
    }
}
