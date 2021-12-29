<?php
namespace JokeDB\Controllers;
use \Youtech\DatabaseTable;
use \Youtech\Authentication;
class Joke {
    
    private DatabaseTable $authorsTable;
    private DatabaseTable $jokesTable;
    private Authentication $authentication;
    public function __construct( DatabaseTable $jokesTable,DatabaseTable $authorsTable,Authentication $authentication) {
        $this->authorsTable = $authorsTable;
        $this->jokesTable = $jokesTable;
        $this->authentication = $authentication;
    }
    public function home() {
        $title = 'Internet Joke Database';

        return ['template' => 'home.html.php', 'title' => $title];
    }
    public function list() {
        $result = $this->jokesTable->findAll();

        $jokes = [];
        // var_dump( $result);
        foreach ($result as $joke) {
            $author = $this->authorsTable->findById($joke['authorId']);

            $jokes[] = [
                'id' => $joke['id'],
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'name' => $author['name'],
                'email' => $author['email'],
                'authorId' => $author['id']
            ];
        }


        $title = 'Joke list';

        $totalJokes = $this->jokesTable->total();
        $author = $this->authentication->getUser();
        return [
            'template' => 'jokes.html.php', 
            'title' => $title,
            'variables' => [
                'totalJokes' => $totalJokes,
                'jokes' => $jokes,
                'userId' => $author['id'] ?? null 
            ],
                
        ];

    }
    public function delete () {
        $author = $this->authentication->getUser();
        $joke = $this->jokesTable->findById($_POST['id']);
        if ($joke['authorId'] != $author['id']) return;

        $this->jokesTable->delete($_POST['id']);

	    header('location: /joke/list');
    }
    public function saveEdit () {
        $author = $this->authentication->getUser();
        if (isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);
            if ($joke['authorId'] != $author['id'])  return;
        }
        $joke = $_POST['joke'];
        $joke['jokedate'] = new \DateTime();
        $joke['authorId'] = $author['id'];
        $this->jokesTable->save($joke);
        header('location: /joke/list');  
    }
    public function edit () {
        
    
            if (isset($_GET['id'])) {
                $joke = $this->jokesTable->findById($_GET['id']);
            }
    
            $title = 'Edit joke';
    
            return [
                'template' => 'editjoke.html.php', 
                'title' => $title,
                'variables' => [
                    'joke' => $joke ?? null,
                    'userId' => $author['id'] ?? null ]
            ];
        
    }
}
