<?php

class Empresa_model extends CI_Model
{
    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('empresa');

        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
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


