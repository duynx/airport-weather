<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function login()
    {
        if(!empty($this->session->userdata('login'))){
            redirect(base_url(), 'refresh');
        }
        $this->load->model('User_model');
        $data = array(
            'title' => 'Login to weather in airport',
        );

        //Set the validation rules
        $this->form_validation->set_rules("username", "Username", "required|trim");
        $this->form_validation->set_rules("pwd", "Password", "required|trim");

        //When submit the form
        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('pwd');

            if ($this->User_model->login_user($username,$password)) {
                $username = $this->input->post('username');
                //If login correct, create a session for user
                $this->session->set_userdata('login', $username);
                redirect(base_url());
            } else {
                $this->session->set_flashdata('mess_fail', 'Login fail, please try again!');
            }
        }

        $this->load->view('user/login', $data);
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

}
