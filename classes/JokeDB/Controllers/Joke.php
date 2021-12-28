<?php
namespace JokeDB\Controllers;
class Joke
{
    private $authorsTable;
    private $jokesTable;
    public function __construct( \Youtech\DatabaseTable $jokesTable,\Youtech\DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
        $this->jokesTable = $jokesTable;
    }
    public function home()
    {
        $title = 'Internet Joke Database';

        return ['template' => 'home.html.php', 'title' => $title];
    }
    public function list()
    {
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
                'email' => $author['email']
            ];
        }


        $title = 'Joke list';

        $totalJokes = $this->jokesTable->total();

        return [
            'template' => 'jokes.html.php', 
            'title' => $title,
            'variables' => [
                'totalJokes' => $totalJokes,
                'jokes' => $jokes ]
        ];

    }
    
    public function delete () {
        $this->jokesTable->delete($_POST['id']);

	    header('location: /joke/list');
    }
    public function saveEdit () {
            $joke = $_POST['joke'];
            $joke['jokedate'] = new \DateTime();
            $joke['authorId'] = 1;
    
            $this->jokesTable->save($joke);
            
            header('location: /joke/list');  
    
    }
    public function edit (){
        
    
            if (isset($_GET['id'])) {
                $joke = $this->jokesTable->findById($_GET['id']);
            }
    
            $title = 'Edit joke';
    
            return [
                'template' => 'editjoke.html.php', 
                'title' => $title,
                'variables' => [
                    'joke' => $joke ?? null ]
            ];
        
    }
}