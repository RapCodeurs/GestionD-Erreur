<?php
try {
	//On lance une exception du type de base Exception
	throw new Exception('Pas une Exception de type PDO !');
	//Lève une exception PDOException si la connexion à la base échoue
	$pdo = new PDO('mysql://host=foo;dbname=bar');
} catch (PDOException $e) {
	//L'exception est attrapée par ce premier bloc qui match l'Exception
	echo 'PDOException attrapée. Traitement.' . PHP_EOL;
} catch (Exception $e) {
	echo 'Exception attrapée. Traitement.' . PHP_EOL;
} finally {
	echo 'On exécute toujours ce bloc de code, peu importe l\'exception attrapée.' . PHP_EOL;
}


/*
Creer ses propores exceptions

class MyException extends Exception
{
    public __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        //Votre logique…
    }
}
throw new MyException();

*/
