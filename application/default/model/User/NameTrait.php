<?php

namespace User;

/**
 * Class NameTrait
 * @package User
 */
trait NameTrait
{

    /**
     * Return de naam met eerste letter als hoofdletter
     * @return string
     */
    public function name()
    {
        return ucfirst(strtolower($this->user_name));
    }
}