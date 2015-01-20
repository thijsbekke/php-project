<?php

\Router\Event::listen('404', function()
{
    //Todo: Eigenlijk moet dit een controller zijn met een call functie enz.
    $content = "<h2>404</h2>This is not the page you are looking for";

    $response = new \Router\Response($content, 404);
    $response->render();
    $response->send();
    die();
});

Router\Route::get('\/admin\/(.*)',array('before' => 'auth', function()
{
    dd('Admin');
//   return View::make('admin');
}));

Router\Route::get('/',function()
{
    die('Root');
//   return View::make('base');
});

//Vanaf hier wordt eigenlijk gemaakt wanneer je ondestaande ding uitvoert
Router\Route::controller('/user/', new User());

Router\Route::filter('auth', function()
{
    die("Auth filter");
});
