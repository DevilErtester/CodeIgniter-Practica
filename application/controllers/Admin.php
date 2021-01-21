<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }
    public function is_logged(){
        if ($this->session->userdata('currently_logged_in') &&  $this->session->userdata('rol') == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function dashboard_controller()
    {
        if ($this->session->userdata('currently_logged_in') &&  $this->session->userdata('rol') == 0) {

            $this->load->view('dashboard_admin');
            redirect('Admin/printAlumnes');
        } else {
            redirect('Admin/invalid');
        }
    }
    public function index()
    {
        $this->dashboard_controller();
        $this->printAlumnes();
        
    }


    public function invalid()
    {
        $this->load->view('invalid');
    }


    public function printAlumnes()
    {
        if(!$this->is_logged()){
            $this->invalid();
            
        }else{
            $this->load->model('admin_model');

            // load table library
            $this->load->library('table');
            // set table template
            $style = array('table_open'  => '<table class="table table-bordered table-hover">');
            $this->table->set_template($style);
            // set table heading
            $this->table->set_heading('idAlumne', 'Telefon', 'Curs FCT', 'TutorId', 'Cicle Impartit');

            $alumnes = $this->admin_model->getAllAlumnes();

            $data['alumnes'] = $this->table->generate($alumnes);
            $this->load->view('dashboard_admin', $data);
            
        }
    }
    
    public function printTutores()
    {
        if(!$this->is_logged()){
            $this->invalid();
            
        }else{
            $this->load->model('Tutors_model');

            // load table library
            $this->load->library('table');
            // set table template
            $style = array('table_open'  => '<table class=" w5 table table-bordered table-hover">');
            $this->table->set_template($style);
            // set table heading
            $this->table->set_heading('idTutor', 'Cicle impartit');

            $tutors = $this->Tutors_model->getAllTutors();

            $data['tutors'] = $this->table->generate($tutors);
            $this->load->view('tutorsList', $data);
            if (isset($_POST['btnSubmit'])) {
                $tutor = array (
                    'mail' => $this->input->post ('mail'),
                    'nom' => $this->input->post ('nom'),
                    'cicle_impar' => $this->input->post ('cic_impar'),
                );
                $this->newTutor($tutor);
                
            }
        }
    }

    private function random_password()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890/#$%&';
        $password = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        return implode("",$password);
    }
    

    public function newTutor($tutor)
    {
        if(!$this->is_logged()){
            $this->invalid();
            
        }else{
        $this->load->model('Tutors_model');
        $this->load->model('User_model');

        $user = array(
            'mail' => $tutor['mail'],
            'pass' => $this->random_password(),
            'nom' => $tutor['nom'],
            'rol' => '2'
        );

        $this->User_model->newUser($user);
        $idTutor = $this->User_model->getIdUser($tutor['mail']);

        $newTutor = array(
            'idTutor' => $idTutor,
            'cicle_impar' => $tutor['cicle_impar']
        );

        $this->Tutors_model->newTutor($newTutor);
        redirect('/Admin/printTutores');
    }
    }
    //new tutor testing model
    // -------------------------------------------------
    // public function newTutortest()
    // {
    //     $this->load->model('Tutors_model');
    //     $this->load->model('User_model');

    //     $user = array(
    //         'mail' => 'test2',
    //         'pass' => $this->random_password(),
    //         'nom' =>'test',
    //         'rol' => '2'
    //     );

    //     $this->User_model->newUser($user);
    //     $idTutor = $this->User_model->getIdUser('test2');
       
    //     $newTutor = array(
    //         'idTutor' => $idTutor,
    //         'cicle_impar' => 'test'
    //     );

    //     $this->Tutors_model->newTutor($newTutor);
    // }
}