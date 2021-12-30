<?php

namespace JokeDB\Controllers;

use \Youtech\DatabaseTable;
use \Youtech\Authentication;

class Joke
{

    private DatabaseTable $authorsTable;
    private DatabaseTable $jokesTable;
    private Authentication $authentication;
    private DatabaseTable $categoriesTable;
    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, DatabaseTable $categoriesTable, Authentication $authentication)
    {
        $this->authorsTable = $authorsTable;
        $this->jokesTable = $jokesTable;
        $this->authentication = $authentication;
        $this->categoriesTable = $categoriesTable;
    }
    public function home()
    {
        $title = 'Internet Joke Database';

        return ['template' => 'home.html.php', 'title' => $title];
    }
    public function list()
    {
        $jokes = $this->jokesTable->findAll();
        $title = 'Joke list';

        $totalJokes = $this->jokesTable->total();
        $author = $this->authentication->getUser();
        return [
            'template' => 'jokes.html.php',
            'title' => $title,
            'variables' => [
                'totalJokes' => $totalJokes,
                'jokes' => $jokes,
                'userId' => $author->id ?? null
            ],

        ];
    }
    public function delete()
    {
        $author = $this->authentication->getUser();
        $joke = $this->jokesTable->findById($_POST['id']);
        if ($joke->authorId != $author->id) return;

        $this->jokesTable->delete($_POST['id']);

        header('location: /joke/list');
    }
    public function saveEdit()
    {

        $author = $this->authentication->getUser();
        $joke = $_POST['joke'];
        $joke['jokedate'] = new \DateTime();
        $jokeEntity = $author->addJoke($joke);
        foreach ($_POST['category'] as $categoryId) {
            $jokeEntity->addCategory($categoryId);
        }
        header('location: /joke/list');
    }
    public function edit()
    {


        if (isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);
        }

        $title = 'Edit joke';
        $author = $this->authentication->getUser();
        $categories = $this->categoriesTable->findAll();
        return [
            'template' => 'editjoke.html.php',
            'title' => $title,
            'variables' => [
                'joke' => $joke ?? null,
                'userId' => $author->id ?? null,
                'categories' => $categories
            ]
        ];
    }
}
