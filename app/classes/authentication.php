<?php
/*
  Easy Docs by Chris H.

  Authentication Class
  Used to handle logging
*/

namespace chx2;

/**
 * Class Authentication
 * @package chx2
 */
class Authentication
{

    protected $user;
    protected $valid_user;
    protected $valid_pass;

    /**
     * Authentication constructor.
     * @param $input
     */
    public function __construct($input)
    {
        $this->users = $input['settings']['users'];
    }

    /**
     * Check for logged in user
     * @return bool
     */
    public function isLoggedIn()
    {
        return isset($_SESSION['logged_in']);
    }

    /**
     * Execute login
     */
    public function login()
    {
        $data = array_map('htmlspecialchars', $_POST);
        $this->valid_user = (isset($data['username']) ? $data['username'] : '');
        $this->valid_pass = (isset($data['password']) ? $data['password'] : '');
        if (isset($this->users[$this->valid_user]) && $this->valid_pass === $this->users[$this->valid_user]['password']) {
            if ($this->users[$this->valid_user]['role'] === 'admin') {
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = $this->valid_user;
                $this->loggedIn();
            } else {
                $_SESSION['logged_user'] = true;
                $_SESSION['user'] = $this->valid_user;
                $this->loggedUser();
            }
        } else {
            $_SESSION['error'] = 'You have provided incorrect login credentials';
            header('Location: ' . BASE_URL . '/login');
        }
    }

    /**
     * Reader if private documentation
     * @return bool
     */
    public function isLoggedUser()
    {
        return isset($_SESSION['logged_user']);
    }

    /**
     * Redirect home
     */
    public function loggedUser()
    {
        header('Location: ' . BASE_URL);
    }

    /**
     * Dashboard redirect
     */
    public function loggedIn()
    {
        header('Location: ' . BASE_URL . '/dashboard');
    }

    /**
     * Redirect to login
     */
    public function notLoggedIn()
    {
        $_SESSION['error'] = 'You are not logged in';
        header('Location: ' . BASE_URL . '/login');
    }

    /**
     * Logout
     */
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
    }

    /**
     * In preview mode
     * @return bool
     */
    public function isPreview()
    {
        $preview = isset($_GET['preview']) ? htmlspecialchars($_GET['preview']) : null;
        return (isset($_SESSION['logged_in']) && ($preview));
    }

}
