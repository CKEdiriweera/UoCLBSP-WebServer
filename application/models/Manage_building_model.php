<?php
class Manage_building_model extends CI_Model
{
    public function display_buildings()
    {
        $query = $this->db->select('id, latitudes, longitudes, name, description, graph_id')->from('building')->get();
//        var_dump($query->result());
        return $query->result();
    }

    public function get_name($data0)
    {
        $latitudes = $data0['latitudes'];
        $longitudes = $data0['longitudes'];
        $multiple_where = array('latitudes' => $latitudes, 'longitudes' => $longitudes);
        $query = $this->db->select('name')->from('building')->where($multiple_where)->get();
        return $query->result();
    }

    public function get_id($data0)
    {
        $latitudes = $data0['latitudes'];
        $longitudes = $data0['longitudes'];
//        var_dump($latitudes);
//        var_dump($longitudes);
        $multiple_where = array('latitudes' => $latitudes, 'longitudes' => $longitudes);
        $query = $this->db->select('id')->from('building')->where($multiple_where)->get();
//        var_dump($query->result());
        return $query->result();
    }

    public function display_buildings_except($data)
    {
//        $name =$_POST['name'];
        $id = $data['id'];
        $query = $this->db->select('id, latitudes, longitudes, name, description, graph_id')->from('building')->where('id !=', $id)->get();
        return $query->result();
        var_dump($query->result());
    }

    function search_buildings($name)
    {
        return $this->db->select('name, id')->like('name', $name, 'both')->order_by('name', 'ASC')->limit(5)->get('building')->result();
    }

    public function add($data)
    {
        return $this->db->insert('building', $data);
    }

    public function selected($data)
    {
        $name = $_POST['name'];
        $id = $_POST['id'];
//        var_dump($name);
        $query = $this->db->select('*')->from('building')->where('id', $id)->get();
        $rows = $query->row_array();
//        var_dump($rows);
//        $rows['name'];
        $data = array(
            'id' => $rows['id'],
            'name' => $rows['name'],
            'description' => $rows['description'],
            'latitudes' => $rows['latitudes'],
            'longitudes' => $rows['longitudes'],
            'graph_id' => $rows['graph_id']
        );
        return $data;
//        var_dump($data);
    }

    public function selected2($data)
    {
        //$name = $_POST['name'];
        $id = $data['id'];
//        var_dump($name);
        $query = $this->db->select('*')->from('building')->where('id', $id)->get();
        $rows = $query->row_array();
//        var_dump($rows);
//        $rows['name'];
        $data = array(
            'id' => $rows['id'],
            'name' => $rows['name'],
            'description' => $rows['description'],
            'latitudes' => $rows['latitudes'],
            'longitudes' => $rows['longitudes'],
            'graph_id' => $rows['graph_id']
        );
        return $data;
//        var_dump($data);
    }

    public function edit($id)
    {
        $query = $this->db->select('*')->from('building')->where('id', $id)->get();
        $rows = $query->row_array();
        $data2 = array(
            'id' => $rows['id'],
            'name' => $rows['name'],
            'description' => $rows['description'],
            'latitudes' => $rows['latitudes'],
            'longitudes' => $rows['longitudes'],
            'graph_id' => $rows['graph_id']
        );

        //$this->load->view('buildings/edit_building', $data2);
        return $data2;

    }

    public function change($data){
        //var_dump($data);
        if (isset($data['name'])) {
            $id = $data['id'];
            $data3 = array(
                'name' => $data['name'],
                'description' => $data['description'],
                'latitudes' => $data['latitudes'],
                'longitudes' => $data['longitudes'],
                'graph_id' => $data['graph_id']
            );
            //var_dump($data3);
            $this->db->where('id', $id)->update('building', $data3);
        }

    }

    public function delete($datasearch4){
//        if (isset($_POST['name'])) {
//            $id = $_POST['id'];
//            $this->db->where('id', $id)->delete('building');
//        }
        $id = $datasearch4['id'];
        $this->db->where('id', $id)->delete('building');
    }
}