<?php

class User_home extends CI_Controller
{
    public function index()
    {
        $data["call"] = True;
        $this->load->view('include/header_Loggedin_user', $data);
        $this->load->view('include/side_navbar_user');
        //$this->load->view('admin_home');
    }

    public function home()
    {
        $this->load->view('search_place');
//        $this->load->view('admin_map');
    }
}


?>