<?php
namespace chx2;
/*
  Easy Docs by Chris H.

  Authentication Class
  Used to handle logging
*/
class Authentication {

  protected $admin;
  protected $user;
  protected $valid_user;
  protected $valid_pass;

  public function __construct($input) {

    $this->admin = $input['settings']['admin'];
    $this->user = $input['settings']['users'];

  }

  public function login() {
    $data = array_map('htmlspecialchars',$_POST);
    $this->valid_user = (isset($data['username']) ? $data['username'] : '');
    $this->valid_pass = (isset($data['password']) ? $data['password'] : '');
    if (isset($this->admin[$this->valid_user]) && $this->valid_pass === $this->admin[$this->valid_user]) {
      $_SESSION['logged_in'] = true;
      header('Location: dashboard');
    }
    else {
      $_SESSION['error'] = 'You have provided incorrect login credentials';
      header('Location: login');
    }
  }

  public function isLoggedIn() {
    return isset($_SESSION['logged_in']);
  }

  public function loginUser() {
    $data = array_map('htmlspecialchars',$_POST);
    $this->valid_user = (isset($data['username']) ? $data['username'] : '');
    $this->valid_pass = (isset($data['password']) ? $data['password'] : '');
    if (isset($this->user[$this->valid_user]) && $this->valid_pass === $this->user[$this->valid_user]) {
      $_SESSION['logged_user'] = true;
      header('Location: '. BASE_URL);
    }
    else {
      $_SESSION['error'] = 'You have provided incorrect login credentials';
      header('Location: login');
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

  public function LoggedIn() {
    header('Location: dashboard');
  }

  public function NotLoggedIn() {
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
