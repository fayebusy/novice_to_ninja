<?php

try {
    // fonction autoload qui permet de charger automatiquement 
    // les classes sans faires d'includes
    include __DIR__ . '/../includes/autoload.php';
    /**
     * Commence a charger a partir du premier / et se termine a 
     * la fin ou stoppe au premier point d'interrogation
     */
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    $entryPoint = new \Youtech\EntryPoint($route,new \JokeDB\JokeDBRoutes());
    $entryPoint->run();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}
