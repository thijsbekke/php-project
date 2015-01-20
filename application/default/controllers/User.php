<?php

//Dit is mijn controller die iets moet gaan doen.
class User implements \Router\IController
{

    public function __construct() { }

    public function index()
    {
        die('index');
        //View assign allemaal variabelen
        //$controller->index()
        //
        //ViewObject is de standaard class, deze kan je overerfen mits je dat wilt
//        $view = View::make('Index');
        //Hier gaan we de template setten, Dat is eigenlijk conroller::makeView();
//        $view->view('thijs');

        //Hier returned hij een view, standaard is dat een standaard
        // view die de template tjak inlaad die je wilt hebben
        return $view;
    }
    public function show($id)
    {
        die('show' . print_r($id, 1));
    }

    public function edit($id)
    {
        die('edit' . print_r($id, 1));
    }

    public function create()
    {
        die('create');
    }

    public function delete($id) {
        die('delete' . print_r($id, 1));
    }
}
