<?php

class Alum_model extends CI_Model
{
    public function newAlum($alumnes)
    {
        $this->db->insert('alumnes', $alumnes);
    }
    public function getAllAlumnes()
    {
		$query = $this->db->select('users.nom,users.mail,alumnes.*,emparejamientos.id');
		$query = $this->db->join('emparejamientos', 'emparejamientos.Alumn = alumnes.idAlumne','left');
        $query = $this->db->join('users', 'users.userId = alumnes.idAlumne')->get('alumnes');
        $array = $query->result_array();
        return $array;
    }
    public function getAlumnesOrderBy($field)
    {
        $query = $this->db->select('users.nom,users.mail,alumnes.*,emparejamientos.id');
		$query = $this->db->order_by($field);
		$query = $this->db->join('emparejamientos', 'emparejamientos.Alumn = alumnes.idAlumne','left');
        $query = $this->db->join('users', 'users.userId = alumnes.idAlumne')->get('alumnes');
        return $query->result_array();
    }
    public function getAlumnesWhereLike($field, $search)
    {
        $query = $this->db->select('users.nom,users.mail,alumnes.*,emparejamientos.id');
		$query = $this->db->join('users', 'users.userId = alumnes.idAlumne');
		$query = $this->db->join('emparejamientos', 'emparejamientos.Alumn = alumnes.idAlumne','left');
        $query = $this->db->like($field, $search)->get('alumnes');
        return $query->result_array();
    }
    public function delAlu($idAlu)
    {
        $this->db->delete('alumnes', array('idAlumne' => $idAlu));
        $this->db->delete('users', array('userid' => $idAlu));
	}
	public function getAlu($idAlu)
	{
		$query = $this->db->select('users.nom,users.mail,alumnes.*');
		$query = $this->db->join('users', 'users.userId = alumnes.idAlumne');
		$query = $this->db->like('idAlumne',$idAlu)->get('alumnes');
        return $query->result_array();
	}
	public function getOnlyAlu($idAlu)
	{
		$query = $this->db->like('idAlumne',$idAlu)->get('alumnes');
        return $query->result_array();
	}
	public function updAlum($alum,$idAlu)
	{
		$this->db->where('idAlumne',$idAlu );
		$this->db->update('alumnes', $alum);
	}
}
