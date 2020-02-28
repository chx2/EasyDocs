<?php
namespace chx2;
use Symfony\Component\Yaml\Yaml;
/*
  Easy Docs by Chris H.

  Tool Class
  Misc. tool package for helping out a little bit
*/
class Tool {

  protected $action;

  public $list;
  public $data;

  public function __construct($list = array(),$action = null) {
    $this->action = (isset($_GET['action'])) ? htmlspecialchars($_GET['action']) : $action;
    $this->list = $list;
    $this->data = $data = array_map('htmlspecialchars', $_POST) ?: null;
  }

  public function run() {
    call_user_func(array($this,$this->action));
    $yaml = Yaml::dump($this->list);
    file_put_contents(CONFIG_URI, $yaml);
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

  //Export requested sections as a combined zip file
  private function export() {
    //Get filelist
    $files = $this->tree('docs');

    //Create ZIP
    $name = 'documentation.zip';
    $zip = new \ZipArchive;
    $zip->open($name, \ZipArchive::CREATE);

    //Add Files to Zip
    foreach ($this->data as $key => $value) {
      //Spaces are converted to _, conver them back
      $new = str_replace("_", " ", $key);
      if (isset($files[$new])) {
        foreach($files[$new] as $file) {
          $zip->addFile('docs/'. $new . '/' . $file . '.md');
        }
      }
    }
    $zip->close();

    //File Headers
    header('Content-type: application/zip');
    header('Content-Disposition: attachment; filename="'.$name.'"');
    header('Content-Length: ' . filesize($name));

    //Serve, Close, then remove ZIP archive
    flush();
    readfile($name);
    unlink($name);
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
