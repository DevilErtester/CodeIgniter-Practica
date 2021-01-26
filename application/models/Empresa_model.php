<?php

class Empresa_model extends CI_Model
{
    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('empresa');

        $query = $this->db->get();

        return $query;
    }
    public function newEmp($emp)
    {
        $this->db->insert('empresa', $emp);
    }
}
