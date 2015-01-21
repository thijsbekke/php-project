<?php

namespace User;

/**
 * Definieer het user model
 * Class User
 * @package User
 */
abstract class User extends \Orm\Model
{

    protected $table = 'users';
    public $pk = 'user_id';
    protected $filterFields = ['user_password'];
    protected $fields = [
        'user_id' => '',
        'user_name' => '',
        'user_login' => '',
        'user_password' => '',
    ];

    protected $autoFields = [
        'insert' => [],
        'update' => []
    ];

    abstract function edit();
}