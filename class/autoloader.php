<?php

spl_autoload_register(function ($className) {
    // Convertit les antislashes en slashs dans le nom de classe
    $className = str_replace('\\', '/', $className);

    // Chemin vers le répertoire des classes
    $classPath = './class/' . $className . '.class.php';

    // Vérifie si le fichier de classe existe
    if (file_exists($classPath)) {
        require_once $classPath;
    }
});

?>