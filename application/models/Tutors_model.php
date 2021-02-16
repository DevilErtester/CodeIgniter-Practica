<?php

class Tutors_model extends CI_Model
{
    public function newTutor($tutor)
    {
        $this->db->insert('tutores', $tutor);
    }
    public function getAllTutors()
    {
        $this->db->select('*');
        $this->db->from('tutores');
        $query = $this->db->get();
        return $query;
    }
    public function getAllCursos()
    {
        $query = $this->db->select('cicle_impar');
        $query = $this->db->get('tutores');
        return $query->result_array();
    }
	public function getOnlyAlu($idTutor)
	{
		$query = $this->db->like('idTutor',$idTutor)->get('tutores');
        return $query->result_array();
	}
}
