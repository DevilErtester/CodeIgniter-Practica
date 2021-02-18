<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
    private function is_logged()
    {
        if ($this->session->userdata('currently_logged_in')) {
            return true;
        } else {
            return false;
        }
    }

    public function dashboard_controller()
    {
        if ($this->is_logged()) {
            redirect('User/index');
        } else {
            redirect('User/invalid');
        }
    }


    private function invalid()
    {
        $this->load->view('invalid');
    }
    // ===========================================================================================================
    // ======================MAIN=================================================================================
    // ===========================================================================================================
    public function index()
    {
        if ($this->is_logged()) {
            $this->load->model('User_model');
            $this->load->model('Alum_model');
            $this->load->model('Tutors_model');

            $user = $this->User_model->getUserByid($this->session->userdata()['userId']);
            $data['userData'] = $user;
            if ($user[0]['rol'] == 1) {
                $data['detail'] = $this->Alum_model->getOnlyAlu($this->session->userdata()['userId']);
                $data['rol'] = "User";
            } else if ($user[0]['rol'] == 2) {
                $data['detail'] = $this->Tutors_model->getOnlyTutor($this->session->userdata()['userId']);
                $data['rol'] = "Prof";
            } else if ($user[0]['rol'] == 0) {
                $data['detail'] = null;
                $data['rol'] = "Admin";
            }
            $this->load->view('users', $data);
        } else {
            redirect('User/invalid');
        }
    }
}
