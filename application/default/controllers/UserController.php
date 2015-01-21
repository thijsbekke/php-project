<?php

/**
 * Class User
 */
class UserController implements \Rest\IRest
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
        //Eigen in JSON terug
        return \Content\View::make('UsersView');
    }

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met 1 argument
     * @example /route/(:num)
     * @param (:num) $id
     */
    public function show($id)
    {

    }

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met 1 argument en edit
     * @example /route/(:num)/edit
     * @param $id
     */
    public function edit($id)
    {

    }

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met het create argument
     * @example /route/create
     */
    public function create()
    {

        $user = new \User\Admin();
        $user->user_name = $_POST['user_name'];
        $user->user_id = rand(0, 100);
        $user->save();

        return \Content\View::make('UsersView');
    }

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met het delete argument
     * @example /route/(:num)/delete
     * @param $id
     */
    public function delete($id)
    {
        $id = array_pop($id);
        $user = \User\Admin::get($id);

        $user->delete();

        return \Content\View::make('UsersView');

    }
}
