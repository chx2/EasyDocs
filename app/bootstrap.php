<?php
/*
  Easy Docs by Chris H.

  EasyDocs allows for you to create & edit user documentation with a built-in dashboard centered around the organization of documentation under various user defined topics.

  This file is used to pass various data from the config file into a reusable array within theme
  templates and routers. If you are creating custom views, please DO NOT make edits to this file.

  All of the information you need to utilize the back-end classes should be handled via a custom router and view files implmenting data from here.
*/

//Dependencies
require 'vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

//Check application requirements, stop here if not met
$requirements = new chx2\Requirements();
$requirements->check();

//Constants
session_start();

//Define a base url, this is set to EasyDocs works however many folders deep on a webserver
define('BASE_URL',      (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://'.$_SERVER['HTTP_HOST'] .dirname($_SERVER['SCRIPT_NAME']));

//Route to the config file
define('CONFIG_URI',    'app/config.yaml');

//Document storage folder
define('DOC_URI',       'docs/');

//Get configuration file
try {

  //Parse Application settings
  $settings = Yaml::parseFile(CONFIG_URI);

  //Create constant folder links
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

  //Setup a Smarty instance for calling templates
  $template = new Smarty();
  $template->setTemplateDir(TEMPLATE_DIR)
           ->setCompileDir('cache');

  //Base URL constant
  $template->assign('base_url',     BASE_URL);

  //Values grabbed from config
  $template->assign('encoding',     $settings['settings']['encoding']);
  $template->assign('langauge',     $settings['settings']['langauge']);
  $template->assign('title',        $settings['settings']['title']);
  $template->assign('description',  $settings['settings']['description']);

  //Multidimensional list of sections & pages they contain
  $template->assign('sections',     (isset($settings['pages']) ? $settings['pages']: null));

  //Flash messages, filled out within application classes
  $template->assign('error',        (isset($_SESSION['error']) ? $_SESSION['error'] : ''));
  $template->assign('success',      (isset($_SESSION['success']) ? $_SESSION['success'] : ''));

  ////Multidimensional list of users & the password and role assigned to them
  $template->assign('users',        $settings['settings']['users']);

  //List of theme names
  $template->assign('themes',       $themelist->getThemeTitles());

  //Board privacy, Will be set if board is private
  $template->assign('private',      $settings['settings']['private']);

  //Variables used to call all theme scripts and/or styles
  $template->assign('scripts',      $js);
  $template->assign('styles',       $css);

}
//A messed up config file can cause problems, end here if something is wrong
catch (Exception $e) {
  die('You have an error in your configuration file, please check the file for syntax errors');
}

//Remove flash messages
unset($_SESSION['success']);
unset($_SESSION['error']);

//Prepare for user authentication
$logged = new chx2\Authentication($settings);

//Look for a custom theme routing file
if (file_exists(THEME_PATH.'/router.php')) {
  require THEME_PATH.'/router.php';
}
//No custom file, use the one included by default
else {
  require 'router.php';
}
