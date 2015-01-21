<?php

//Not found event registreren
\Router\Event::listen('404', function () {
    //Todo: Eigenlijk moet dit een controller zijn met een call functie enz.
    $content = "<h2>404</h2>This is not the page you are looking for";

    $response = new \Router\Response($content, 404);
    $response->render();
    $response->send();
    die();
});

//Route voor admin pad
Router\Route::get('\/admin\/(.*)', array('before' => 'auth', function () {
    dd('Admin');
//   return View::make('admin');
}));

//Voeg een Reset controller toe, hier worden automatisch de routes voor aangemaakt
Router\Route::controller('/user/', new \Rest\RestController(new User()));

//Filter die gebruikt worden bij de /admin/ route
Router\Route::filter('auth', function () {
    die("Auth filter");
});

//Default pad
Router\Route::get('/', function () {
    die('Root');
//   return View::make('base');
});
