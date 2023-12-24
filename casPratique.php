<?php

$abstracts = [
    [
    'id' => 1,
    'name' => 'git',
    'url' => 'http://git.test/abstract'
    ],
    [
    'id' => 2,
    'name' => null,
    'url' => 'http://php.test/abstract'
    ],
    [
    'id' => 3,
    'name' => 'handling-errors-best-practices',
    'url' => 'http://programming.test/abstract/handling-errors/best-pratices'
    ],
    [
    'id' => 4,
    'name' => 'geocities',
    'url' => 'geocities.test/abstract'
    ],
];

/*
1
Les abstracts invalides doivent être signalés par le lancement d'une exception de type DomainException, attrapée dans un bloc try/catch. 
Cela permettra de créer une politique de log efficace ultérieurement. 
Une URL valide contient nécessairement le schéma ‘http://’, un nom valide ne doit pas être null (absence de nom).
*/

/**
*Rapporte les abstract invalides
*@param array $abstracts Une liste d'abstracts non filtrés et potentiellement invalides
*@return array Le rapport: liste des abstracts valides, informations sur les abstracts invalides
*/

function reportAbstracts(array $abstracts): array{


    $validAbstracts = [ ];
    $invalidAbstracts = [ ];

    foreach ($abstracts as $abstract) {
        try {
            $validAbstracts[] = validAbstract($abstract);
        } catch (DomainException $e) {
            $invalidAbstracts[] = $abstract['id'];
        }
    }

    $report = sprintf("Nombre d'abstracts valides : %d/%d\n", count($invalidAbstracts), count($abstracts));
    $report .= sprintf("Liste des abstracts invalides (id): %s\n", implode(', ', $invalidAbstracts));

    return array(
        'valid' => $validAbstracts,
        'invalid' => $invalidAbstracts,
        'summary' => $report
    );
}

/**

*Retourne l'abstract s'il est valide
*@throws DomainException Si l'abstract n'est pas valide

*/

function validAbstract(array $abstract): array{

    if (!isset($abstract['id']) || !isset($abstract['name']) || !isset($abstract['url'])) {
    throw new DomainException("L'abstract n'a pas un format valide");
    }

    if ($abstract['name'] === null) {
    throw new DomainException("'Nom Indéfini");
    }

    if (!str_contains($abstract['url'], 'http://')) {
    throw new DomainException("'URL invalide");
    }

    return $abstract;
}

$result = reportAbstracts($abstracts);
echo $result['summary'];

/*
Définissez un gestionnaire d'exceptions global dans votre programme. 
Celui-ci doit écrire un log horodaté de l'erreur incluant : la date et l'heure au format y-m-d h:m:s, le message d'erreur, le code d'erreur, 
le nom du fichier où l'Exception a été levée et le numéro de ligne. 
Testez-le en lançant une exception avec le message ‘Oups !’ et le code 400 dans l’espace global.
*/

set_exception_handler(function (Exception $e) {
    $log = sprintf(
        "%s %s %s %s %s",
        date('Y-m-d h:m:s'),
        $e->getMessage(),
        $e->getCode(),
        $e->getFile(),
        $e->getLine()
    );
    echo $log;
    error_log($log, 3, 'error.log');
});
    
throw new Exception('Oups !', 400);