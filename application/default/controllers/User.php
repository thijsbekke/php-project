<?php

/**
 * Class User
 */
class User implements \Rest\IRest
{

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Wordt uitgevoerd wanneer Rest controller word aangeroepen zonder argumenten
     * @example /route/
     * @return mixed
     */
    public function index()
    {
        die('user index');
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

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met 1 argument
     * @example /route/(:num)
     * @param (:num) $id
     */
    public function show($id)
    {
        die('show' . print_r($id, 1));
    }

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met 1 argument en edit
     * @example /route/(:num)/edit
     * @param $id
     */
    public function edit($id)
    {
        die('edit' . print_r($id, 1));
    }

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met het create argument
     * @example /route/create
     */
    public function create()
    {
        die('create');
    }

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met het delete argument
     * @example /route/(:num)/delete
     * @param $id
     */
    public function delete($id)
    {
        die('delete' . print_r($id, 1));
    }
}
