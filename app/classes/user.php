<?php
namespace chx2;
use Symfony\Component\Yaml\Yaml;

class User {

  public $users;

  public function __construct($users,$list) {
    $this->users = $users;
    $action = $this->users['action'];
    unset($this->users['action']);
    $this->list = $list;
    call_user_func(array($this,$action));
  }

  public function userList() {
    return $this->list;
  }

  public function add() {
    $type = $this->users['type'];
    if (!isset($this->list['settings']['users'][$this->users['username']])) {
      $this->list['settings']['users'][$this->users['username']]['password'] = $this->users['password'];
      $this->list['settings']['users'][$this->users['username']]['role'] = $type;
      $_SESSION['success'] = 'User has been added!';
    }
    else {
      $_SESSION['error'] = 'This user already exists.';
    }
  }

}
