<?php 
$file = new SplFileObject('lista.csv');

print 'forma 1: ' . PHP_EOL;
while (!$file->eof()) {
  	print 'linha: ' . $file->fgetcsv();

  } 

  print '<br><br>';

  print 'forma 2 <br>';

  foreach ($file as $linha => $conteudo) {
   	print "$linha: $conteudo <br>";
   } 


 ?>