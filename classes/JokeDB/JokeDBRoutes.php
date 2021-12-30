<?php

namespace JokeDB;

class JokeDBRoutes implements \Youtech\Routes
{
    private $authorsTable;
    private $jokesTable;
    private $authentication;

    public function __construct()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $this->jokesTable = new \Youtech\DatabaseTable($pdo, 'joke', 'id');
        $this->authorsTable = new \Youtech\DatabaseTable($pdo, 'author', 'id','\jokeDB\Entity\Author', [$this->jokesTable]);
        $this->authentication = new \Youtech\Authentication($this->authorsTable, 'email', 'password');
    }
    public function getRoutes() : array
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $jokeController = new \JokeDB\Controllers\Joke($this->jokesTable, $this->authorsTable,$this->authentication);
        $authorController = new \JokeDB\Controllers\Register($this->authorsTable);
        $loginController = new \JokeDB\Controllers\Login($this->authentication);
        $routes = [
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit'
                ],
                'login' => true
            ],
            'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'delete'
                ],
                'login' => true
            ],
            'joke/list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'list'
                ]
            ],
            'author/register' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'registrationForm'
                ],
                'POST' => [
                    'controller' => $authorController,
                    'action' => 'registerUser'
                ],
            ],
            'author/success' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'success'
                ]
            ],
            'login'=>[
                'GET' => [
                    'controller' => $loginController, 
                    'action' => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController, 
                    'action' => 'processLogin'
                ]
            ],
            'login/success'=>[
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'success' ],
                'login' => true
            ],
            'login/error' => [
                'GET' => [
                'controller' => $loginController, 'action' => 'error'
                ]
            ],
            'logout' => [ 
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'logout' 
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
    public function getAuthentication () : \Youtech\Authentication
    {
        return $this->authentication;
    }
}
