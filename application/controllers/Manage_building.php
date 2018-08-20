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

    function get_autocomplete(){
        $this->load->model('manage_building_model');
        if (isset($_GET['term'])) {
//            var_dump($_GET['term']);
            $result = $this->manage_building_model->search_buildings($_GET['term']);
            echo json_encode($result);
//            var_dump($result);
//            if (count($result) > 0) {
//                foreach ($result as $row)
//                    $arr_result['name'] = $row->name;
//                    $arr_result['id'] = $row->id;
////                    $arr_result = array(
////                        'name' => $row->name,
////                        'id' => $row->id
////                    );
////                var_dump($arr_result);
//                echo json_encode($arr_result);
//            }
        }
    }

    public function add_building()
    {
        $this->load->model('manage_building_model');
//        $data = array(
//            'name' => $this->input->post('name'),
//            'description' => $this->input->post('description'),
//            'latitudes' => $this->input->post('latitudes'),
//            'longitudes' => $this->input->post('longitudes'),
//            'graph_id' => $this->input->post('graphId')
//        );
        $data = array(

            'name' => $_REQUEST['name'],
            'description' => $_REQUEST['desc'],
            'latitudes' => $_REQUEST['lat'],
            'longitudes' => $_REQUEST['lng'],
            'graph_id' => $_REQUEST['g_id'],
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'latitudes' => $this->input->post('latitudes'),
            'longitudes' => $this->input->post('longitudes'),
            'graph_id' => $this->input->post('graph_id')

        );
        $this->manage_building_model->add($data);

        $res = array("type"=>true);

        echo json_encode($res);

    }

    public function search_building()
    {
        if (isset($_POST['name'])) {
            $this->load->model('manage_building_model');
            $data = array(
                'name' => $this->input->post('name'),
                'id' => $this->input->post('id')
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
            $this->load->model('manage_building_model');
            $data0 = array(
                'latitudes' => $this->input->post('latitudes'),
                'longitudes' => $this->input->post('longitudes'),
            );
//            var_dump($data0);
            $data = $this->manage_building_model->get_id($data0);
//            var_dump($data);
            $data = json_decode(json_encode($data), True);
            $data = array(
                'id' => $data[0]['id']
            );
//            var_dump($data);
            $building = $this->manage_building_model->selected2($data);
            $building['result'] = $this->manage_building_model->display_buildings_except($data);
//            var_dump($building);
            $view_data = $this->load->view('buildings/edit_building', $building, TRUE);
            $this->output->set_output($view_data);
        }
    }

    public function change_building()
    {
        $this->load->model('manage_building_model');
        $data = array(
            'name' => $_REQUEST['name'],
            'description' => $_REQUEST['description'],
            'latitudes' => $_REQUEST['latitudes'],
            'longitudes' => $_REQUEST['longitudes'],
            'graph_id' => $_REQUEST['graphId'],
            'id' => $_REQUEST['id'],
        );
//        var_dump($data);
        $this->manage_building_model->change($data);

        echo json_encode(array("status" => true));
//        $this->load->view('buildings/edit');
        //$this->load->library(base_url("controllers/Admin_home"));
        //$this->Admin_home->index();

//        redirect('Admin_home');
    }

    public function delete_building(){
        $this->load->model('Manage_building_model');
        $datasearch4 = array(
            'id' => $_REQUEST['id']
        );
        $this->Manage_building_model->delete($datasearch4);

        echo json_encode(array("status" => true));
    }
}