<?php

namespace User;

/**
 * Class Guest
 * @package User
 */
class Guest extends User
{

    use NameTrait;

    public function edit()
    {
        return false;
    }

}