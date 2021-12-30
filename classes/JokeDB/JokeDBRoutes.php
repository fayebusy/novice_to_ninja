<?php

namespace JokeDB;

class JokeDBRoutes implements \Youtech\Routes
{
    private $authorsTable;
    private $jokesTable;
    private $categoriesTable;
    private $authentication;
    private $jokeCategoriesTable;

    public function __construct()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $this->jokesTable = new \Youtech\DatabaseTable($pdo, 'joke', 'id', '\jokeDB\Entity\Joke', [&$this->authorsTable, &$this->jokeCategoriesTable]);
        $this->authorsTable = new \Youtech\DatabaseTable($pdo, 'author', 'id', '\jokeDB\Entity\Author', [&$this->jokesTable]);
        $this->categoriesTable = new \Youtech\DatabaseTable($pdo, 'category', 'id', '\jokeDB\Entity\Category', [&$this->jokesTable, &$this->jokeCategoriesTable]);
        $this->authentication = new \Youtech\Authentication($this->authorsTable, 'email', 'password');
        $this->jokeCategoriesTable = new \Youtech\DatabaseTable($pdo, 'joke_category', 'categoryId');
    }
    public function checkPermission($permission): bool
    {
        $user = $this->authentication->getUser();
        if ($user && $user->hasPermission($permission)) {
            return true;
        } else {
            return false;
        }
    }
    public function getRoutes(): array
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $jokeController = new \JokeDB\Controllers\Joke($this->jokesTable, $this->authorsTable, $this->categoriesTable, $this->jokeCategoriesTable, $this->authentication);
        $authorController = new \JokeDB\Controllers\Register($this->authorsTable);
        $loginController = new \JokeDB\Controllers\Login($this->authentication);
        $categoryController = new \JokeDB\Controllers\Category($this->categoriesTable);
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
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin'
                ]
            ],
            'login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'success'
                ],
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
            'category/edit' =>
            [
                'POST' => [
                    'controller' => $categoryController, 'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $categoryController, 'action' => 'edit'
                ],
                'login' => true,
                'permissions' => \JokeDB\Entity\Author::EDIT_CATEGORIES
            ],
            'category/list' => [
                'GET' => [
                    'controller' => $categoryController,
                    'action' => 'list'
                ],
                'login' => true,
                'permissions' => \JokeDB\Entity\Author::LIST_CATEGORIES
            ],
            'category/delete' => [
                'POST' => [
                    'controller' => $categoryController, 'action' => 'delete'
                ],
                'login' => true,
                'permissions' => \JokeDB\Entity\Author::REMOVE_CATEGORIES
            ],
            'author/permissions' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'permissions'
                ],
                'POST' => [
                    'controller' => $authorController, 'action' => 'savePermissions'
                ],
                'login' => true
            ],
            'author/list' => [
                'GET' => [
                    'controller' => $authorController, 'action' => 'list'
                ], 
                'login' => true
            ],
            'permission/error' => [
                'GET' => [
                    'controller' => $jokeController, 'action' => 'error'
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
    public function getAuthentication(): \Youtech\Authentication
    {
        return $this->authentication;
    }
}
