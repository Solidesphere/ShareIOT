<?php
 class Thing {
    private $db;

    public function __construct(){
        $this->db = new Database(); 
    }

    public function getThings(){
        $this->db->query('SELECT *,
                          things.id as thingId,
                          users.id as userId,
                          things.name as thingName,
                          things.created_at as thingCreated,
                          users.created_at as userCreated
                          FROM things
                          INNER JOIN users
                          ON things.user_id = users.id
                          ORDER BY things.created_at DESC
                          ');

        $results =  $this->db->resultSet();
        return $results;
    }
    public function addThing($data){
        $this->db->query('INSERT INTO things(name,user_id,baseHost, type) VALUES(:name,:user_id, :baseHost, :type)');
            //Bind values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':baseHost', $data['baseHost']);
            $this->db->bind(':type', $data['type']);

            // excute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
    }
    public function updateThing($data){
        $this->db->query('UPDATE things SET name = :name,baseHost = :baseHost,type = :type WHERE id = :id');
            //Bind values
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':baseHost', $data['baseHost']);
            $this->db->bind(':type', $data['type']);

            // excute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
    }

    public function getThingById($id){
    $this->db->query('SELECT * FROM things WHERE id = :id ');
    $this->db->bind(':id', $id);
    $row = $this->db->single();
    return $row;
    }

    public function deleteThing($id){
        $this->db->query('DELETE FROM things WHERE id = :id');
            //Bind values
            $this->db->bind(':id', $id);
            // excute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
    }
 }
