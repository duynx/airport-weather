<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Airport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Airport_model");
    }

    public function ajaxSearchAirport()
    {
        $query = $this->input->get('query');
        $data['query'] = $query;
        $data['suggestions'] = array();

        $results = $this->Airport_model->searchAirportLevenshtein($query);
        foreach ($results as $airport){
            $data['suggestions'][] = array(
                'value' => "(".$airport->iata.") ".$airport->title.", ".$airport->city,
                'data' => $airport->icao,
            );
        }

        echo json_encode($data);
        exit();
    }

}