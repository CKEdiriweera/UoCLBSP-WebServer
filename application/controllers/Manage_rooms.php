<?php
/**
 * Created by PhpStorm.
 * Auth: Chathurya
 * Date: 1/7/2018
 * Time: 6:20 PM
 */

class Manage_rooms extends CI_Controller
{
    public function home()
    {
        $this->load->view('rooms/rooms_home');
    }

    public function rooms()
    {
        $this->load->view('rooms/add_room');
    }

    function get_autocomplete(){
        $this->load->model('manage_rooms_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_rooms_model->search_rooms($_GET['term']);
//            var_dump($result);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = $row->name;
                echo json_encode($arr_result);
            }
        }
    }

    function get_autocomplete_room_type(){
        $this->load->model('manage_rooms_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_rooms_model->search_room_type($_GET['term']);
//            var_dump($result);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = $row->type;
                echo json_encode($arr_result);
            }
        }
    }

    function get_autocomplete_building(){
        $this->load->model('manage_rooms_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_rooms_model->search_building($_GET['term']);
//            var_dump($result);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = $row->name;
                echo json_encode($arr_result);
            }
        }
    }

    public function add_room()
    {
        $this->load->model('manage_rooms_model');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'floor' => $this->input->post('floor'),
            'room_type' => $this->input->post('room_type'),
            'building_name' => $this->input->post('building_name')
        );
        $this->manage_rooms_model->add($data);
    }

    public function search_room()
    {
        $this->load->model('manage_rooms_model');
        $data = array(
            'name' => $this->input->post('name'),
        );
        $room = $this->manage_rooms_model->edit($data);
        $view_data = $this->load->view('rooms/edit_room', $room, TRUE);
        $this->output->set_output($view_data);
    }

//    public function update_room()
//    {
//        $this->load->model('manage_rooms_model');
//
//        $datasearch2 = array(
//            'name' => $this->input->post('name'),
//            'id' => $this->input->post('id'),
//        );
////        var_dump($datasearch2);
//
////        $this->load->view('rooms/edit', $datasearch2);
//
//        $this->manage_rooms_model->edit($datasearch2);
//    }

    public function change_room()
    {
        $this->load->model('manage_rooms_model');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'floor' => $this->input->post('floor'),
            'room_type' => $this->input->post('room_type'),
            'building_name' => $this->input->post('building_name'),
        );
        $this->manage_rooms_model->change($data);
    }

    public function delete_room()
    {
        $this->load->model('manage_rooms_model');

        $datasearch4 = array(
            'id' => $this->input->post('id'),
        );

        $this->manage_rooms_model->delete($datasearch4);
    }
}