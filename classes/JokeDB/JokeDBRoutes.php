<?php

namespace JokeDB;

class JokeDBRoutes implements \Youtech\Routes
{
    public function getRoutes()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $jokesTable = new \Youtech\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Youtech\DatabaseTable($pdo, 'author', 'id');
        $jokeController = new \JokeDB\Controllers\Joke($jokesTable, $authorsTable);
        $routes = [
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit'
                ]
            ],
            'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'delete'
                ]
            ],
            'joke/list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'list'
                ]
            ],
            '' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'home'
                ],

            ]
        ];
        return $routes;
    }
}
