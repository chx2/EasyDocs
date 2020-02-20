<?php
namespace chx2;
/*
  Easy Docs by Chris H.

  Authentication Class
  Used to handle logging
*/
class Authentication {

  protected $input;
  protected $valid_user;
  protected $valid_pass;

  public function __construct($input) {

    $this->input = $input['settings']['users'];

  }

  public function login() {
    $data = array_map('htmlspecialchars',$_POST);
    $this->valid_user = (isset($data['username']) ? $data['username'] : '');
    $this->valid_pass = (isset($data['password']) ? $data['password'] : '');
    if (isset($this->input[$this->valid_user]) && $this->valid_pass === $this->input[$this->valid_user]) {
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

  public function LoggedIn() {
    header('Location: dashboard');
  }

  public function NotLoggedIn() {
    $_SESSION['error'] = 'You are not logged in';
    header('Location: login');
  }

  public function logout() {
    session_destroy();
    header('Location: login');
  }

}
