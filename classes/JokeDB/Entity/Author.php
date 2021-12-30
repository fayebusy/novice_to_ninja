<?php

namespace JokeDB\Entity;

class Author
{
    public $id;
    public $name;
    public $email;
    public $password;
    private $jokesTable;
    public function __construct(\Youtech\DatabaseTable $jokesTable)
    {
        $this->jokesTable = $jokesTable;
    }
    public function getJokes()
    {
        return $this->jokesTable->find('authorId', $this->id);
    }
    public function addJoke($joke)
    {
        $joke['authorId'] = $this->id;
        return $this->jokesTable->save($joke);
    }
}
