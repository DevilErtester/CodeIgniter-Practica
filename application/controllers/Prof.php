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
    public function printAlumnes()
    {
        if (!$this->is_logged()) {
            $this->invalid();
        } else {
            $this->load->model('Alum_model');
      

            $alumnes = $this->Alum_model->getAllAlumnes();

            $data['taula'] = $alumnes;

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

    public function delAlu($idAlu)
    {
        $this->load->model('Alum_model');
        $this->Alum_model->delAlu($idAlu);
        redirect('/Prof/printAlumnes');
    }
    
    public function editAlu($idAlu)
    {
        
        redirect('/Prof/printAlumnes');
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

            $empresas = $this->Empresa_model->getAll();

            $data['taula'] = $empresas;
            $data['form'] = $this->formEmp();
            $data['func'] = "index.php/Prof/printAlumnes";
            $data['funcName'] = "Alumnes";

            if (isset($_POST['btnSubmit'])) {
                if ($this->form_validation->run()) {
                    $empresa = array(
                        'nom' => $this->input->post('nom'),
                        'CIF' => $this->input->post('cif'),
                        'idPersona' => $this->input->post('idPers')
                    );
                    $this->Empresa_model->newEmp($empresa);
                    redirect('Prof/Empresas');
                }
            }
            $this->load->view('prof_empresa', $data);
        }
    }

    public function formEmp()
    {
        $this->load->library('form_validation');

        $formEmp = form_open('Prof/Empresas');
        $formEmp .= form_label('Nom Empresa', 'nom');
        $formEmp .= form_input(['name' => 'nom']);
        $formEmp .= form_label('CIF', 'CIF');
        $formEmp .= form_input(['name' => 'cif']);
        $formEmp .= form_label('Persona contacte', 'idPers');
        $formEmp .= form_input(['name' => 'idPers']);
        $formEmp .= form_submit('btnSubmit', 'Crear Empresa');
        $formEmp .= form_close();

        $this->form_validation->set_rules('nom', 'Nom Empresa', 'required|trim|xss_clean');
        $this->form_validation->set_rules('cif', 'CIF', 'required|trim|xss_clean|is_unique[empresa.cif]');
        $this->form_validation->set_rules('idPers', 'Persona contacte', 'required|trim|xss_clean');

        return $formEmp;
    }
    public function deleteEmp($idEmp)
    {
        $this->load->model('Empresa_model');
        $this->Empresa_model->delEmp($idEmp);
        redirect('/Prof/Empresas');
    }
    public function editEmp($idEmp)
    {
        //In need to learn how to do modifications
        redirect('/Prof/Empresas');
    }
}