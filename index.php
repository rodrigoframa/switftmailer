<?php
require_once 'lib/swift_required.php';
require_once 'PDO/Registry.php';
require_once 'PDO/UsuarioDAO.php';
require_once 'PDO/Usuario.php';

// configuração do login e senha do email de envio ex: 'aluno@uema.br' '12345'
$usernameemail = '';
$passwordemail = ''; 

//Nome do usuario de envio do email 
$namesent = '';

// configuração do servidor do email , para gmail usar :  'smtp.gmail.com', 465, 'ssl'  office365 : 'smtp.office365.com', 587, 'tls'
$transport = Swift_SmtpTransport::newInstance('smtp.office365.com', 587, 'tls')
->setUsername($usernameemail)
->setPassword($passwordemail);
$mailer = Swift_Mailer::newInstance($transport);

// Instanciar uma conexão com PDO 
$conn = new PDO(
    'mysql:host=localhost;port=3306;dbname=pdoemail', 'root', ''
);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
// Armazenar essa instância no Registry
$registry = Registry::getInstance();
$registry->set('Connection', $conn);

// Instanciar o DAO e trabalhar com os métodos
$usuarioDAO = new UsuarioDAO();

// Resgatar todos os registros e iterar
$results = $usuarioDAO->getAll();

foreach($results as $usuario) {
    echo $usuario->getNome() . '<br />';
    echo $usuario->getEmail() . '<br />';

    $message = Swift_Message::newInstance('Teste Email Swiftmailer')
        ->setFrom(array($usernameemail => $namesent))
        ->setTo(array($usuario->getEmail() => $usuario->getNome()));
        $message->setBody('
            Olá '.$usuario->getNome().', não tenha medo, é só um email teste usando o Swiftmailer, tenha uma boa noite! ');
        if (!$mailer->send($message, $errors))
        {
            echo "Erro :";
            print_r($errors);
        } else {
            echo "Email enviado com sucesso para : ".$usuario->getEmail()."! <br><br>";
        }

}




?>