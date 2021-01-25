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
            $this->load->helper('security');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('mail', 'Email', 'required|trim|xss_clean');
            $this->form_validation->set_rules('nom', 'Nom', 'required|trim|xss_clean');
            $this->form_validation->set_rules('telf', 'Telefon', 'required|trim|xss_clean');
            $this->form_validation->set_rules('fct', 'Curs FCT', 'required|trim|xss_clean');
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

            if (isset($_POST['btnSubmit'])) {
                $this->newalu_action();
            }
        }
    }

    public function newalu_action()
    {
        if ($this->form_validation->run()) {
            $alum = array(
                'mail' => $this->input->post('mail'),
                'nom' => $this->input->post('nom'),
                'curs_FCT' => $this->input->post('fct'),
                'telf' => $this->input->post('telf')
            );
            $this->newTutor($alum);
        }
    }
    public function newTutor($alum)
    {
        if (!$this->is_logged()) {
            $this->invalid();
        } else {
            $this->load->model('Alum_model');
            $this->load->model('User_model');

            $user = array(
                'mail' => $alum['mail'],
                'pass' => $this->random_password(),
                'nom' => $alum['nom'],
                'rol' => '1'
            );

            $this->User_model->newUser($user);
            $idalum = $this->User_model->getIdUser($alum['mail']);

            $newAlu = array(
                'idAlumne' => $idalum,
                'curs_FCT' => $alum['curs_FCT'],
                'telefon' => $alum['telf']
            );

            $this->Alum_model->newAlum($newAlu);
            redirect('/Prof/printAlumnes');
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