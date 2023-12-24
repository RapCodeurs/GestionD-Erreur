<?php

set_error_handler(function($errno, $errstr, $errfile, $errline){
    // Personaliser le rapport d'erreur
    echo "Génération du rapport d'erreur..." . PHP_EOL ."<br>";
    // Executer du code personalisé. Echouer avec grace.

    if($errno === E_WARNING){
        exit();
    }

});


try{
    require 'foo.php';
    echo "Exercutez le fichier !". PHP_EOL;
}catch(Error $e){
    echo "Le fichier ne peut pas etre executé !". PHP_EOL . "<br>";

}

echo "l'execution continue ici". PHP_EOL;

