<?php
class Manage_building_model extends CI_Model
{
    public function display_buildings()
    {
        $query = $this->db->select('id, latitudes, longitudes, name, description, graph_id')->from('building')->get();
        return $query->result();
    }

    public function get_name($data)
    {
        $latitudes = $data['latitudes'];
        $longitudes = $data['longitudes'];
        $query = $this->db->select('name')->where("(latitudes = $latitudes AND longitudes = $longitudes)")->get();
        return $query->result();
    }

    public function display_buildings_except($data)
    {
        $name =$data['name'];
        $query = $this->db->select('id, latitudes, longitudes, name, description, graph_id')->from('building')->where('name !=', $name)->get();
        return $query->result();
    }

    function search_buildings($name)
    {
        return $this->db->select('name, id, description, latitudes, longitudes')->like('name', $name, 'both')->order_by('name', 'ASC')->limit(5)->get('building')->result();
    }

    public function add($data)
    {
        return $this->db->insert('building', $data);
    }

    public function selected($data)
    {
        $name = $data['name'];
        $query = $this->db->select('*')->from('building')->where('name', $name)->get();
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
//        var_dump($data2);
    }

    public function selectby_latlng($data)
    {
        $latitudes = $data['latitudes'];
        $longitudes = $data['longitudes'];
        $query = $this->db->select('*')->from('building')->where('latitudes', $latitudes AND 'longitudes', $longitudes)->get();
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
//        var_dump($data2);
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
    public function change($data)
    {
        var_dump($data);
        if (isset($data['name'])) {
            $id = $data['id'];
            $data3 = array(
                'name' => $data['name'],
                'description' => $data['description'],
                'latitudes' => $data['latitudes'],
                'longitudes' => $data['longitudes'],
                'graph_id' => $data['graph_id']
            );
            var_dump($data3);
            $this->db->where('id', $id)->update('building', $data3);
        }

    }
    public function delete($datasearch4)
    {
        if (isset($_POST['name'])) {
//            echo 'poo';
            $id = $_POST['id'];
            $this->db->where('id', $id)->delete('building');
        }
    }
}