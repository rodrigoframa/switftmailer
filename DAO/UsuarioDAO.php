<?php
include_once('Usuario.php');
 
class UsuarioDAO {
 
    private $conn;
 
    public function __construct() {
        $registry = Registry::getInstance();
        $this->conn = $registry->get('Connection');
    }
 
    // public function insert(Usuario $usuario) {
    //     $this->conn->beginTransaction();
 
    //     try {
    //         $stmt = $this->conn->prepare(
    //             'INSERT INTO usuarios (nome, email) VALUES (:nome, :email)'
    //         );
 
    //         $stmt->bindValue(':nome', $usuario->getNome());
    //         $stmt->bindValue(':email', $usuario->getEmail());
    //         $stmt->execute();
 
    //         $this->conn->commit();
    //     }
    //     catch(Exception $e) {
    //         $this->conn->rollback();
    //     }
    // }
 
    public function getAll() {
        $statement = $this->conn->query(
            'SELECT * FROM usuarios'
        );
 
        return $this->processResults($statement);
    }
 
    private function processResults($statement) {
        $results = array();
 
        if($statement) {
            while($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $usuario = new Usuario();
 
                $usuario->setId($row->id);
                $usuario->setNome($row->nome);
                $usuario->setEmail($row->email);
                $usuario->setCpf($row->cpf);
 
 
                $results[] = $usuario;
            }
        }
 
        return $results;
    }
 
}
?>