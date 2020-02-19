<?php
namespace chx2;

/*
  Easy Docs by Chris H.

  Sorter Class
  Used to handle resorting/bundling of section items
*/
class Sorter {

  public $list;
  public $sorted;

  private $key;

  public function __construct($list) {
    $this->list = $list;
    $this->sorted = $this->escapeWalk();
    $this->key = key($this->sorted);
  }

  //Resort documents
  public function sort() {
    $this->list['pages'][$this->key] = $this->sorted[$this->key];
  }

  //Escape document arraypost
  private function escapeWalk() {
    foreach ($_POST as $item) {
      if (is_array($item)) {
        foreach ($item as $value) {
          htmlspecialchars($value);
        }
      }
      else {
        htmlspecialchars($item);
      }
    }
    return $_POST;
  }

}
