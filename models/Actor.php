<?php
require_once('../../utils/databaseConnection.php');

  class Actor{
    private $id;
    private $name;
    private $surnames;
    private $birthDate;
    private $nacionality;

    public function __construct($actorId, $actorName, $actorSurnames, $actorBirthDate, $actorNacionality) {
      $this->id = $actorId;
      $this->name = $actorName;
      $this->surnames = $actorSurnames;
      $this->birthDate = $actorBirthDate;
      $this->nacionality = $actorNacionality;
    }

    public function getId() {
      return $this->id;
    }
    
    public function setId($newId) {
      $this->id = $newId;
    }

    public function getName() {
      return $this->name;
    }
    
    public function setName($newName) {
      $this->name = $newName;
    }

    public function getSurnames() {
      return $this->surnames;
    }
    
    public function setSurnames($newSurnames) {
      $this->surnames = $newSurnames;
    }

    public function getBirthDate() {
      return $this->birthDate;
    }
    
    public function setBirthDate($newBirthDate) {
      $this->birthDate = $newBirthDate;
    }

    public function getNacionality() {
      return $this->nacionality;
    }
    
    public function setNacionality($newNacionality) {
      $this->nacionality = $newNacionality;
    }

    public static function getAllActors() {
      $mysql = initConnectionDb();
      $query = $mysql->query("SELECT * FROM actors");

      $actorList = [];
  
      foreach($query as $item) {
        $actor = new Actor($item['id'], $item['name'], $item['surnames'], $item['birth_date'], $item['nacionality']);
        array_push($actorList, $actor);
      }

      $mysql->close();

      return $actorList;
    }

    public static function deleteActor($id) {
      $isSuccess = false;
      $mysql = initConnectionDb();

      // Nos aseguramos de que el actor existe para intentar borrar
      if(Actor:: getSingleActor($id)){
        //Hacemos try catch, en caso de que se quiera borrar y tenga una serie asociada, salta una excepción.
        try { 
          $query = $mysql->query("DELETE FROM actors WHERE id=".$id);
          $isSuccess = $query === TRUE;
        }
        catch (Exception $e) {
          $isSuccess = false;
        }
      }

      $mysql->close();

      return $isSuccess;
    }

    public static function getSingleActor($actorId) {
      $actor = null;
      $mysql = initConnectionDb();

      $query = $mysql->query("SELECT * FROM actors WHERE id=".$actorId);

      foreach($query as $item) {
        $actor = new Actor($item['id'],$item['name'], $item['surnames'],$item['birth_date'],$item['nacionality']);
        break;
      }

      $mysql->close();

      return $actor;
    }

    public function editActor() {
      $mysql = initConnectionDb();
      $isSuccess = false;

      // Comprueba que exista el objeto con ese id.
      if(Actor::getSingleActor($this->id)) {
        $birthDateCheck = $this->birthDate ? "'$this->birthDate'": 'NULL';
        $nacionalityCheck = $this->nacionality ? "'$this->nacionality'": 'NULL';
  
        $query = "UPDATE actors SET name='$this->name', surnames='$this->surnames', birth_date=".$birthDateCheck.", nacionality =".$nacionalityCheck." WHERE id=".$this->id;
        $queryResult = $mysql->query($query);
  
        $isSuccess = $queryResult === TRUE;
      }

      $mysql->close();

      return $isSuccess;
    }

    public function createActor() {
      $mysql = initConnectionDb();
      $isSuccess = false;

      // Si no hay un actor todavía con ese nombre y apellido, lo crea
      if(!$this->actorAlreadyExists()) {
        $birthDateCheck = $this->birthDate ? "'$this->birthDate'": 'NULL';
        $nacionalityCheck = $this->nacionality ? "'$this->nacionality'": 'NULL';
  
        $query = "INSERT INTO actors (name, surnames, birth_date, nacionality) VALUES ('$this->name', '$this->surnames',".$birthDateCheck.",".$nacionalityCheck.");";
        $queryResult = $mysql->query($query);
  
        $isSuccess = $queryResult === TRUE;
      }

      $mysql->close();

      return $isSuccess;
    }

    private function actorAlreadyExists() {
      $mysql = initConnectionDb();

      $query = "SELECT * FROM actors WHERE name='$this->name' AND surnames='$this->surnames';";
      $queryResult = $mysql->query($query);

      $totalElements = mysqli_num_rows( $queryResult);

      $mysql->close();

      return $totalElements > 0;
    }
  }
?>