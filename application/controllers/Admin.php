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
    public function newTutorForm()
    {
        if(!$this->is_logged()){
            $this->invalid();
            
        }else{
            echo form_open('Admin/newTutorForm');  
            echo validation_errors();  
        
            echo form_label('Email', 'mail');
            echo form_input(['name' => 'mail']);

            echo form_label('Nom', 'name');
            echo form_input(['name' => 'nom']);

            echo form_label('Cicle impartit', 'cic_impar');
            echo form_input(['name' => 'cic_impar']);
            
            echo form_submit('btnSubmit', 'Create new tutor');
            
            echo form_close();
        }
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