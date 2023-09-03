<?php
  class Things extends controller {
    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }
        $this->thingModel = $this->model('Thing');
        $this->userModel = $this->model('User');
    }
    public function index(){
        // GET THINGS

        $things = $this->thingModel->getThings();
        $data = [
          'things' => $things
        ];

       $this->view('things/index',$data); 
    }

    public function add(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        // SANITIZE THE THING array
        $_THINGS = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'name' => trim($_THINGS['name']),
          'baseHost'=> trim($_THINGS['baseHost']),
          'type' => trim($_THINGS['type']),
          'user_id' => $_SESSION['user_id'],
          'name_err' => '',
          'baseHost_err'=> '',
          'type_err' => ''
        ];
        // validate data
        if (empty($data['name'])){
          $data['name_err'] = 'Please enter the name of the thing';
        }
        if (empty($data['baseHost'])){
          $data['baseHost_err'] = 'Please enter the baseHoste of the thing';
        }
        if (empty($data['type'])){
          $data['type_err'] = 'Please fill the type of the thing';
        }
        // make sure no errors
        if(empty($data['name_err']) && empty($data['baseHost_err']) && empty($data['type_err'])){
        // validated
        if($this->thingModel->addThing($data)){
          flash('thing_message', 'Thing Added');
          redirect('things');
        }else{
          die('Somthing went wrong');
        }
        }else{
          // load the view with errors 
          $this->view('things/add',$data);
        }

      }else{
        $data = [
          'name' => '',
          'baseHost'=> '',
          'type' => ''
        ];
  
       $this->view('things/add',$data);
      }  
    }

    public function edit($id){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        // SANITIZE THE THING array
        $_THINGS = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'id' => $id,
          'name' => trim($_THINGS['name']),
          'baseHost'=> trim($_THINGS['baseHost']),
          'type' => trim($_THINGS['type']),
          'user_id' => $_SESSION['user_id'],
          'name_err' => '',
          'baseHost_err'=> '',
          'type_err' => ''
        ];
        // validate data
        if (empty($data['name'])){
          $data['name_err'] = 'Please enter the name of the thing';
        }
        if (empty($data['baseHost'])){
          $data['baseHost_err'] = 'Please enter the baseHoste of the thing';
        }
        if (empty($data['type'])){
          $data['type_err'] = 'Please fill the type of the thing';
        }
        // make sure no errors
        if(empty($data['name_err']) && empty($data['baseHost_err']) && empty($data['type_err'])){
        // validated
        if($this->thingModel->updateThing($data)){
          flash('thing_message', 'Thing Updated');
          redirect('things');
        }else{
          die('Somthing went wrong');
        }
        }else{
          // load the view with errors 
          $this->view('things/edit',$data);
        }

      }else{
        //get existing thing from model
        $thing = $this->thingModel->getThingById($id);
        //chek for owner
        if($thing->user_id != $_SESSION['user_id']){
          redirect('things');
        }

        $data = [
          'id' => $id,
          'name' => $thing->name,
          'baseHost'=> $thing->baseHost,
          'type' => $thing->type
        ];
  
       $this->view('things/edit',$data);
      }  
    }

    public function show($id){
      $thing= $this->thingModel->getThingById($id);
      $user = $this->userModel->getUserById($thing->user_id);
      $data = [
        'thing' => $thing,
        'user' => $user
      ];
      $this->view('things/show',$data);
    }

    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //get existing thing from model
        $thing = $this->thingModel->getThingById($id);

        //chek for owner
        if($thing->user_id != $_SESSION['user_id']){
          redirect('things');
        }
        
        if($this->thingModel->deleteThing($id)){
          flash('thing_message','thing removed');
          redirect('things');
        }else{
          die('somthing went wrong');
        }
      }else {
        redirect('things');
      }
    }

  }
