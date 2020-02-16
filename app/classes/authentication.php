<?php
namespace chx2;
/*
  Easy Docs by Chris H.

  Authentication Class
  Used to handle logging
*/
class Authentication {

  protected $input_user;
  protected $input_pass;
  protected $valid_user;
  protected $valid_pass;

  public function __construct($input) {

    $this->input_user = $input['settings']['username'];
    $this->input_pass = $input['settings']['password'];

  }

  public function setup() {

    if (isset($_POST)) {
      $data = array_map('htmlspecialchars',$_POST);
      $this->valid_user = (isset($data['username']) ? $data['username'] : '');
      $this->valid_pass = (isset($data['password']) ? $data['password'] : '');
    }

  }

  public function login() {
    if ($this->input_user === $this->valid_user && $this->input_pass === $this->valid_pass) {
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
