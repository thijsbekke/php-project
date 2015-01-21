<?php

namespace User;

/**
 * Class Admin
 * @package User
 */
class Admin extends User
{

    use NameTrait;

    public function edit()
    {
        return true;
    }


}