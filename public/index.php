<?php

try {
    include __DIR__ . '/../classes/EntryPoint.php';
    include __DIR__ . '/../classes/JokeDBRoutes.php';

    
    //if no route variable is set, use 'joke/home' 
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    $entryPoint = new EntryPoint($route,new JokeDBRoutes());
    $entryPoint->run();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}
