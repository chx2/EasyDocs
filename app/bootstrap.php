<?php
/*
  Easy Docs by Chris H.

  EasyDocs allows for you to create & edit user documentation with a built-in dashboard centered around the organization of documentation under various user defined topics.
*/

//Dependencies
require 'vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

//Check application requirements, stop here if not met
$requirements = new chx2\Requirements();
$requirements->check();

//Constants
session_start();
define('BASE_URL',      (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://'.$_SERVER['HTTP_HOST'] .dirname($_SERVER['SCRIPT_NAME']));
define('CONFIG_URI',    'app/config.yaml');
define('DOC_URI',       'docs/');

//Get configuration file
try {

  //Parse Application settings
  $settings = Yaml::parseFile(CONFIG_URI);

  //Create constants from config file
  define('THEME_DIR',    'assets/themes/');
  define('THEME_PATH',    THEME_DIR.$settings['settings']['theme']);
  define('TEMPLATE_DIR',  THEME_PATH.'/templates');
  define('STYLE_DIR',     THEME_PATH.'/css');
  define('SCRIPT_DIR',    THEME_PATH.'/js');

  //Get selected & all themes
  $themelist = new chx2\ThemeBuilder(THEME_PATH.'/theme.yaml');

  //Map external and local asset files into template buffer
  $js = '';
  $css = '';
  foreach($themelist->theme['settings']['scripts']['external'] as $externaljs) {
    $js .= '<script src="' . $externaljs . '"></script>' . "\n";
  }
  foreach($themelist->theme['settings']['scripts']['local'] as $localjs) {
    $js .= '<script src="' . BASE_URL . '/' . SCRIPT_DIR . '/' . $localjs . '"></script>' . "\n";
  }
  foreach($themelist->theme['settings']['styles']['external'] as $externalcss) {
    $css .= '<link rel="stylesheet" href="' . $externalcss . '">' . "\n";
  }
  foreach($themelist->theme['settings']['styles']['local'] as $localcss) {
    $css .= '<link rel="stylesheet" href="' . BASE_URL . '/' .STYLE_DIR . '/' . $localcss . '">' . "\n";
  }

  //Map global template variables
  $template = new Smarty();
  $template->setTemplateDir(TEMPLATE_DIR)
           ->setCompileDir('cache');
  $template->assign('base_url',     BASE_URL);
  $template->assign('encoding',     $settings['settings']['encoding']);
  $template->assign('langauge',     $settings['settings']['langauge']);
  $template->assign('title',        $settings['settings']['title']);
  $template->assign('description',  $settings['settings']['description']);
  $template->assign('sections',     (isset($settings['pages']) ? $settings['pages']: null));
  $template->assign('error',        (isset($_SESSION['error']) ? $_SESSION['error'] : ''));
  $template->assign('success',      (isset($_SESSION['success']) ? $_SESSION['success'] : ''));
  $template->assign('users',        $settings['settings']['users']);
  $template->assign('themes',       $themelist->getThemeTitles());
  $template->assign('private',      $settings['settings']['private']);
  $template->assign('scripts',      $js);
  $template->assign('styles',       $css);

}
catch (Exception $e) {
  die('You have an error in your configuration file, please check the file for syntax errors');
}

//Get post data for Authentication as well as user info from config.yaml
unset($_SESSION['success']);
unset($_SESSION['error']);
$logged = new chx2\Authentication($settings);

//Call routing file either from the theme or default
if (file_exists(THEME_PATH.'/router.php')) {
  require THEME_PATH.'/router.php';
}
else {
  require 'router.php';
}
