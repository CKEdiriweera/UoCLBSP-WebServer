<?php
/**
 * Created by PhpStorm.
 * Auth: Chathurya
 * Date: 1/6/2018
 * Time: 9:04 AM
 */

class Manage_people_model extends CI_Model
{
    function search_people($name)
    {
        return $this->db->select('name,id')->like('name', $name, 'both')->order_by('name', 'ASC')->limit(5)->get('people')->result();
    }

    function search_room_name($room_name)
    {
        return $this->db->select('name')->like('name', $room_name, 'both')->order_by('name', 'ASC')->limit(5)->get('room')->result();
    }

    public function add($data)
    {
        if(isset($_POST['people_name'])){
//            $building_name = $_POST['building_name'];
//            $query1 = $this->db->select('id')->from('building')->where('name', $building_name)->get();
//            $rows = $query1->row_array();
//            $building_id = array(
//                'building_id' => $rows['id']
//            );

            $room_name = $data['room_name'];
            $query2 = $this->db->select('id')->from('room')->where('name', $room_name)->get();
            $rows2 = $query2->row_array();
            $room_id = array(
                'room_id' => $rows2['id']
            );

            $data3 = array(
                'name' => $data['people_name'],
                'designation' => $data['designation'],
                'description' => $data['description'],
//                'building_id' => $building_id['building_id'],
                'room_id' => $room_id['room_id']
            );

            return $this->db->insert('people', $data3);
        }


    }

    public function edit($data){

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $query = $this->db->select('*')->from('people')->where('id', $id)->get();
            $rows = $query->row_array();

            $room_id = $rows['room_id'];
            $room_query = $this->db->select('name')->from('room')->where('id', $room_id)->get();
            $room_row = $room_query->row_array();
            $room = $room_row['name'];

//            $building_id = $rows['building_id'];
//            $building_query = $this->db->select('name')->from('building')->where('id', $building_id)->get();
//            $building_row = $building_query->row_array();
//            $building_name = $building_row['name'];
            $data = array(
                'id' => $rows['id'],
                'name' => $rows['name'],
                'designation' => $rows['designation'],
                'description' => $rows['description'],
                'room_name' => $room,
            );
            return $data;
        }
    }

    public function change($data){
//        if (isset($_POST['id'])) {
//            $id = $_POST['id'];
//
//            $room_name = $_POST['room_name'];
//            $room_name_query = $this->db->select('id')->from('room')->where('name', $room_name)->get();
//            $room_name_row = $room_name_query->row_array();
//            $room_name_id = $room_name_row['id'];
//
//            $data = array(
//                'name' => $_POST['name'],
//                'designation' => $_POST['designation'],
//                'description' => $_POST['description'],
//                'room_id' => $room_name_id,
//            );
//
//            $this->db->where('id', $id)->update('people', $data);
//        }
        $room_name = $data['room_name'];
        $id = $data['id'];
        $room_name_query = $this->db->select('id')->from('room')->where('name', $room_name)->get();
        $room_name_row = $room_name_query->row_array();
        $room_name_id = $room_name_row['id'];

        $data = array(
            'name' => $_POST['name'],
            'designation' => $_POST['designation'],
            'description' => $_POST['description'],
            'room_id' => $room_name_id,
        );
        $this->db->where('id', $id)->update('people', $data);
    }

    public function delete($data)
    {
        if (isset($data['id'])) {
            $id = $data['id'];
            $this->db->where('id', $id)->delete('people');
        }
    }

    public function get_people_for_room($room_id){
        $this->db->select('id');
        $this->db->where('room_id',$room_id);
        $query = $this->db->get('people');

        return $query->result();
    }


}