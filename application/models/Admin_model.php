<?php

class Admin_model extends CI_Model
{
    public function getAllAlumnes()
    {
        $this->db->select('idAlumne,telefon,emparejamientos.id,anyCurs,idTutor,cicle_impar');
        $this->db->from('alumnes');
        $this->db->join('tutores', 'cicle_impar = curs', 'left');
        $this->db->join('emparejamientos', 'idAlumne = alumn', 'left');

        $query = $this->db->get();

        return $query;
    }
}