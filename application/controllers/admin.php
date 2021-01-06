<?php  
    defined('BASEPATH') OR exit('No direct script access allowed');  
      
    class Admin extends CI_Controller {

        public function dashboard_controller()  
        {  
            if ($this->session->userdata('rol')==0)   
            {   
                $this->load->view('dashboard_admin');  
                redirect('Admin/printAlumnes');  
            }
            else{
                redirect('Admin/invalid');  
            }
        }
        public function index()  
        {  
            $this->printAlumnes();  
        }   
        public function invalid()  
        {  
            $this->load->view('invalid');  
        } 
        public function printAlumnes()  
        {  
            $this->load->model('admin_model');
            
            // load table library
            $this->load->library('table');
             // set table template
            $style = array('table_open'  => '<table class="table table-bordered table-hover">');
            $this->table->set_template($style);
            // set table heading
            $this->table->set_heading('idAlumne', 'Telefon', 'Curs FCT', 'TutorId','Cicle Impartit');

            $alumnes=$this->admin_model->getAllAlumnes();
            
            $data['alumnes'] = $this->table->generate($alumnes);
            $this->load->view('dashboard_admin',$data);
        } 
        
    }  
    ?>  