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
    // ===========================================================================================================
    // ======================GRUP ALUMNES=========================================================================
    // ===========================================================================================================
    public function importCsv()
    {
        if (!$this->is_logged()) {
            $this->invalid();
        } else {
            $this->load->model('Alum_model');


            $alumnes = $this->Alum_model->getAllAlumnes();

            $data['taula'] = $alumnes;
            // $data['form'] = $this->formAluCSV();

            if (isset($_POST['submit'])) {

                $alumnescsv = $this->uploadData();

                foreach ($alumnescsv as $alumne) {
                    $this->newAlu($alumne);
                }
                redirect('Prof/importCSV');
            }
            $this->load->view('prof_importcsv', $data);
        }
    }
    function uploadData()
    {
        $i = 0;
        $count = 0;
        $fp = fopen($_FILES['userfile']['tmp_name'], 'r') or die("can't open file");
        while ($csv_line = fgetcsv($fp, 1024)) {
            $count++;
            if ($count == 1) {
                continue;
            } //keep this if condition if you want to remove the first row

            $insert_csv = array();
            $insert_csv['mail'] = $csv_line[0];
            $insert_csv['nom'] = $csv_line[1];
            $insert_csv['telf'] = $csv_line[2];
            $insert_csv['curs_FCT'] = $csv_line[3];

            $data[$i] = array(
                'mail' => $insert_csv['mail'],
                'nom' => $insert_csv['nom'],
                'telf' => $insert_csv['telf'],
                'curs_FCT' => $insert_csv['curs_FCT']
            );
            $i++;
        }
        fclose($fp) or die("can't close file");
        return $data;
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
        $this->form_validation->set_rules('CSV', 'CSV File', 'required|trim|xss_clean');

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
    public function upload_file()
    {
		$csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
	    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
	        if(is_uploaded_file($_FILES['file']['tmp_name'])){
	            
	            //open uploaded csv file with read only mode
	            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
	            
	            // skip first line
	            // if your csv file have no heading, just comment the next line
	            fgetcsv($csvFile);
	            
	            //parse data from csv file line by line
	            while(($line = fgetcsv($csvFile)) !== FALSE){
	                //check whether member already exists in database with same email
	                $result = $this->db->get_where("member", array("email"=>$line[1]))->result();
	                if(count($result) > 0){
	                    //update member data
	                    $this->db->update("member", array("name"=>$line[0], "phone"=>$line[2], "created"=>$line[3], "status"=>$line[4]), array("email"=>$line[1]));
	                }else{
	                    //insert member data into database
	                    $this->db->insert("member", array("name"=>$line[0], "email"=>$line[1], "phone"=>$line[2], "created"=>$line[3], "status"=>$line[4]));
	                }
	            }
	            
	            //close opened csv file
	            fclose($csvFile);

	            $qstring["status"] = 'Success';
	        }else{
	            $qstring["status"] = 'Error';
	        }
	    }else{
	        $qstring["status"] = 'Invalid file';
	    }
	    $this->load->view('csvToMySQL',$qstring);
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