<?php

class User_model extends CI_Model
{
    public function newUser($user)
    {
        $this->db->insert('users', $user);
    }
    public function getIdUser($mail)
    {
        $query = $this->db->query('SELECT userid FROM users WHERE mail="'.$mail.'";');

        $row = $query->row_array();

        if (isset($row))
        {
                return $row['userid'];
        }
	}
	public function getUserByid($idUser)
	{

		$query = $this->db->like('userId',$idUser)->get('users');
        return $query->result_array();
	}
	public function updUser($user,$idUser)
    {
		$this->db->where('userId',$idUser );
        $this->db->update('users', $user);
    }
}
