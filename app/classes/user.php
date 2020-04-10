<?php
/*
  Easy Docs by Chris H.

  User Class
  Class for handling interactions with users
*/

namespace chx2;

use Symfony\Component\Yaml\Yaml;

class User
{

    public $users;

    public function __construct($users, $list)
    {
        $this->users = $users;
        $action = $this->users['action'];
        unset($this->users['action']);
        $this->list = $list;
        call_user_func(array($this, $action));
    }

    public function userList()
    {
        return $this->list;
    }

    public function add()
    {
        $type = $this->users['type'];
        if (!isset($this->list['settings']['users'][$this->users['username']])) {
            $this->list['settings']['users'][$this->users['username']]['password'] = $this->users['password'];
            $this->list['settings']['users'][$this->users['username']]['role'] = $type;
            $_SESSION['success'] = 'User has been added!';
        } else {
            $_SESSION['error'] = 'This user already exists.';
        }
    }

    public function delete()
    {
        if ($_SESSION['user'] === $this->users['username']) {
            $_SESSION['error'] = 'You cannot delete yourself.';
        } else {
            $_SESSION['success'] = 'User has been removed!';
            unset($this->list['settings']['users'][$this->users['username']]);
        }
    }

    public function password()
    {
        $this->list['settings']['users'][$this->users['username']]['password'] = $this->users['value'];
        $_SESSION['success'] = 'Password has been updated!';
    }

    public function username()
    {
        $this->list['settings']['users'][$this->users['value']] = $this->list['settings']['users'][$this->users['username']];
        unset($this->list['settings']['users'][$this->users['username']]);
        $_SESSION['success'] = 'Username has been updated!';
    }

    public function role()
    {
        if ($this->list['settings']['users'][$this->users['username']]['role'] === 'user') {
            $this->list['settings']['users'][$this->users['username']]['role'] = 'admin';
            $_SESSION['success'] = 'User has been promoted to admin!';
        } else {
            $this->list['settings']['users'][$this->users['username']]['role'] = 'user';
            $_SESSION['success'] = 'User has been demoted to user!';
        }
    }

}
