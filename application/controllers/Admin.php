<?php
/**
 * Created by PhpStorm.
 * Auth: Chathurya
 * Date: 12/30/2017
 * Time: 1:45 PM
 */

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Admin_model','Admin');
    }

    public function home(){
        $data['query_result'] = $this->Admin->get_admins();
        $this->load->view('admin_panel',$data);
    }

    public function get_admins_data(){

        $admin_list = $this->Admin->get_admins();
        echo json_encode($admin_list);

    }

    public function get_admin_data_by_id($id){
        $data = $this->Admin->get_admin_by_id($id);
        echo json_encode($data);
    }

    public function get_admin_data_by_email(){
        $email = $_REQUEST['email'];
        $data = $this->Admin->get_admin_by_email($email);
        echo json_encode($data);
//        $data = $this->Admin->get_admin_by_email($email);
//        echo json_encode($data);
    }

    public function delete_admin($email){
        $result = $this->Admin->delete($email);
        echo json_encode($result);
    }

    public function edit_admin_data(){

        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'telephone' => $this->input->post('telephone')
        );

        $where = array('id'=>$this->input->post('id'));

        $this->Admin->edit_admin($where,$data);
        echo json_encode(array("status" => TRUE));
    }

    public function get_email_list(){
        $data = $this->Admin->get_emails();

        echo json_encode($data);
    }


    public function add(){
        $this->load->view('include/header');
        $this->load->view('buildings/add');


    }
}