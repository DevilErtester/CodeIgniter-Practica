<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prof extends CI_Controller
{
    // ===========================================================================================================
    // ======================STANDARD==============================================================================
    // ===========================================================================================================

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
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
            redirect('Prof/printAlumnes');
        } else {
            redirect('Prof/invalid');
        }
    }


    public function invalid()
    {
        $this->load->view('invalid');
    }

    private function random_password()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890/#$%&';
        $password = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        return implode("", $password);
    }
    // ===========================================================================================================
    // ======================ALUMNES==============================================================================
    // ===========================================================================================================

    private function formAlu()
    {
        $this->load->library('form_validation');

        $formAlu = form_open('Prof/printAlumnes');
        $formAlu .= form_label('Email', 'mail');
        $formAlu .= form_input(['name' => 'mail']);
        $formAlu .= form_label('Nom', 'name');
        $formAlu .= form_input(['name' => 'nom']);
        $formAlu .= form_label('Telefon', 'telf');
        $formAlu .= form_input(['name' => 'telf']);
        $formAlu .= form_label('Curs FCT', 'cic_impar');
        $formAlu .= form_input(['name' => 'fct']);
        $formAlu .= form_submit('btnSubmit', 'Crear alumne');
        $formAlu .= form_close();

        $this->form_validation->set_rules('mail', 'Email', 'required|trim|xss_clean|is_unique[users.mail]');
        $this->form_validation->set_rules('nom', 'Nom', 'required|trim|xss_clean');
        $this->form_validation->set_rules('telf', 'Telefon', 'required|trim|xss_clean|is_unique[alumnes.telefon]');
        $this->form_validation->set_rules('fct', 'Curs FCT', 'required|trim|xss_clean');

        return $formAlu;
    }

    public function printAlumnes()
    {
        if (!$this->is_logged()) {
            $this->invalid();
        } else {
            $this->load->model('Alum_model');
            // load table library
            $this->load->library('table');
            // set table template
            $style = array('table_open'  => '<table class="table table-bordered table-hover">');
            $this->table->set_template($style);
            // set table heading
            $this->table->set_heading('idAlumne', 'Telefon', 'Curs FCT');

            $alumnes = $this->Alum_model->getAllAlumnes();

            $data['taula'] = $this->table->generate($alumnes);

            $data['form'] = $this->formAlu();
            $data['func'] = "index.php/Prof/Empresas";
            $data['funcName'] = "Empresas";

            if (isset($_POST['btnSubmit'])) {
                if ($this->form_validation->run()) {
                    $alum = array(
                        'mail' => $this->input->post('mail'),
                        'nom' => $this->input->post('nom'),
                        'curs_FCT' => $this->input->post('fct'),
                        'telf' => $this->input->post('telf')
                    );
                    $this->newAlu($alum);
                    redirect('Prof/printAlumnes');
                }
            }
            $this->load->view('prof_dashboard', $data);
        }
    }

    public function newAlu($alum)
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

    // ===========================================================================================================
    // ======================EMPRESAS=============================================================================
    // ===========================================================================================================

    public function Empresas()
    {
        if (!$this->is_logged()) {
            $this->invalid();
        } else {
            $this->load->model('Empresa_model');
            // load table library
            $this->load->library('table');
            // set table template
            $style = array('table_open'  => '<table class="table table-bordered table-hover">');
            $this->table->set_template($style);
            // set table heading
            $this->table->set_heading('ID Empresa', 'Nom', 'CIF', 'ID Persona', '');

            $empresas = $this->Empresa_model->getAll();

            $data['taula'] = $empresas;
            $data['form'] = null;
            $data['func'] = "index.php/Prof/printAlumnes";
            $data['funcName'] = "Alumnes";
            if (isset($_POST['btnSubmit'])) {
                if ($this->form_validation->run()) {

                    redirect('Prof/Empresas');
                }
            }
            $this->load->view('prof_empresa', $data);
        }
    }
}