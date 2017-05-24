<?php
require_once 'lib/swift_required.php';
require_once 'importacsv.php';
    // $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
$transport = Swift_SmtpTransport::newInstance('smtp.office365.com', 587, 'tls')
->setUsername('rodrigomaia@aluno.uema.br')
->setPassword('!Q@W3e4r');
$mailer = Swift_Mailer::newInstance($transport);

$delimitador = ';';
$cerca = '"';

    // Abrir arquivo para leitura
$f = fopen('lista.csv', 'r');

if ($f) {

    // Ler cabecalho do arquivo
    $cabecalho = fgetcsv($f, 0, $delimitador, $cerca);

    // Enquanto nao terminar o arquivo
    while (!feof($f)) {

        // Ler uma linha do arquivo
        $linha = fgetcsv($f, 0, $delimitador, $cerca);
        if (!$linha) {
            continue;
        }

        // Montar registro com valores indexados pelo cabecalho
        $registro = array_combine($cabecalho, $linha);

        // Obtendo o nome
        echo $registro['Nome'].' - '.$registro['email'].' Status : ';

        $message = Swift_Message::newInstance('Loterias Caixa Swiftmailer')
        ->setFrom(array('rodrigomaia@aluno.uema.br' => 'Rodrigo Frazão'))
        ->setTo(array($registro['email'] => $registro['Nome']));
        $message->setBody('
            Olá '.$registro['Nome'].', não tenha medo, é só um email teste usando o Swiftmailer, tenha uma boa noite! ');
        if (!$mailer->send($message, $errors))
        {
            echo "Error:";
            print_r($errors);
        } else {
            echo "Email enviado com sucesso!<br>";
        }
    }

    fclose($f);   
}   

?>