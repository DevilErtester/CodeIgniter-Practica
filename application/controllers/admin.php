<?php  
    defined('BASEPATH') OR exit('No direct script access allowed');  
      
    class Admin extends CI_Controller {

        public function dashboard_controller()  
        {  
            if ($this->session->userdata('rol')==0)   
            {   
                $this->load->view('dashboard_admin');  
                
            }
            else{
                redirect('Admin/invalid');  
            }
        
        }  
        public function invalid()  
        {  
            $this->load->view('invalid');  
        } 
    }  
    ?>  