<?php
include_once('Registry.php');
include_once('dao/UsuarioDAO.php');
include_once('model/Usuario.php');
 
// Instanciar uma conexão com PDO
$conn = new PDO(
    'mysql:host=localhost;port=3306;dbname=pdoemail', 'root', ''
);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
// Armazenar essa instância no Registry
$registry = Registry::getInstance();
$registry->set('Connection', $conn);
 
// // Instanciar um novo Usuario e setar informações
// $primeiroUsuario = new Usuario();
// $primeiroUsuario->setNome('Rodrigo Frazão');
// $primeiroUsuario->setEmail('rodrigoframa@gmail.com');
 
// // Instanciar um novo Usuario e setar informações
// $segundoUsuario = new Usuario();
// $segundoUsuario->setNome('Alfredo Júnior');
// $segundoUsuario->setEmail('alfredooliveira.uema.dpd@gmail.com');
 
// Instanciar o DAO e trabalhar com os métodos
$usuarioDAO = new UsuarioDAO();
// $usuarioDAO->insert($primeiroUsuario);
// $usuarioDAO->insert($segundoUsuario);
 
// Resgatar todos os registros e iterar
$results = $usuarioDAO->getAll();
foreach($results as $usuario) {
    echo $usuario->getNome() . '<br />';
    echo $usuario->getEmail() . '<br />';
    echo '<br />';
}
?>