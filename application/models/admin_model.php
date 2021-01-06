<?php  
  
class Admin_model extends CI_Model {  
    public function getAllAlumnes(){
        $this->db->select('*');
        $this->db->from('alumnes');
        $this->db->join('tutores', 'cicle_impar = curs_FCT','left');

        $query = $this->db->get();
        
        return $query;
    }
    
}  
?>