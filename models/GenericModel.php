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
?>
