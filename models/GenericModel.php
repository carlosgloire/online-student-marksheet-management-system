<?php
// models/GenericModel.php

class GenericModel {
    protected $pdo;
    protected $table;

    public function __construct(PDO $pdo, $table) {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

//A class model to joign two tables using LEFT JOIN
class Joiningtables {
    protected $pdo;
    protected $first_table;
    protected $second_table;
    protected $pk;
    protected $fk;
    public function __construct(PDO $pdo, $first_table,$second_table,$fk) {
        $this->pdo = $pdo;
        $this->first_table = $first_table;
        $this->second_table = $second_table;
        $this->fk=$fk;
    }

    public function getAll() {
        $query = "SELECT ft.*, st.* FROM {$this->first_table} ft LEFT JOIN {$this->second_table} st ON st.{$this->fk} = ft.{$this->fk}";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

class GettingId {
    protected PDO $pdo;
    protected string $table;
    protected string $idColumn;

    public function __construct(PDO $pdo, string $table, string $idColumn) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->idColumn = $idColumn;
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE {$this->idColumn} = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$id]);
        
        
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

?>

