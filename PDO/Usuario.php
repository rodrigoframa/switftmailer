<?php
class Usuario {
 
    private $id;
    private $nome;
    private $email;
 
    public function getId() {
        return $this->id;
    }
 
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
 
    public function getNome() {
        return $this->nome;
    }
 
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }
 
    public function getEmail() {
        return $this->email;
    }
 
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
 
}
?>