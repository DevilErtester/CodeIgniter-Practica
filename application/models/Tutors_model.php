<?php

class Tutors_model extends CI_Model
{
    public function newTutor($tutor)
    {
        $this->db->insert('tutores', $tutor);
    }
}