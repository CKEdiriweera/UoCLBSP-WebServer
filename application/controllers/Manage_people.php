<?php
/**
 * Created by PhpStorm.
 * Auth: Chathurya
 * Date: 1/6/2018
 * Time: 9:11 AM
 */

class Manage_people extends CI_Controller
{
    public function home()
    {
        $this->load->view('people/people_home');
    }

    public function people()
    {
        $this->load->view('people/add_people');
    }

    function get_autocomplete(){
        $this->load->model('manage_people_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_people_model->search_people($_GET['term']);
            echo json_encode($result);
//            var_dump($result);
//            if (count($result) > 0) {
//                foreach ($result as $row)
//                    $arr_result[] = $row->name;
//                echo json_encode($arr_result);
//            }
        }
    }

    function get_autocomplete_room_name(){
        $this->load->model('manage_people_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_people_model->search_room_name($_GET['term']);
//            var_dump($result);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = $row->name;
                echo json_encode($arr_result);
            }
        }
    }

    public function add_people()
    {
        $this->load->model('manage_people_model');
        $data = array(
            'name' => $this->input->post('building_name'),
            'designation' => $this->input->post('designation'),
            'description' => $this->input->post('description'),
            'room_name' => $this->input->post('room_name')
        );

        $this->manage_people_model->add($data);
//        redirect('admin_home');
//        redirect(base_url() . 'index.php/Admin_home/buildings');

//        $this->load->model('manage_building_model');
//        $this->manage_building_model->add();
    }

    public function search_people()
    {
        $this->load->model('manage_people_model');
        $data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
        );
        $room = $this->manage_people_model->edit($data);
        $view_data = $this->load->view('people/edit_people', $room, TRUE);
        $this->output->set_output($view_data);
    }

    public function change_people()
    {
        $this->load->model('manage_people_model');
        $data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'designation' => $this->input->post('designation'),
            'description' => $this->input->post('description'),
            'room_name' => $this->input->post('room_name'),
        );
        $this->manage_people_model->change($data);
    }

    public function delete_people()
    {
        $this->load->model('manage_people_model');
        $data = array(
            'id' => $this->input->post('id'),
        );
        $this->manage_people_model->delete($data);
    }

}