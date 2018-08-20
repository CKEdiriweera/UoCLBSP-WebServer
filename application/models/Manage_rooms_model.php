<?php
/**
 * Created by PhpStorm.
 * Auth: Chathurya
 * Date: 1/7/2018
 * Time: 6:17 PM
 */

class Manage_rooms_model extends CI_Model
{
    function search_room_type($room_type)
    {
        return $this->db->select('type')->like('type', $room_type, 'both')->order_by('type', 'ASC')->limit(5)->get('room_type')->result();
    }

    function search_building($building_name)
    {
        return $this->db->select('name')->like('name', $building_name, 'both')->order_by('name', 'ASC')->limit(5)->get('building')->result();
    }

    public function add($data){
        if(isset($_POST['room_name'])){
            $room_type = $_POST['room_type'];
            $query1 = $this->db->select('id')->from('room_type')->where('type', $room_type)->get();
            $rows = $query1->row_array();
            $room_type_id = $rows['id'];

            $building_name = $_POST['building_name'];
            $query2 = $this->db->select('id')->from('building')->where('name', $building_name)->get();
            $rows2 = $query2->row_array();
            $building_id = $rows2['id'];

            $data = array(
                'name' => $_POST['room_name'],
                'description' => $_POST['description'],
                'floor' => $_POST['floor'],
                'room_type_id' => $room_type_id,
                'building_id' => $building_id
            );
            return $this->db->insert('room', $data);

        }
    }

    public function edit()
    {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $query = $this->db->select('*')->from('room')->where('name', $name)->get();
            $rows = $query->row_array();

            $room_type_id = $rows['room_type_id'];
            $room_type_query = $this->db->select('type')->from('room_type')->where('id', $room_type_id)->get();
            $room_type_row = $room_type_query->row_array();
            $room_type = $room_type_row['type'];

            $building_id = $rows['building_id'];
            $building_query = $this->db->select('name')->from('building')->where('id', $building_id)->get();
            $building_row = $building_query->row_array();
            $building_name = $building_row['name'];
            $data = array(
                'id' => $rows['id'],
                'name' => $rows['name'],
                'description' => $rows['description'],
                'floor' => $rows['floor'],
                'room_type' => $room_type,
                'building_name' => $building_name
            );
            return $data;
        }
    }

    function search_rooms($name)
    {
        return $this->db->select('name,id')->like('name', $name, 'both')->order_by('name', 'ASC')->limit(5)->get('room')->result();
    }

//    public function selected($datasearch1)
//    {
//        var_dump($datasearch1);
//        if (isset($_POST['name'])) {
////            echo 'poo';
//            $id = $_POST['id'];
////            echo $name;
//            $query = $this->db->select('*')->from('room')->where('id', $id)->get();
////            $query = $this->db->query("SELECT * FROM building where name = '$name';");
////            var_dump($query);
//
//            $rows = $query->row_array();
////            var_dump($rows);
//            $rows['name'];
//            $data2 = array(
//                'id' => $rows['id'],
//                'name' => $rows['name'],
//                'description' => $rows['description'],
//                'latitudes' => $rows['latitudes'],
//                'longitudes' => $rows['longitudes'],
//                'graph_id' => $rows['graph_id']
//            );
////            var_dump($data2);
//
//            $this->load->view('rooms/selected_room', $data2);
//        }
//    }

//    public function edit($datasearch2)
//    {
////        echo 'ok';
////        var_dump($datasearch2);
//        if (isset($_POST['name'])) {
////            echo 'poo';
//            $id = $_POST['id'];
//            $query = $this->db->select('*')->from('room')->where('id', $id)->get();
////            $query = $this->db->select('*')->from('building')->like('name', $name, 'before')->get();
////            $query = $this->db->query("SELECT * FROM building where name = '$name';");
////            var_dump($query);
//
//            $rows = $query->row_array();
////            var_dump($rows);
////            $rows['name'];
//            $data2 = array(
//                'id' => $rows['id'],
//                'name' => $rows['name'],
//                'description' => $rows['description'],
//                'latitudes' => $rows['latitudes'],
//                'longitudes' => $rows['longitudes'],
//                'graph_id' => $rows['graph_id']
//            );
////            var_dump($data2);
//
//            $this->load->view('rooms/edit_room', $data2);
//        }
//    }

    public function change($data)
    {
            $id = $data['id'];
//            $room_query = $this->db->select('id')->from('building')->where('name', $name)->get();
//            $room_row = $room_query->row_array();
//            $id = $room_row['id'];

            $room_type = $data['room_type'];
            $room_type_query = $this->db->select('id')->from('room_type')->where('type', $room_type)->get();
            $room_type_row = $room_type_query->row_array();
            $room_type_id = $room_type_row['id'];

            $building_name = $data['building_name'];
            $building_query = $this->db->select('id')->from('building')->where('name', $building_name)->get();
            $building_row = $building_query->row_array();
            $building_id = $building_row['id'];

            $data = array(
                'name' => $data['name'],
                'description' => $data['description'],
                'floor' => $data['floor'],
                'room_type_id' => $room_type_id,
                'building_id' => $building_id
            );

            $this->db->where('id', $id)->update('room', $data);
    }

    public function delete($data)
    {
        if (isset($_POST['id'])) {
//            echo 'poo';
            $id = $data['id'];
            $this->db->where('id', $id)->delete('room');

        }
    }

}