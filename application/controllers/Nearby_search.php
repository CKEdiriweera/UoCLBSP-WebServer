<?php

class Nearby_search extends CI_Controller
{
    function test()
    {
        $this->load->model('nearby_search_model');
        $this->nearby_search_model->test();
    }

    function __construct(){
        parent::__construct();
        $this->load->model('nearby_search_model');
    }

    function index(){
        $this->load->view('nearby_search');
    }

    function get_autocomplete(){
//        $this->load->model('nearby_search_model');
        if (isset($_GET['term'])) {
            $result = $this->nearby_search_model->search_room_type($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = $row->type;
                echo json_encode($arr_result);
            }
        }
    }

    function get_nearby_places()
    {
        if (isset($_POST['source_name'])) {
            $source_name = $_POST['source_name'];
            $source_lat = $_POST['source_lat'];
            $source_lng = $_POST['source_lng'];
            $this->load->model('Nearby_search_model');
            $data = array(
                'name' => $this->input->post('source_name'),
                'lat1' => $this->input->post('source_lat'),
                'lng1' => $this->input->post('source_lng'),
                'type' => $this->input->post('room_type'),
            );
            $source_name= array(
                'source_name' => $source_name,
                'source_lat' => $source_lat,
                'source_lng' => $source_lng,
            );
            $room_array['result'] = $this->nearby_search_model->search_nearby_places($data);
            $data = array_merge($room_array, $source_name);
//            var_dump($room_array);
            $view_data = $this->load->view('nearby_search_display', $data, TRUE);
            $this->output->set_output($view_data);
        }
    }

    function get_nearby_places_android()
    {
//        $data = '{"source_name": "","source_lat": 0,"source_lng": 0,"room_type":""}';
        $character = json_decode(file_get_contents('php://input'), true);
//        var_dump($character);

        if($character)
        {
            $data = array(
                'name' => $character["source_name"],
                'lat1' => $character["source_lat"],
                'lng1' => $character["source_lng"],
                'type' => $character["room_type"],
            );
//            var_dump($data);
            $room_array['result'] = $this->nearby_search_model->search_nearby_places($data);
            $room_array = json_encode($room_array);
            echo($room_array);
        }

    }

    function get_directions()
    {
        if(isset($_POST['source_name']))
        {
            $source_name = $_POST['source_name'];
            $source_lat = $_POST['source_lat'];
            $source_lng = $_POST['source_lng'];
//            $destination_name = $_POST['destination_name'];
            $destination_lat = $_POST['destination_lat'];
            $destination_lng = $_POST['destination_lng'];
            $data = array(
                'source_name' => $source_name,
                'source_lat' => $source_lat,
                'source_lng' => $source_lng,
//                'destination_name' => $destination_name,
                'destination_lat' => $destination_lat,
                'destination_lng' => $destination_lng,
            );
            $this->load->view('get_directions', $data);
        }
    }
}