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
}