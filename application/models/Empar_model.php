<?php

class Empar_model extends CI_Model
{
	public function newEmpar($idAlu,$idEmp)
	{
		$date=new DateTime();
		
		$data = array(
			'Alumn' => $idAlu ,
			'Empresa' => $idEmp ,
			'dataInici' => $date->format('Y/m/d'),
			'dataFi' => $date->modify('+1 years')->format('Y/m/d')
		 );
		 
		 $this->db->insert('emparejamientos', $data); 
	}
}
