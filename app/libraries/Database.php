<?php
 /*
  *PDO database calss
  *connect to database
  *creat prepared statement 
  *bind values
  *retun rows and result
  */

  class Database {
    private $host = DB_HOST; 
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;


    public function __construct() {
        //set DSN

        $dsn = 'mysql:host='. $this->host . ';dbname='. $this->dbname;
        $options = array(
           PDO:: ATTR_PERSISTENT => true,
           PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
        );
        //Creat PDO instance
        try{     
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }


    // prepare statment with query 
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }
    // Bind values
    public function bind($param,$value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;                   
            }
        }
        $this->stmt->bindValue($param, $value,$type);
    }
    // execute the prepared statment 
    public function execute(){
        return $this->stmt->execute();
    }
    // GET result set as array of object 
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    //GET single record as object
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    //Get row count 
    public function rowCount(){
       return $this->stmt->rowCount(); 
    }

    public function resultSetJson(){
          
        return json_encode($this->stmt->fetchAll(PDO::FETCH_OBJ));
     }

  }
