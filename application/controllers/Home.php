<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(empty($this->session->userdata('login'))){
            redirect(base_url('login'), 'refresh');
        }
        $data = array(
            'title' => 'Weather in airport',
        );

        //Set the validation rules
        $this->form_validation->set_rules("airport", "Airport", "required|trim");
        $this->form_validation->set_rules("date", "Date", "required|trim");
        $this->form_validation->set_rules("time", "Time", "required|trim");

        //When submit the form
        if ($this->form_validation->run()) {
            //get data from the form
            $icao_input = $this->input->post('icao');
            $date_input = $this->input->post('date');
            $time_input = $this->input->post('time');

            //Handle the data input
            $timestamp = strtotime($date_input);
            $date = date('d', $timestamp);
            $month = date('m', $timestamp);
            $year = date('Y', $timestamp);

            //Make the request to get weather
            $client = new Client();
            $response = $client->request('GET', 'https://mesonet.agron.iastate.edu/cgi-bin/request/asos.py', array(
                'query' => array(
                    'station' => $icao_input,
                    'data' => 'metar',
                    'year1' => $year,
                    'month1' => $month,
                    'day1' => $date,
                    'year2' => $year,
                    'month2' => $month,
                    'day2' => $date,
                    'format' => 'onlycomma',
                    'latlon' => 'no',
                    'missing' => 'null',
                    'trace' => 'T',
                    'direct' => 'no',
                    'report_type' => '1',
                    'report_type' => '2',
                )
            ));
            $contents = $response->getBody()->getContents();
            $content_arr = explode("\n",$contents);
            $rs = get_weather_by_time($content_arr,$time_input);
            $data['resutl'] = $rs;
            if(empty($rs)){
                $this->session->set_flashdata('mess', "Sorry, we dont have the weather data for this airport at this time yet!");
            }else{
                $this->session->set_flashdata('mess', 'Get the weather successful!');
            }

            $this->session->set_flashdata('rs', $rs);
        }

        //Load the view
        $this->load->view('home/index', $data);
    }
}