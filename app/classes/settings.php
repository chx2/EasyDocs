<?php
namespace chx2;
use Symfony\Component\Yaml\Yaml;

class Settings {

  public $data;
  public $file;

  public $list;

  public function __construct($settings) {

    $this->data = array_map('htmlspecialchars', $_POST);
    $this->list = $settings;

    if ($_FILES['newtheme']['name']) {
      $this->addTheme();
    }
    if (isset($this->data['theme'])) {
      $this->updateTheme();
    }

    $yaml = Yaml::dump($this->list);
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
    $continue = strtolower($name[1]) == 'zip' ? true : false;
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

  public function addUser() {

  }

  public function deleteUser() {

  }

  public function updateKey() {

  }
}