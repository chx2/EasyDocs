<?php
/*
  Easy Docs by Chris H.

  Settings Class
  Used to handle application settings
*/
namespace chx2;
use Symfony\Component\Yaml\Yaml;

class Settings {

  public $data;
  public $file;

  public $list;

  public function __construct($settings) {

    $this->data = array_map('htmlspecialchars', $_POST);
    $this->list = $settings;

    //Theme upload, private mode, update theme
    if (isset($_FILES['newtheme']['name'])) {
      $this->addTheme();
    }
    else if (isset($this->data['theme'])) {
      $this->updateTheme();
    }
    else if (isset($this->data['action'])) {
      $user = new User($this->data,$this->list);
      $this->list = $user->userList();
    }
    else {
      if (isset($this->data['private'])) {
      $this->updatePrivate(true);
      }
      else {
        $this->updatePrivate(false);
      }
    }

    $yaml = Yaml::dump($this->list, 2);
    file_put_contents(CONFIG_URI, $yaml);
    header('Location: settings');

  }

  //Uploaded the zipped theme if exists
  public function addTheme() {

    //Map upload info
    $filename = $_FILES["newtheme"]["name"];
  	$source = $_FILES["newtheme"]["tmp_name"];
  	$type = $_FILES["newtheme"]["type"];
    $name = explode(".", $filename);

    //Check if the file is a zipped folder
    $accept = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
  	foreach($accept as $mime) {
      if($mime == $type) {
        $okay = true;
        break;
      }
  	}

    //Not a zip file
    if (isset($name[1])) {
      $continue = strtolower($name[1]) == 'zip' ? true : false;
    }
    else {
      $continue = false;
    }
    if(!$continue) {
      $_SESSION['error'] = 'The file you are trying to upload is not a .zip file. Please try again.';
      header('Location: settings');
      exit();
    }

    //Try to upload, move to the theme folder, then unzip the contents
    $target_path = THEME_DIR.$filename;
  	if(move_uploaded_file($source, $target_path)) {
  		$zip = new \ZipArchive;
  		$x = $zip->open($target_path);
  		if ($x === true) {
  			$zip->extractTo(THEME_DIR);
  			$zip->close();
  			unlink($target_path);
  		}
      $_SESSION['success'] = 'Your theme has been uploaded!';
      header('Location: settings');
  	}
    else {
      $_SESSION['error'] = 'Your theme could not be uploaded.';
      header('Location: settings');
  	}

  }

  public function updateTheme() {
    $this->list['settings']['theme'] = $this->data['theme'];
  }

  public function updatePrivate($switch) {
    if ($switch) {
      $this->list['settings']['private'] = true;
      $_SESSION['success'] = 'Private mode has been enabled!';
    }
    else {
      $this->list['settings']['private'] = false;
      $_SESSION['success'] = 'Private mode has been disabled!';
    }
  }
}
