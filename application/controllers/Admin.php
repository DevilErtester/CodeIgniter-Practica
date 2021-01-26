<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // ===========================================================================================================
    // ======================STANDARD==============================================================================
    // ===========================================================================================================

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }
    public function is_logged()
    {
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
    // ===========================================================================================================
    // ======================ALUMNES==============================================================================
    // ===========================================================================================================

    //prints alumens page asociating given info into $data asociative array

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

            $data['taula'] = $this->table->generate($alumnes);
            $data['form'] = null;
            $data['func'] = "index.php/Admin/printTutores";
            $data['funcName'] = "Tutores";
            $this->load->view('admin_dashboard', $data);
        }
    }
    //returns tutors form
    private function formTut()
    {
        $formTut = form_open('Admin/printTutores');
        $formTut .= validation_errors();

        $formTut .= form_label('Email', 'mail');
        $formTut .= form_input(['name' => 'mail']);

        $formTut .= form_label('Nom', 'name');
        $formTut .= form_input(['name' => 'nom']);

        $formTut .= form_label('Cicle impartit', 'cic_impar');
        $formTut .= form_input(['name' => 'cic_impar']);

        $formTut .= form_submit('btnSubmit', 'Create new tutor');

        $formTut .= form_close();
        return $formTut;
    }
    // ===========================================================================================================
    // ======================TUTORES==============================================================================
    // ===========================================================================================================

    //prints tutores page asociating given info into $data asociative array
    public function printTutores()
    {
        if (!$this->is_logged()) {
            $this->invalid();
        } else {
            $this->load->model('Tutors_model');
            $this->load->helper('security');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('mail', 'Email:', 'required|trim|xss_clean');
            $this->form_validation->set_rules('nom', 'Nom:', 'required|trim|xss_clean');
            $this->form_validation->set_rules(
                'cic_impar',
                'Cicle impartit:',
                'required|trim|xss_clean'
            );
            // load table library
            $this->load->library('table');
            // set table template
            $style = array('table_open'  => '<table class=" w5 table table-bordered table-hover">');
            $this->table->set_template($style);
            // set table heading
            $this->table->set_heading('idTutor', 'Cicle impartit');

            $tutors = $this->Tutors_model->getAllTutors();

            $data['taula'] = $this->table->generate($tutors);

            $data['form'] = $this->formTut();
            $data['func'] = "index.php/Admin/printAlumnes";
            $data['funcName'] = "Alumnes";
            $this->load->view('admin_dashboard', $data);
            if (isset($_POST['btnSubmit'])) {
                $this->newtutor_action();
            }
        }
    }
    // validates the form when trying to create a new tutor
    public function newtutor_action()
    {
        if ($this->form_validation->run()) {
            $tutor = array(
                'mail' => $this->input->post('mail'),
                'nom' => $this->input->post('nom'),
                'cicle_impar' => $this->input->post('cic_impar'),
            );
            $this->newTutor($tutor);
        }
    }
    // creates a new tutor given an asociative array
    public function newTutor($tutor)
    {
        if (!$this->is_logged()) {
            $this->invalid();
        } else {
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
    //generates a random password using given alphabet
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