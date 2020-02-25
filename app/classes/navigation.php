<?php
namespace chx2;

class Navigation {

  public $tree;
  public $navigation;
  public $previous;
  public $next;

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
      $documents = count($this->tree[$key]);
      for ($i = 0;$i < $documents; $i++) {
        $branch = $this->tree[$key];
        if (strtolower($this->section . $this->document) === strtolower($key . $branch[$i])) {
          $this->previous = isset($branch[$i-1]) ? $branch[$i-1] : null;
          $this->next = isset($branch[$i+1]) ? $branch[$i+1] : null;
          $this->navigation .= '<li><a class="is-active" href="'.BASE_URL .'/'. strtolower($key) .'/'. strtolower($branch[$i]).'">'.$branch[$i].'</a><li>';
        }
        else {
          $this->navigation .= '<li><a href="'.BASE_URL .'/'. strtolower($key) .'/'. strtolower($branch[$i]).'">'.$branch[$i].'</a><li>';
        }
      }
      $this->navigation .= "</ul>";
    }
  }

}
