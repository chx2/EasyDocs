<?php
namespace chx2;

class Navigation {

  public $tree;
  public $navigation;

  private $section;
  private $document;

  public function __construct($tree,$section = '',$document = '') {
    $this->tree = $tree;
    $this->section = $section;
    $this->document = $document;
  }

  public function branch() {
    foreach($this->tree as $key => $value) {
      $this->navigation .= '<p class="menu-label">' . $key . '</p>';
      $this->navigation .= '<ul class="menu-list">';
      foreach($this->tree[$key] as $branch) {
        if (strtolower($this->section . $this->document) === strtolower($key . $branch)) {
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
