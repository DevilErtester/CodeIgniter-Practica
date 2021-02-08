<?php

class Alum_model extends CI_Model
{
    public function newAlum($alumnes)
    {
        $this->db->insert('alumnes', $alumnes);
    }
    public function getAllAlumnes()
    {
        $this->db->select('*');
        $this->db->from('alumnes');


        $query = $this->db->get();

        $array = $query->result_array();
        return $array;
	}
	public function getAlumnesOrderBy($field)
	{
		$query = $this->db->order_by($field)->get('alumnes');
		return $query->result_array();
	}
	public function getAlumnesWhereLike($field, $search)
	{
		$query = $this->db->like($field, $search)->get('alumnes');
		return $query->result_array();
	}
    public function delAlu($idAlu)
    {
        $this->db->delete('alumnes', array('idAlumne' => $idAlu));
        $this->db->delete('users', array('userid' => $idAlu));
    }
}
