<?php
namespace chx2;

class Navigation {

  public $tree;
  public $navigation;

  private $active;

  public function __construct($tree,$active = '') {
    $this->tree = $tree;
    $this->active = $active;
  }

  public function branch() {
    foreach($this->tree as $key => $value) {
      $this->navigation .= '<p class="menu-label">' . $key . '</p>';
      $this->navigation .= '<ul class="menu-list">';
      foreach($this->tree[$key] as $branch) {
        if (strtolower($this->active) === strtolower($branch)) {
          $this->navigation .= '<li><a class="is-active" href="'.BASE_URL .'/'. strtolower($key) .'/'. strtolower($branch).'">'.$branch.'</a><li>';
        }
        else {
          $this->navigation .= '<li><a href="'.BASE_URL .'/'. strtolower($key) .'/'. strtolower($branch).'">'.$branch.'</a><li>';
        }
      }
      $this->navigation .= "</ul>";
    }
  }

}
