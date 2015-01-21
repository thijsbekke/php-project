<?php

namespace Rest;
/**
 * Interface IRest
 * Definieer RestController
 * @package Rest
 */
interface IRest
{

    /**
     * Wordt uitgevoerd wanneer Rest controller word aangeroepen zonder argumenten
     * @example /route/
     * @return mixed
     */
    public function index();

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met 1 argument
     * @example /route/(:num)
     * @param (:num) $id
     */
    public function show($id);

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met 1 argument en edit
     * @example /route/(:num)/edit
     * @param $id
     */
    public function edit($id);

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met het create argument
     * @example /route/create
     */
    public function create();

    /**
     * Wordt aangroepen wanneer Rest controller wordt aangeroepen met het delete argument
     * @example /route/(:num)/delete
     * @param $id
     */
    public function delete($id);

}
