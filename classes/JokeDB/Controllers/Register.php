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
    public function registerUser()
    {
        $author = $_POST['author'];
        $author['email'] = strtolower($author['email']);
        // Assume the data is valid to begin with $valid = true;
        $errors = [];
        $valid = true;
        // But if any of the fields have been left blank // set $valid to false
        if (empty($author['name'])) {
            $valid = false;
            $errors[] = 'Name cannot be blank';
        }

        if (empty($author['email'])) {
            $valid = false;
            $errors[] = 'Email cannot be blank';
        } else if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
            $$valid = false;
            $errors[] = 'Invalid email address';
        } else if (count($this->authorsTable->find('email', $author['email'])) != 0) {
            $valid = false;
            $errors[] = 'That email address is already registered';
        }
        if (empty($author['password'])) {
            $valid = false;
            $errors[] = 'Password cannot be blank';
        }
        // If $valid is still true, no fields were blank // and the data can be added
        if ($valid == true) {
            // Hash the password before saving it in the database 
            $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
            $this->authorsTable->save($author);
            header('Location: /author/success');
        } else {
            // If the data is not valid, show the form again 
            return [
                'template' => 'register.html.php',
                'title' => 'Register an account',
                'variables' => [
                    'errors' => $errors,
                    'author' => $author
                ],

            ];
        }
    }
    public function list()
    {
        $authors = $this->authorsTable->findAll();
        return [
            'template' => 'authorlist.html.php', 'title' => 'Author List',
            'variables' => [
                'authors' => $authors
            ]
        ];
    }
    public function permissions() {
        $author = $this->authorsTable->findById($_GET['id']);
        $reflected = new \ReflectionClass('\Ijdb\Entity\Author'); $constants = $reflected->getConstants();
        return ['template' => 'permissions.html.php', 'title' => 'Edit Permissions',
        'variables' => [
        'author' => $author,
        'permissions' => $constants ]
        ]; }
}
