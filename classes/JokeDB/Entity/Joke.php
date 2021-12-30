<?php

namespace JokeDB\Entity;

class Joke
{
    public $id;
    public $authorId;
    public $jokedate;
    public $joketext;
    private $authorsTable;
    private $author;
    private $jokeCategoriesTable;
    public function __construct(
        \Youtech\DatabaseTable $authorsTable,
        \Youtech\DatabaseTable $jokeCategoriesTable)
    {
        $this->jokeCategoriesTable = $jokeCategoriesTable;
        $this->authorsTable = $authorsTable;
    }
    public function getAuthor()
    {
        if (empty($this->author)){
            $this->author = $this->authorsTable->findById($this->authorId);
        }
        return $this->author;
    }
    public function addCategory($categoryId) { 
        $jokeCat = ['jokeId' => $this->id,
        'categoryId' => $categoryId];
        $this->jokeCategoriesTable->save($jokeCat); }
}
