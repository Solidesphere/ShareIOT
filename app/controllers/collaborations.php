<?php

class Collaborations extends controller {
    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }
    $this->CollaborationModel = $this->model('Collaboration');
    $this->userModel = $this->model('User');
    }
    public function index(){ 

        $collaborations = $this->CollaborationModel->getCollaborations();
        $data = [
            'collaborations' => $collaborations
        ];

       $this->view('collaborations/index',$data); 
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
          // SANITIZE THE THING array
          $_COLLABORATION = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          $data = [
            'title' => trim($_COLLABORATION['title']),
            'baseHost_capteur'=> trim($_COLLABORATION['baseHost_capteur']),
            'baseHost_actionneur'=> trim($_COLLABORATION['baseHost_actionneur']),
            'capteur' => trim($_COLLABORATION['capteur']),
            'actionneur' => trim($_COLLABORATION['actionneur']),
            'valeur_capteur' => trim($_COLLABORATION['valeur_capteur']),
            'valeur_actionneur' => trim($_COLLABORATION['valeur_actionneur']),
            'idRelay' => trim($_COLLABORATION['idRelay']),
            'condi' => trim($_COLLABORATION['condi']),
            'user_id' => $_SESSION['user_id'],
            'title_err' => '',
            'baseHost_capteur_err' => '',
            'baseHost_actionneur_err'=> '',
            'capteur_err' => '',
            'actionneur_err' => '',
            'valeur_capteur_err' => '',
            'idRelay_err' => '',
            'valeur_actionneur_err' => '',
            'condi_err' => ''     
          ];
          // validate data
          if (empty($data['title'])){
            $data['title_err'] = 'Please enter the title of colaboration ';
          }
          if (empty($data['baseHost_capteur'])){
            $data['baseHost_capteur_err'] = 'Please enter the baseHost capteur ';
          }
          if (empty($data['baseHost_actionneur'])){
            $data['baseHost_actionneur_err'] = 'Please enter the baseHost actionneur';
          }
          if (empty($data['actionneur'])){
            $data['actionneur_err'] = 'Please select the actionneur';
          }
          if (empty($data['capteur'])){
            $data['capteur_err'] = 'Please select the capteur';
          }
          if (empty($data['valeur_capteur'])){
            $data['valeur_capteur_err'] = 'Please select the value of capteur';
          }
          if (empty($data['idRelay'])){
            $data['idRelay_err'] = 'Please select the id Relay';
          }
          if (empty($data['valeur_actionneur'])){
            $data['valeur_actionneur_err'] = 'Please select the value of actionneur';
          }
          if (empty($data['condi'])){
            $data['condi_err'] = 'Please select the condi';
          }
          // make sure no errors
          if(empty($data['title_err']) && empty($data['baseHost_capteur_err']) && empty($data['baseHost_actionneur_err']) && empty($data['actionneur_err']) && empty($data['capteur_err']) && empty($data['valeur_capteur_err']) && empty($data['valeur_actionneur_err']) && empty($data['idRelay_err']) && empty($data['condi_err']) && empty($data['title_err'])){
          // validated
          if($this->CollaborationModel->addCollaboration($data)){
            flash('collaboration_message', 'collaboration Added');
            redirect('collaborations');
          }else{
            die('Somthing went wrong');
          }
          }else{
            // load the view with errors 
            $this->view('collaborations/add',$data);
          }
  
        }else{
          $data = [
            'title' => '',
            'baseHost_capteur'=> '',
            'baseHost_actionneur' => '',
            'capteur' => '',
            'actionneur' => '',
            'valeur_capteur' => '',
            'idRelay' => '',
            'valeur_actionneur' => '',
            'condi' => ''
          ];
    
         $this->view('collaborations/add',$data);
        }  
      }



      public function edit($id){
        if($_SERVER['REQUEST_METHOD']=='POST'){
          // SANITIZE THE THING array
          $_COLLABORATION = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          $data = [
            'id' => $id,
            'title' => trim($_COLLABORATION['title']),
            'baseHost_capteur'=> trim($_COLLABORATION['baseHost_capteur']),
            'baseHost_actionneur'=> trim($_COLLABORATION['baseHost_actionneur']),
            'capteur' => trim($_COLLABORATION['capteur']),
            'actionneur' => trim($_COLLABORATION['actionneur']),
            'valeur_capteur' => trim($_COLLABORATION['valeur_capteur']),
            'valeur_actionneur' => trim($_COLLABORATION['valeur_actionneur']),
            'idRelay' => trim($_COLLABORATION['idRelay']),
            'condi' => trim($_COLLABORATION['condi']),
            'user_id' => $_SESSION['user_id'],
            'title_err' => '',
            'baseHost_capteur_err' => '',
            'baseHost_actionneur_err'=> '',
            'capteur_err' => '',
            'actionneur_err' => '',
            'valeur_capteur_err' => '',
            'idRelay_err' => '',
            'valeur_actionneur_err' => '',
            'condi_err' => ''     
          ];
          // validate data
          if (empty($data['title'])){
            $data['title_err'] = 'Please enter the title of colaboration ';
          }
          if (empty($data['baseHost_capteur'])){
            $data['baseHost_capteur_err'] = 'Please enter the baseHost capteur ';
          }
          if (empty($data['baseHost_actionneur'])){
            $data['baseHost_actionneur_err'] = 'Please enter the baseHost actionneur';
          }
          if (empty($data['actionneur'])){
            $data['actionneur_err'] = 'Please select the actionneur';
          }
          if (empty($data['capteur'])){
            $data['capteur_err'] = 'Please select the capteur';
          }
          if (empty($data['valeur_capteur'])){
            $data['valeur_capteur_err'] = 'Please select the value of capteur';
          }
          if (empty($data['idRelay'])){
            $data['idRelay_err'] = 'Please select the id Relay';
          }
          if (empty($data['valeur_actionneur'])){
            $data['valeur_actionneur_err'] = 'Please select the value of actionneur';
          }
          if (empty($data['condi'])){
            $data['condi_err'] = 'Please select the condi';
          }
          // make sure no errors
          if(empty($data['title_err']) && empty($data['baseHost_capteur_err']) && empty($data['baseHost_actionneur_err']) && empty($data['actionneur_err']) && empty($data['capteur_err']) && empty($data['valeur_capteur_err']) && empty($data['valeur_actionneur_err']) && empty($data['idRelay_err']) && empty($data['condi_err']) && empty($data['title_err'])){
          // validated
          if($this->CollaborationModel->updateCollaboration($data)){
            flash('collaboration_message', 'collaboration updated');
            redirect('collaborations');
          }else{
            die('Somthing went wrong');
          }
          }else{
            // load the view with errors 
            $this->view('collaborations/edit',$data);
          }
  
        }else{
            //get existing collaboration from model
            $collaboration = $this->CollaborationModel->getCollaborationById($id);
            //chek for owner
            if($collaboration->user_id != $_SESSION['user_id']){
              redirect('collaboration');
            }


          $data = [
            'id'=> $id,
            'title' => $collaboration->title,
            'baseHost_capteur'=> $collaboration->baseHost_capteur,
            'baseHost_actionneur' => $collaboration->baseHost_actionneur,
            'capteur' => $collaboration->capteur,
            'actionneur' => $collaboration->actionneur,
            'valeur_capteur' => $collaboration->valeur_capteur,
            'idRelay' => $collaboration->idRelay,
            'valeur_actionneur' => $collaboration->valeur_actionneur,
            'condi' => $collaboration->condi
          ];
    
         $this->view('collaborations/edit',$data);
        } 
         
      }

      public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          //get existing thing from model
          $collaboration = $this->CollaborationModel->getCollaborationById($id);
  
          //chek for owner
          if($collaboration->user_id != $_SESSION['user_id']){
            redirect('things');
          }
          
          if($this->CollaborationModel->deleteCollaboration($id)){
            flash('thing_message','collaboration removed');
            redirect('collaborations');
          }else{
            die('somthing went wrong');
          }
        }else {
          redirect('collaborations');
        }
      }

      public function show($id){
        $collaboration= $this->CollaborationModel->getCollaborationById($id);
        $user = $this->userModel->getUserById($collaboration->user_id);
        $data = [
          'collaboration' => $collaboration,
          'user' => $user
        ];
        $this->view('collaborations/show',$data);
      }
}
?>