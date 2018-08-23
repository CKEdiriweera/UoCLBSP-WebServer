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
        $this->load->model('Manage_building_model');
        $buildings['result'] = $this->Manage_building_model->display_buildings();
//        var_dump($buildings);
        $this->load->view('rooms/add_room', $buildings);
    }

    function get_autocomplete(){
        $this->load->model('manage_rooms_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_rooms_model->search_rooms($_GET['term']);
            echo json_encode($result);
//            var_dump($result);
//            if (count($result) > 0) {
//                foreach ($result as $row)
//                    $arr_result[] = $row->name;
//                echo json_encode($arr_result);
//            }
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
        $this->load->model('Manage_rooms_model');
        $data = array(
            'room_name' => $_REQUEST['name'],
            'description' => $_REQUEST['description'],
            'floor' => $_REQUEST['floor'],
            'room_type' => $_REQUEST['room_type'],
            'building_name' => $_REQUEST['building_name']
        );
        $this->Manage_rooms_model->add($data);

        echo json_encode(array("status"=>true));
    }

    public function search_room()
    {
        $this->load->model('manage_rooms_model');
        $data = array(
            'name' => $this->input->post('name'),
            'id' => $this->input->post('id')
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

    public function change_room(){
        $this->load->model('manage_rooms_model');
        $data = array(
            'id' =>$_REQUEST['id'],
            'name' => $_REQUEST['name'],
            'description' => $_REQUEST['description'],
            'floor' => $_REQUEST['floor'],
            'room_type' => $_REQUEST['room_type'],
            'building_name' => $_REQUEST['building_name']
        );
        $this->manage_rooms_model->change($data);

        echo json_encode(array("status"=>true));
    }

    public function delete_room(){
        $this->load->model('Manage_rooms_model');
        $data = array(
            'id' => $_REQUEST['id']
        );
        $this->Manage_rooms_model->delete($data);
    }

    public function get_room_types(){
        $this->load->model('Manage_rooms_model','Room');
        $types = $this->Room->get_types();

        echo json_encode($types);
    }

    public function get_people_for_rooms(){

        $room_id = $_REQUEST['id'];

        $this->load->model('Manage_people_model','People');
        $people = $this->People->get_people_for_room($room_id);

        if (count($people)==0){
            echo json_encode(array("status"=>true));
        }
        else{
            echo json_encode(array("status"=>false, "people_count"=>count($people)));
        }
    }


}