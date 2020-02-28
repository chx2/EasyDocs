<?php
namespace chx2;
use Symfony\Component\Yaml\Yaml;

class ThemeBuilder {

  public $theme;
  public $themes = array();

  public function __construct($path) {

    //Parse select theme settings
    $this->theme = Yaml::parseFile($path);

    //Parse settings from all themes
    $list = array_filter(glob(THEME_DIR.'*'), 'is_dir');
    foreach($list as $theme) {
      $settings = Yaml::parseFile($theme.'/theme.yaml');
      if (is_array($settings)) {
        array_push($this->themes,$settings);
      }
      else {
        die('An installed theme is missing a theme file, please add/update your theme file at '. $theme);
      }
    }

  }

  //Get each theme title from its settings
  public function getThemeTitles() {
    $titles = array();
    foreach($this->themes as $theme) {
      array_push($titles, $theme['settings']['title']);
    }
    return $titles;
  }

}
