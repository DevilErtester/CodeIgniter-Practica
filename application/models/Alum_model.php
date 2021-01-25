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

        return $query;
    }
}