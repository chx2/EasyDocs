<?php
/*
  Easy Docs by Chris H.

  EasyDocs allows for you to create & edit user documentation with a built-in dashboard centered around the organization of documentation under various user defined topics.
*/

//Dependencies
require 'vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

//Constants
session_start();
define('BASE_URL',      (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://'.$_SERVER['HTTP_HOST'] .dirname($_SERVER['SCRIPT_NAME']));
define('CONFIG_URI',    'app/config.yaml');
define('DOC_URI',       'docs/');
define('TEMPLATE_DIR',  'app/templates');

//Get configuration file
try {

  $settings = Yaml::parseFile(CONFIG_URI);
  //Map template variables
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

  //Map external and local asset files into template buffer
  $js = '';
  $css = '';
  foreach($settings['settings']['scripts']['external'] as $externaljs) {
    $js .= '<script src="' . $externaljs . '"></script>' . "\n";
  }
  foreach($settings['settings']['scripts']['local'] as $localjs) {
    $js .= '<script src="' . BASE_URL . '/assets/js/' . $localjs . '"></script>' . "\n";
  }
  foreach($settings['settings']['styles']['external'] as $externalcss) {
    $css .= '<link rel="stylesheet" href="' . $externalcss . '">' . "\n";
  }
  foreach($settings['settings']['styles']['local'] as $localcss) {
    $css .= '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/' . $localcss . '">' . "\n";
  }
  $template->assign('scripts',      $js);
  $template->assign('styles',       $css);

} catch (Exception $e) {
  die('You have an error in your configuration file, please check the file for syntax errors');
}

//Get post data for Authentication as well as user info from config.yaml
unset($_SESSION['success']);
unset($_SESSION['error']);
$logged = new chx2\Authentication($settings);

//Route to requested page
$router = new \Bramus\Router\Router();

//Welcome page
$router->get('/', function() use ($template,$settings) {
  if (empty($settings['pages'])) {
    $template->display('welcome.tpl');
  }
  else {
    $menu = new chx2\Navigation($settings['pages']);
    $menu->branch();

    $template->assign('navigation',$menu->navigation);
    $template->display('welcome.tpl');
  }
});

//Pull up document
$router->get('/edit', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $document = new chx2\DocMaker($settings);
    $template->assign('docname',$document->docname);
    $template->assign('section',$document->section);
    $template->assign('content',$document->content);
    $template->display('editor.tpl');
  }
  else {
    $logged->NotLoggedIn();
  }
});

//Save document changes
$router->post('/edit', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $document = new chx2\DocMaker($settings);
    $document->putContent();
    $yaml = Yaml::dump($document->list);
    file_put_contents(CONFIG_URI, $yaml);
    header('Location: dashboard');
  }
  else {
    $logged->NotLoggedIn();
  }
});

//Login
$router->get('/login', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $logged->LoggedIn();
  }
  else {
    $template->display('login.tpl');
  }
});

//Try to login
$router->post('/login', function() use ($settings,$template,$logged) {
  $logged->login();
});

//Reorder section
$router->post('/order', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $sort = new chx2\Sorter($settings);
    $sort->sort();
    $yaml = Yaml::dump($sort->list);
    file_put_contents(CONFIG_URI, $yaml);
    header('Location: dashboard');
  }
  else {
    echo 'You are not logged in';
  }
});

//Remove request section/document
$router->post('/process', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $document = new chx2\DocMaker($settings);
    $document->deleteContent();
    $yaml = Yaml::dump($document->list);
    file_put_contents(CONFIG_URI, $yaml);
  }
  else {
    echo 'You are not logged in';
  }
});

//Display dashboard
$router->get('/dashboard', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $template->display('dashboard.tpl');
  }
  else {
    $logged->NotLoggedIn();
  }
});

$router->get('/logout', function() use ($settings,$template,$logged) {
  $logged->logout();
});

//CRU with documents
$router->get('/document', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $document = new chx2\DocMaker($settings);
    if ($document->isSection()) {
      $document->addSection();
    }
    elseif ($document->isContent()) {
      $document->addContent();
    }
    elseif ($document->isEdit()) {
      $document->editContent();
    }
    $yaml = Yaml::dump($document->list);
    file_put_contents(CONFIG_URI, $yaml);
  }
  else {
    $logged->NotLoggedIn();
  }
});

//Run a selected tool
$router->get('/tool', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $tool = new chx2\Tool($settings);
    $tool->run();
    $yaml = Yaml::dump($tool->list);
    file_put_contents(CONFIG_URI, $yaml);
  }
  else {
    $logged->NotLoggedIn();
  }
});

//Run a tool that requires many fields, handled through post data
$router->post('/tool', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $tool = new chx2\Tool($settings);
    $tool->run();
    $yaml = Yaml::dump($tool->list);
    file_put_contents(CONFIG_URI, $yaml);
  }
  else {
    $logged->NotLoggedIn();
  }
});

//View Documents
$router->get('/([^/]+)/([^/]+)', function($slug,$name) use ($settings,$template,$logged) {
  if (isset($name)) {
    $document = new chx2\DocMaker($settings);
    $document->section = preg_replace('/[\s\+]/', ' ', htmlspecialchars($slug));
    $document->docname = preg_replace('/[\s\+]/', ' ', htmlspecialchars($name));

    $menu = new chx2\Navigation($settings['pages'],$document->section,$document->docname);
    $menu->branch();

    $parsed = new Parsedown();

    if ($document->getContent()) {
      $template->assign('navigation',$menu->navigation);
      $template->assign('docname',$document->docname);
      $template->assign('section',$document->section);
      $template->assign('content',$parsed->text($document->content));
      $template->display('document.tpl');
    }
    else {
      header('HTTP/1.1 404 Not Found');
      $template->display('404.tpl');
    }
  }
});

// Custom 404 Handler
$router->set404(function() use ($settings,$template) {
	header('HTTP/1.1 404 Not Found');
	$template->display('404.tpl');
});

//Execute request
$router->run();
