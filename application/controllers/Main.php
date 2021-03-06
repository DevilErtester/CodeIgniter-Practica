<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }
    public function index()
    {
        redirect('Main/login');
    }

    public function login()
    {
        $this->load->view('login_view');
    }

    public function signin()
    {
        $this->load->view('signin');
    }

    public function data()
    {
        if ($this->session->userdata('currently_logged_in')) {
            if ($this->session->userdata('rol') == 1) {
				redirect('User/dashboard_controller');
            } else if ($this->session->userdata('rol') == 2) {
                redirect('Prof/dashboard_controller');
            } else if ($this->session->userdata('rol') == 0) {
                redirect('Admin/dashboard_controller');
            }
        } else {
            redirect('Main/invalid');
        }
    }

    public function invalid()
    {
        $this->load->view('invalid');
    }
    // accion para iniciar session en la pagina vez una vez el usuario es valido
    public function login_action()
    {
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username:', 'required|trim|xss_clean|callback_validation');
        $this->form_validation->set_rules('password', 'Password:', 'required|trim');

        if ($this->form_validation->run()) {
			$id=$this->login_model->log_in_correctly();
            $data = array(
				
                'username' => $this->input->post('username'),
                'rol' => $this->input->post('rol'),
                'currently_logged_in' => 1,
				'userId'=> $id
            );
            $this->session->set_userdata($data);
            redirect('Main/data');
        } else {
            $this->load->view('login_view');
        }
    }
    // Validacion del formulario para crear nuevos users
    public function signin_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|is_unique[signup.username]');

        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');

        $this->form_validation->set_message('is_unique', 'username already exists');

        if ($this->form_validation->run()) {
            echo "Welcome, you are logged in.";
        } else {
            $this->load->view('signin');
        }
    }
    //    validamos que el usuario y la pass existan 
    //    y devolvemos el rol para asi acceder a la debida pagina
    public function validation()
    {
        $this->load->model('login_model');

        if ($this->login_model->log_in_correctly()) {
			
            return true;
        } else {
            $this->form_validation->set_message('validation', 'Incorrect username/password.');
            return false;
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Main/login');
    }
}
