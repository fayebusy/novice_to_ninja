<?php

namespace Youtech;

class Authentication
{
    private $users;
    private $usernameColumn;
    private $passwordColumn;
    public function __construct(DatabaseTable $users,string $usernameColumn, string $passwordColumn)
    {
        session_start();
        $this->users = $users;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }
    public function login($username, $password)
    {
        $user = $this->users->find($this->usernameColumn, strtolower($username));
        if (!empty($user) && password_verify($password, $user[0]->{$this->passwordColumn})) {
            session_regenerate_id();
            $_SESSION['username'] = $username;
            $_SESSION['password'] =
                $user[0]->{$this->passwordColumn};
            return true;
        } else {
            return false;
        }
    }
    public function getUser() {
        if ($this->isLoggedIn()) {
        return $this->users->find($this->usernameColumn,
        strtolower($_SESSION['username']))[0]; }
            else {
                return false;
        } 
    }
    public function isLoggedIn()
    {
        if (empty($_SESSION['username'])) {
            return false;
        }
        $user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));
        // $passwordColumn = $this->passwordColumn;
        // use brace to avoid error cause php read left to right and will try to find 
        // $user->$this it will be an error
        if (!empty($user) && $user[0]->{$this->passwordColumn} === $_SESSION['password']) {
            return true;
        } else {
            return false;
        }
    }
}
