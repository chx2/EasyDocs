<?php
namespace chx2;

class Requirements {

  protected $required;

  //Application requirements, add boolean statements here
  public function __construct() {
    $this->required = array(
      'Safe Mode'                   => (ini_get('safe_mode')) ? false : true,
      'PHP 7.1.3+'                  => version_compare(PHP_VERSION, '7.1.3', '>='),
      'Document direcory writable'  => is_writable(dirname('docs')),
      'ZIP Extension Installed'     => (extension_loaded('zip'))
    );
  }

  //Check all requirement values
  public function check() {
    $failed = false;
    $failstr = '<h1>Your web server failed the basic application requires, you need the following:</h1><ul>';
    foreach($this->required as $key => $value) {
      if (!$value) {
        $failed = true;
        $failstr .= '<li>'.$key.'</li>';
      }
    }
    if ($failed) {
      $failstr .= '</ul>';
      $this->fail($failstr);
    }
  }

  //A requirement was not meant, application ends
  public function fail($message) {
    die($message);
  }
}
