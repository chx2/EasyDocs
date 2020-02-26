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
    if (isset($this->sorted['sortable'])) {
      $sections = array();
      foreach($this->sorted['sortable'] as $key => $value) {
        $sections[$value] = $this->list['pages'][$value];
      }
      $this->list['pages'] = $sections;
      echo json_encode($this->list['pages'], true);
    }
    else {
      $this->list['pages'][$this->key] = $this->sorted[$this->key];
      echo 'Document order has been updated!';
    }
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
