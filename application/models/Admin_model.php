<?php
/**
 * Created by PhpStorm.
 * User: udithj
 * Date: 8/14/2018
 * Time: 5:05 PM
 */
?>

<?php

class Admin_model extends CI_Model{

    public function get_admins(){
        $this->db->select('id, name, email, telephone');
        $this->db->where('type','Admin');
        $query = $this->db->get('user');

        $data = $query->result();
        return $data;

//        return $query->result_array();

    }

    public function get_admin_by_id($id){
        $this->db->select('id, name, email, telephone');
        $this->db->where('id',$id);
        $query = $this->db->get('user');

        $data = $query->result();
        return $data;
    }

    public function get_admin_by_email($email){
        $this->db->select('id, name, email, telephone');
        $this->db->where('email',$email);
        $query = $this->db->get('user');

        $data = $query->result();
        return $data;
    }

    public function edit_admin($where, $data){
        $this->db->update('user', $data, $where);
        return $this->db->affected_rows();
    }

    public function get_emails(){
        $this->db->select('email');
        $query = $this->db->get('user');

        $data = $query->result();

        return $data;
    }

    public function delete($id){
        $this->db->where('id',$id);
        return $this->db->delete('user');
    }
}

?>
