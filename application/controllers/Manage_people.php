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
            'building_name' => $this->input->post('building_name'),
            'room_name' => $this->input->post('room_name')
        );

        $this->manage_people_model->add($data);
//        redirect('admin_home');
//        redirect(base_url() . 'index.php/Admin_home/buildings');

//        $this->load->model('manage_building_model');
//        $this->manage_building_model->add();
    }

}