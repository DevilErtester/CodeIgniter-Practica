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
    private function random_password()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890/#$%&';
        $password = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        return implode($password);
    }
    public function newTutor($tutor)
    {
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