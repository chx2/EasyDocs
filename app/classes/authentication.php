<?php
/*
  Easy Docs by Chris H.

  Authentication Class
  Used to handle logging
*/
namespace chx2;

class Authentication {

  protected $admin;
  protected $user;
  protected $valid_user;
  protected $valid_pass;

  public function __construct($input) {

    $this->users = $input['settings']['users'];

  }

  public function isLoggedIn() {
    return isset($_SESSION['logged_in']);
  }

  public function login() {
    $data = array_map('htmlspecialchars',$_POST);
    $this->valid_user = (isset($data['username']) ? $data['username'] : '');
    $this->valid_pass = (isset($data['password']) ? $data['password'] : '');
    if (isset($this->users[$this->valid_user]) && $this->valid_pass === $this->users[$this->valid_user]['password']) {
      if ($this->users[$this->valid_user]['role'] === 'admin') {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $this->valid_user;
        $this->loggedIn();
      }
      else {
        $_SESSION['logged_user'] = true;
        $_SESSION['user'] = $this->valid_user;
        $this->loggedUser();
      }
    }
    else {
      $_SESSION['error'] = 'You have provided incorrect login credentials';
      header('Location: ' . BASE_URL . '/login');
    }
  }

  public function isUser() {
    $data = array_map('htmlspecialchars',$_POST);
    $this->valid_user = (isset($data['username']) ? $data['username'] : '');
    $this->valid_pass = (isset($data['password']) ? $data['password'] : '');
    if (isset($this->user[$this->valid_user]) && $this->valid_pass === $this->user[$this->valid_user]) {
      return true;
    }
    else {
      return false;
    }
  }

  public function isLoggedUser() {
    return isset($_SESSION['logged_user']);
  }

  public function loggedUser() {
    header('Location: ' . BASE_URL);
  }

  public function loggedIn() {
    header('Location: ' . BASE_URL . '/dashboard');
  }

  public function notLoggedIn() {
    $_SESSION['error'] = 'You are not logged in';
    header('Location: ' . BASE_URL . '/login');
  }

  public function logout() {
    session_destroy();
    header('Location: ' . BASE_URL . '/login');
  }

  //Check if admin in preview mode
  public function isPreview() {
    $preview = isset($_GET['preview']) ? htmlspecialchars($_GET['preview']) : null;
    if (isset($_SESSION['logged_in']) && ($preview)) {
      return true;
    }
    else {
      return false;
    }
  }

}
