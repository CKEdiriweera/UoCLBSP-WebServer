<?php
class Manage_building extends CI_Controller
{
    public function home()
    {
        $this->load->model('manage_building_model');
        $buildings['result'] = $this->manage_building_model->display_buildings();
//        var_dump($buildings);
        $this->load->view('buildings/building_home', $buildings);
    }
    public function building()
    {
        $this->load->model('manage_building_model');
        $buildings['result'] = $this->manage_building_model->display_buildings();
//        var_dump($buildings);
        $this->load->view('buildings/add_building', $buildings);
    }

    public function selected()
    {

    }

    function get_autocomplete(){
        $this->load->model('manage_building_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_building_model->search_buildings($_GET['term']);
//            var_dump($result);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = $row->name;
                echo json_encode($arr_result);
            }
        }
    }

    public function add_building()
    {
        $this->load->model('manage_building_model');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'latitudes' => $this->input->post('latitudes'),
            'longitudes' => $this->input->post('longitudes'),
            'graph_id' => $this->input->post('graphId')
        );
        $this->manage_building_model->add($data);
//        redirect('admin_home');
    }
    public function search_building()
    {
        if (isset($_POST['name'])) {
            $this->load->model('manage_building_model');
            $data = array(
                'name' => $this->input->post('name'),
            );
            $building = $this->manage_building_model->selected($data);
            $building['result'] = $this->manage_building_model->display_buildings_except($data);
//            var_dump($building);
            $view_data = $this->load->view('buildings/edit_building', $building, TRUE);
            $this->output->set_output($view_data);
        }
    }

    public function search_buildingby_latlng()
    {
        if (isset($_POST['latitudes'], $_POST['longitudes'])) {
            echo 'hfh';
            $this->load->model('manage_building_model');
            $data0 = array(
                'latitudes' => $this->input->post('latitudes'),
                'longitudes' => $this->input->post('longitudes'),
            );
            $data = $this->manage_building_model->get_name($data0);
            var_dump($data);
//            $building = $this->manage_building_model->selectby_latlng($data);
//            $building['result'] = $this->manage_building_model->display_buildings_except($data);
//            var_dump($building);
//            $view_data = $this->load->view('buildings/edit_building', $building, TRUE);
//            $this->output->set_output($view_data);
        }
    }

    public function change_building()
    {
        $this->load->model('manage_building_model');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'latitudes' => $this->input->post('latitudes'),
            'longitudes' => $this->input->post('longitudes'),
            'graph_id' => $this->input->post('graphId'),
            'id' => $this->input->post('id'),
        );
//        var_dump($data);
        $this->manage_building_model->change($data);
//        $this->load->view('buildings/edit');
        //$this->load->library(base_url("controllers/Admin_home"));
        //$this->Admin_home->index();

//        redirect('Admin_home');
    }
    public function delete_building()
    {
        $this->load->model('manage_building_model');
        $datasearch4 = array(
            'id' => $this->input->post('id'),
        );
        $this->manage_building_model->delete($datasearch4);
    }
}