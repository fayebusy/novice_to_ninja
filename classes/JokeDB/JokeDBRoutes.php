<?php
namespace JokeDB;
class JokeDBRoutes {
    public function callAction($route)
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $jokesTable = new \Youtech\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Youtech\DatabaseTable($pdo, 'author', 'id');
        if ($route === 'joke/list') {
            $controller = new \JokeDB\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->list();
        } elseif ($route === 'joke/edit') {
            $controller = new \JokeDB\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->edit();
        } elseif ($route === 'joke/delete') {
            $controller = new \JokeDB\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->delete();
        } elseif ($route === 'register') {
            $controller = new \JokeDB\Controllers\Register($authorsTable);
            $page = $controller->showForm();
        } else {
            $controller = new \JokeDB\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->home();
        }
        return $page;
    }
}