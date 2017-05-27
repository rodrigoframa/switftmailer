<?php
require_once 'lib/swift_required.php';
require_once 'DAO/Registry.php';
require_once 'DAO/UsuarioDAO.php';
require_once 'DAO/Usuario.php';

// configuração do login e senha do email de envio ex: 'aluno@uema.br' '12345'
$usernameemail = 'rodrigomaia@aluno.uema.br';
$passwordemail = '!Q@W3e4r'; 

//Nome do usuario de envio do email 
$namesent = 'Rodrigo NTI';

// configuração do servidor do email , para gmail usar :  smtp.gmail.com, 465, ssl
$transport = Swift_SmtpTransport::newInstance('smtp.office365.com', 587, 'tls')
->setUsername($usernameemail)
->setPassword($passwordemail);
$mailer = Swift_Mailer::newInstance($transport);

// Instanciar uma conexão com PDO 
//mysql  'mysql:host=localhost;port=3306;dbname=pdoemail', 'root', ''
$conn = new PDO(
    'pgsql:host=localhost;port=5432;dbname=pdoemail', 'postgres', 'toor'
);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
// Armazenar essa instância no Registry
$registry = Registry::getInstance();
$registry->set('Connection', $conn);

// Instanciar o DAO e trabalhar com os métodos
$usuarioDAO = new UsuarioDAO();

// Resgatar todos os registros e iterar
$results = $usuarioDAO->getAll();

$totalerro = 0;
$totalsucesso = 0;
$totalenviado = 0;
foreach($results as $usuario) {
    echo $usuario->getNome() . '<br />';
    echo $usuario->getEmail() . '<br />';

    //Assunto do email
    $message = Swift_Message::newInstance('Teste Email Swiftmailer')
        ->setFrom(array($usernameemail => $namesent))
        ->setTo(array($usuario->getEmail() => $usuario->getNome()));
        //Corpo do email
        $message->setBody('
            Olá '.$usuario->getNome().' do CPF: '.$usuario->getCpf().', não tenha medo, é só um email teste usando o Swiftmailer, tenha uma boa noite! ');
        $message->attach(Swift_Attachment::fromPath('anexo/arquivo.pdf'));

        //trata se o email foi enviado ou não 
        if (!$mailer->send($message, $errors))
        {
            echo "Erro no envio do email :";
            print_r($errors);
            $totalerro++;
        } else {
            echo "Email enviado com sucesso para : ".$usuario->getEmail()."! <br><br>";
            $totalsucesso++;
        }
        $totalenviado++;

}


echo "Total de emails enviados :  ".$totalenviado."! <br>";
echo "Total de emails enviados com sucesso :  ".$totalsucesso."! <br>";
echo "Total de emails enviados com erro:  ".$totalerro."! <br>";




?>