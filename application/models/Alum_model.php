<?php

class Alum_model extends CI_Model
{
    public function newAlum($alumnes)
    {
        $this->db->insert('alumnes', $alumnes);
    }
}
