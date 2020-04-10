<?php
/*
  Easy Docs by Chris H.

  EasyDocs allows for you to create & edit user documentation with a built-in dashboard centered around the organization of documentation under various user defined topics.

  This file is the application routing file. request handling can be setup through this file.

  If you want to create custom urls or modify behavior of current ones, consider creating a
  custom theme. You can place a router.php file in the home directory of your custom theme
  to be utilized instead of this default one.
*/
//Route to requested page
$router = new \Bramus\Router\Router();

//Welcome page
$router->get('/', function () use ($template, $settings, $logged) {
    if ($settings['settings']['private']) {
        if (!$logged->isLoggedUser()) {
            $logged->notLoggedIn();
            exit(0);
        }
    }
    if (empty($settings['pages'])) {
        $template->display('welcome.tpl');
    } else {
        $menu = new chx2\Navigation($settings['pages']);
        $menu->branch();

        $template->assign('navigation', $menu->navigation);
        $template->display('welcome.tpl');
    }
});

//Pull up document
$router->get('/edit', function () use ($settings, $template, $logged) {
    if ($logged->isLoggedIn()) {
        $document = new chx2\DocMaker($settings);
        $template->assign('docname', $document->docname);
        $template->assign('section', $document->section);
        $template->assign('content', $document->content);
        $template->display('editor.tpl');
    } else {
        $logged->notLoggedIn();
    }
});

//Save document changes
$router->post('/edit', function () use ($settings, $template, $logged) {
    if ($logged->isLoggedIn()) {
        $document = new chx2\DocMaker($settings);
        $document->putContent();
    } else {
        $logged->notLoggedIn();
    }
});

//Display dashboard
$router->get('/dashboard', function () use ($settings, $template, $logged) {
    ($logged->isLoggedIn()) ? $template->display('dashboard.tpl') : $logged->notLoggedIn();
});

//CRU with documents
$router->get('/document', function () use ($settings, $template, $logged) {
    if ($logged->isLoggedIn()) {
        $document = new chx2\DocMaker($settings);
        if ($document->isSection()) {
            $document->addSection();
        } elseif ($document->isContent()) {
            $document->addContent();
        } elseif ($document->isEdit()) {
            $document->editContent();
        }
    } else {
        $logged->notLoggedIn();
    }
});

$router->get('/logout', function () use ($settings, $template, $logged) {
    $logged->logout();
});

//Login
$router->get('/login', function () use ($settings, $template, $logged) {
    ($logged->isLoggedIn()) ? $logged->LoggedIn() : $template->display('login.tpl');
});

//Try to login
$router->post('/login', function () use ($settings, $template, $logged) {
    $logged->login();
});

//Reorder section
$router->post('/order', function () use ($settings, $template, $logged) {
    if ($logged->isLoggedIn()) {
        $sort = new chx2\Sorter($settings);
        $sort->sort();
    } else {
        echo 'You are not logged in';
    }
});

//Remove request section/document
$router->post('/process', function () use ($settings, $template, $logged) {
    if ($logged->isLoggedIn()) {
        $document = new chx2\DocMaker($settings);
        $document->deleteContent();
    } else {
        echo 'You are not logged in';
    }
});

//Save setting changes
$router->get('/settings', function () use ($settings, $template, $logged) {
    ($logged->isLoggedIn()) ? $template->display('settings.tpl') : $logged->notLoggedIn();
});
$router->post('/settings', function () use ($settings, $template, $logged) {
    ($logged->isLoggedIn()) ? (new chx2\Settings($settings)) : $logged->notLoggedIn();
});

//Run a selected tool
$router->get('/tool', function () use ($settings, $template, $logged) {
    ($logged->isLoggedIn()) ? (new chx2\Tool($settings))->run() : $logged->notLoggedIn();
});
$router->post('/tool', function () use ($settings, $template, $logged) {
    ($logged->isLoggedIn()) ? (new chx2\Tool($settings))->run() : $logged->notLoggedIn();
});

//View Documents
$router->get('/([^/]+)/([^/]+)', function ($slug, $name) use ($settings, $template, $logged) {
    if ($settings['settings']['private'] && !$logged->isPreview() && !$logged->isLoggedUser()) {
        $logged->notLoggedIn();
        exit(0);
    }
    $document = new chx2\DocMaker($settings);
    $document->section = preg_replace('/[\s\+]/', ' ', htmlspecialchars($slug));
    $document->docname = preg_replace('/[\s\+]/', ' ', htmlspecialchars($name));

    $menu = new chx2\Navigation($settings['pages'], $document->section, $document->docname);
    $menu->branch();

    $parsed = new Parsedown();

    if ($document->getContent()) {
        $template->assign('navigation', $menu->navigation);
        $template->assign('docname', $document->docname);
        $template->assign('section', $document->section);
        $template->assign('content', $parsed->text($document->content));
        $template->display('document.tpl');
    } else {
        header('HTTP/1.1 404 Not Found');
        $template->display('404.tpl');
    }
});

// Custom 404 Handler
$router->set404(function () use ($settings, $template) {
    header('HTTP/1.1 404 Not Found');
    $template->display('404.tpl');
});

//Execute request
$router->run();
