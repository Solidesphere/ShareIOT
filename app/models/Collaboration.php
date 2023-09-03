<?php
 class Collaboration {
    private $db;

    public function __construct(){
        $this->db = new Database(); 
    }

    public function getCollaborations(){
        $this->db->query('SELECT *,
                          collaborations.id as collaborationId,
                          users.id as userId,
                          collaborations.title as collaborationTitle,
                          collaborations.created_at as collaborationCreated,
                          collaborations.baseHost_capteur as baseHost_capteur,
                          collaborations.baseHost_actionneur as baseHost_actionneur,
                          collaborations.capteur as capteur,
                          collaborations.actionneur as actionneur,
                          collaborations.idRelay as idRelay,
                          collaborations.condi as condi,
                          collaborations.valeur_capteur as valeur_capteur,
                          collaborations.valeur_actionneur as valeur_actionneur,
                          users.created_at as userCreated
                          
                          FROM collaborations
                          INNER JOIN users
                          ON collaborations.user_id = users.id
                          ORDER BY collaborations.created_at DESC
                          ');

        $results =  $this->db->resultSet();
        return $results;
    }

    public function addCollaboration($data){

        $this->db->query('INSERT INTO collaborations(title, user_id,baseHost_capteur, baseHost_actionneur, capteur, actionneur, idRelay, condi, valeur_capteur, valeur_actionneur) VALUES(:title, :user_id,:baseHost_capteur,:baseHost_actionneur, :capteur, :actionneur, :idRelay, :condi, :valeur_capteur, :valeur_actionneur)');
        //Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':baseHost_capteur', $data['baseHost_capteur']);
        $this->db->bind(':baseHost_actionneur', $data['baseHost_actionneur']);
        $this->db->bind(':capteur', $data['capteur']);
        $this->db->bind(':actionneur', $data['actionneur']);
        $this->db->bind(':idRelay', $data['idRelay']);
        $this->db->bind(':condi', $data['condi']);
        $this->db->bind(':valeur_capteur', $data['valeur_capteur']);
        $this->db->bind(':valeur_actionneur', $data['valeur_actionneur']);
        
        // excute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getCollaborationById($id){
    $this->db->query('SELECT * FROM collaborations WHERE id = :id ');
    $this->db->bind(':id', $id);
    $row = $this->db->single();
    return $row;
    }

    public function updateCollaboration($data){
    $this->db->query('UPDATE collaborations SET title = :title, baseHost_capteur = :baseHost_capteur, baseHost_actionneur = :baseHost_actionneur, capteur = :capteur, actionneur = :actionneur, idRelay = :idRelay, condi = :condi, valeur_capteur = :valeur_capteur, valeur_actionneur = :valeur_actionneur WHERE id = :id');
        
        //Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':baseHost_capteur', $data['baseHost_capteur']);
        $this->db->bind(':baseHost_actionneur', $data['baseHost_actionneur']);
        $this->db->bind(':capteur', $data['capteur']);
        $this->db->bind(':actionneur', $data['actionneur']);
        $this->db->bind(':idRelay', $data['idRelay']);
        $this->db->bind(':condi', $data['condi']);
        $this->db->bind(':valeur_capteur', $data['valeur_capteur']);
        $this->db->bind(':valeur_actionneur', $data['valeur_actionneur']);
        // excute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function deleteCollaboration($id){
        $this->db->query('DELETE FROM collaborations WHERE id = :id');
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