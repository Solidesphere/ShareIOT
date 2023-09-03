<?php

class Pages extends Controller {
    public function __construct(){
        
    }
    public function index(){
        if(isLoggedIn()){
            redirect('posts');
        }

        $data = [
            'title' => 'ShareIOT',
            'description' => 'Simple social IOT network to share things'
        ];

        $this->view('pages/index', $data);
    }
    
    public function about(){
        $data = [
            'title' => 'About Us',
            'description' => 'App to share  IOT device with other user'
        ];

        $this->view('pages/about', $data);
    }
    
    
}