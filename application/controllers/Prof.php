<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prof extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }
    public function is_logged()
    {
        if ($this->session->userdata('currently_logged_in') &&  $this->session->userdata('rol') == 2) {
            return true;
        } else {
            return false;
        }
    }

    public function dashboard_controller()
    {
        if ($this->session->userdata('currently_logged_in') &&  $this->session->userdata('rol') == 2) {

            $this->load->view('dashboard_admin');
            redirect('Prof/printAlumnes');
        } else {
            redirect('Prof/invalid');
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
        if (!$this->is_logged()) {
            $this->invalid();
        } else {
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
            $this->load->view('prof_dashboard', $data);
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
        return implode("", $password);
    }
}