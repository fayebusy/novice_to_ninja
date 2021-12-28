<?php
class JokeDBRoutes {
    public function callAction($route)
    {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../classes/DatabaseTable.php';
        $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');
        if ($route === 'joke/list') {
            include __DIR__ . '/../classes/controllers/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->list();
        } elseif ($route === 'joke/edit') {
            include __DIR__ . '/../classes/controllers/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->edit();
        } elseif ($route === 'joke/delete') {
            include __DIR__ . '/../classes/controllers/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->delete();
        } elseif ($route === 'register') {
            include __DIR__ . '/../classes/controllers/RegisterController.php';
            $controller = new RegisterController($authorsTable);
            $page = $controller->showForm();
        } else {
            include __DIR__ . '/../classes/controllers/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->home();
        }
        return $page;
    }
}