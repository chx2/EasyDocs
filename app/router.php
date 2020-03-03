<?php
//Route to requested page
$router = new \Bramus\Router\Router();

//Welcome page
$router->get('/', function() use ($template,$settings,$logged) {
  if ($settings['settings']['private']) {
    if (!$logged->isLoggedUser()) {
      $logged->NotLoggedIn();
      exit(0);
    }
  }
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
  }
  else {
    $logged->NotLoggedIn();
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
  }
  else {
    $logged->NotLoggedIn();
  }
});

$router->get('/logout', function() use ($settings,$template,$logged) {
  $logged->logout();
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
  if ($logged->isUser()) {
    $logged->loginUser();
  }
  else {
    $logged->login();
  }
});

//Reorder section
$router->post('/order', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $sort = new chx2\Sorter($settings);
    $sort->sort();
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
  }
  else {
    echo 'You are not logged in';
  }
});

//Save setting changes
$router->get('/settings', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $template->display('settings.tpl');
  }
  else {
    $logged->NotLoggedIn();
  }
});
$router->post('/settings', function() use ($settings,$template,$logged) {
  if ($logged->isLoggedIn()) {
    $update = new chx2\Settings($settings);
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
  }
  else {
    $logged->NotLoggedIn();
  }
});

//View Documents
$router->get('/([^/]+)/([^/]+)', function($slug,$name) use ($settings,$template,$logged) {
  if ($settings['settings']['private']) {
    if (!$logged->isPreview()) {
      if (!$logged->isLoggedUser()) {
        $logged->NotLoggedIn();
        exit(0);
      }
    }
  }
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
});

// Custom 404 Handler
$router->set404(function() use ($settings,$template) {
	header('HTTP/1.1 404 Not Found');
	$template->display('404.tpl');
});

//Execute request
$router->run();
