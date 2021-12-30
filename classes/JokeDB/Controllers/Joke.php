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
    private DatabaseTable $jokeCategoriesTable;
    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, DatabaseTable $categoriesTable, DatabaseTable $jokeCategoriesTable, Authentication $authentication)
    {
        $this->authorsTable = $authorsTable;
        $this->jokesTable = $jokesTable;
        $this->authentication = $authentication;
        $this->categoriesTable = $categoriesTable;
        $this->jokeCategoriesTable = $jokeCategoriesTable;
    }
    public function home()
    {
        $title = 'Internet Joke Database';

        return ['template' => 'home.html.php', 'title' => $title];
    }
    public function list()
    {
        if (isset($_GET['category'])) {
            $category = $this->categoriesTable->findById($_GET['category']);
            $jokes = $category->getJokes();
        } else {
            $jokes = $this->jokesTable->findAll();
        }
        // $jokes = $this->jokesTable->findAll();
        $title = (isset($_GET['category']) ? $this->categoriesTable->findById($_GET['category'])->name . " " : "") . 'Joke list';
        $totalJokes = $this->jokesTable->total();
        $author = $this->authentication->getUser();
        return [
            'template' => 'jokes.html.php', 'title' => $title,
            'variables' => [
                'totalJokes' => $totalJokes,
                'jokes' => $jokes,
                'userId' => $author->id ?? null,
                'categories' => $this->categoriesTable->findAll()
            ]
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
        $jokeEntity->clearCategories();
        foreach ($_POST['category'] as $categoryId) {
            $jokeEntity->addCategory($categoryId);
        }
        header('location: /joke/list');
    }
    public function error()
    {
        return [
            'template' => 'permisionerror.html.php',
            'title' => 'Access restricted'
        ];
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
