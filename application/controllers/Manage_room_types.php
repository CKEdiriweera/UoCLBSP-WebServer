<?php
/**
 * Created by PhpStorm.
 * Auth: Chathurya
 * Date: 1/7/2018
 * Time: 6:20 PM
 */

class Manage_room_types extends CI_Controller
{
    public function home()
    {
        $this->load->view('room_types/room_types_home');
    }

    function get_autocomplete(){
        $this->load->model('manage_room_types_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_room_types_model->search_room_types($_GET['term']);
            echo json_encode($result);
//            var_dump($result);
//            if (count($result) > 0) {
//                foreach ($result as $row)
//                    $arr_result[] = $row->type;
////                    $arr_result = array(
////                      'type' => $row->type,
////                      'id' => $row->id
////                    );
//                echo json_encode($arr_result);
//                var_dump($arr_result);
//            }
        }
    }

    public function room_type()
    {
        $this->load->view('room_types/add_room_type');
    }

    public function add_room_type()
    {
        $this->load->model('manage_room_types_model');
        $data = array(
            'type' => $this->input->post('type'),
            'description' => $this->input->post('description')
        );
        $this->manage_room_types_model->add($data);
    }

    public function search_room_type()
    {
        $this->load->model('manage_room_types_model');
        $data = array(
            'type' => $this->input->post('type'),
            'id' => $this->input->post('id')
        );
        $room_type = $this->manage_room_types_model->edit($data);
        $view_data = $this->load->view('room_types/edit_room_type', $room_type, TRUE);
        $this->output->set_output($view_data);
    }

//    public function change_room_type()
//    {
//        $this->load->model('manage_room_types_model');
//        $data = array(
//            'type' => $this->input->post('type')
//        );
//        $room_type = $this->manage_room_types_model->edit($data);
//        $view_data = $this->load->view('room_types/edit_room_type', $room_type, TRUE);
//        $this->output->set_output($view_data);
//
//    }

    public function change_room_type()
    {
        $this->load->model('manage_room_types_model');

        $datasearch3 = array(
            'type' => $this->input->post('type'),
            'description' => $this->input->post('description'),
            'id' => $this->input->post('id'),
        );
//        var_dump($datasearch3);

        $this->manage_room_types_model->change($datasearch3);

//        $this->load->view('room_typess/edit');
    }

    public function delete_room_type()
    {
        $this->load->model('manage_room_types_model');

        $datasearch4 = array(
            'id' => $this->input->post('id'),
        );

        $this->manage_room_types_model->delete($datasearch4);
    }
}