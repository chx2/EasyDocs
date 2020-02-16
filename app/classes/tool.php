<?php
namespace chx2;
/*
  Easy Docs by Chris H.

  Tool Class
  Misc. tool package for helping out a little bit
*/
class Tool {

  protected $action;

  public $list;

  public function __construct($list = array(),$action = null) {
    $this->action = (isset($_GET['action'])) ? htmlspecialchars($_GET['action']) : $action;
    $this->list = $list;
  }

  public function run() {
    call_user_func(array($this,$this->action));
  }

  //Clear cache
  private function cache() {
    $files = glob('cache/*');
    foreach($files as $file) {
      unlink($file);
    }
    $_SESSION['success'] = 'Cache has been cleared!';
    header('Location: dashboard');
  }

  //Repopulate document list
  private function scan() {
    $files = $this->tree('docs');
    unset($this->list['pages']);
    $this->list['pages'] = $files;
    $_SESSION['success'] = 'File listings have been updated!';
    header('Location: dashboard');
  }

  //Map entire directory as array
  private function tree($dir) {
    $files = array_map('basename', glob($dir . '/*'));
    foreach($files as $file) {
      if(is_dir($dir . '/' . $file)) {
        $return[pathinfo($file, PATHINFO_FILENAME)] = $this->tree($dir . '/' . pathinfo($file, PATHINFO_FILENAME));
      }
      else {
        $return[] = pathinfo($file, PATHINFO_FILENAME);
      }
    }
    return $return;
  }

}
