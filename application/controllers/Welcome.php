<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function index()
    {
        $data["call"] = True;
        $this->load->view('include/header',$data);
//        $this->load->view('include/side_navbar_user');
    }

    public function logged_in()
    {
        $data["call"] = True;
        $this->load->view('include/header_Loggedin',$data);
        $this->load->view('include/side_navbar_user');
    }

    public function home(){
        $this->load->view('search_place');
    }

    public function nearby_search()
    {
        $this->load->view('nearby_search');
    }

    public function test(){
        $this->load->view('test');
    }

    public function test2(){
        $this->load->view('search_place');
    }
}
