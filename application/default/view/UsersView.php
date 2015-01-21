<?php

/**
 * Example viewobject
 * Class UsersView
 */
class UsersView extends \Content\ViewObject
{

    public function __construct($view)
    {
        parent::__construct("users");
    }

    public function __toString()
    {
        return parent::__toString();
    }
}