<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function register(){
        if(!empty($this->session->userdata('login'))){
            redirect(base_url(), 'refresh');
        }
        $this->load->model('User_model');
        $data = array(
            'title' => 'Regsiter',
        );

        //Set the validation rules
        $this->form_validation->set_rules("username", "Username", "required|min_length[4]|max_length[12]|is_unique[users.username]");
        $this->form_validation->set_rules("pwd", "Password", "required|trim|min_length[4]");
        $this->form_validation->set_rules("repwd", "Confirm password", "required|trim|matches[pwd]");

        //When submit the form
        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('pwd');
            $password = bScript($password);
            $this->User_model->insert_user($username,$password);
            $this->session->set_flashdata('mess', 'Register successfully, please login !');
        }

        $this->load->view('user/register', $data);
    }

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
