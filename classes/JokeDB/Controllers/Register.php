<?php

namespace JokeDB\Controllers;

class Register
{
    private \Youtech\DatabaseTable $authorsTable;
    public function __construct(\Youtech\DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }
    public function registrationForm()
    {
        return ['template' => 'register.html.php', 'title' => 'Register an account'];
    }
    public function success()
    {
        return ['template' => 'registersuccess.html.php', 'title' => 'Registration Successful'];
    }
    public function registerUser() { 
        $author = $_POST['author'];
        $this->authorsTable->save($author);
        header('Location: /author/success'); 
    }
}
