<?php
// Exemplo de scrip para exibir os nomes obtidos no arquivo CSV de exemplo

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
        echo $registro['Nome'].' - 21 '.$registro['email'].'<br>';
    }
    fclose($f);
    echo '<br><br>';

    
}