<?php

class Empresa_model extends CI_Model
{
    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('empresa');

        $query = $this->db->get();
        $array = $query->result_array();
        return $array;
    }
    public function newEmp($emp)
    {
        $this->db->insert('empresa', $emp);
    }
    public function delEmp($idEmp)
    {
        $this->db->delete('empresa', array('idEmpresa' => $idEmp));
    }
}