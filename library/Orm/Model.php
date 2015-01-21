<?php

namespace Orm;

/**
 * Model class, voor het grootste gedeelte nog een stub
 * Class Model
 * @package Orm
 */
class Model
{

    protected $table = '';
    public $pk = '';
    protected $filterFields = [];
    protected $fields = [];
    protected $data = [];

    /**
     *
     * @param null $mixed
     */
    public function __construct($mixed = null)
    {
        if (is_null($mixed)) {
            return;
        }


        foreach ($this->fields as $field => $null) {

            if (!isset($mixed[$field])) {
                continue;
            }

            $this->$field = $mixed[$field];
        }

    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    /**
     * Stub
     * @return array
     */
    public static function all()
    {
        if (!isset($_SESSION['users'])) {
            $_SESSION['users'] = [
                1 => ['user_id' => 1, 'user_name' => 'Sherlock'],
                2 => ['user_id' => 2, 'user_name' => 'Watson'],
                3 => ['user_id' => 3, 'user_name' => 'Irene'],
                4 => ['user_id' => 4, 'user_name' => 'Mycroft'],
                5 => ['user_id' => 5, 'user_name' => 'Sebastian'],
                6 => ['user_id' => 6, 'user_name' => 'Moriarty']
            ];
        }

        $users = $_SESSION['users'];

        $return = [];
        $class = get_called_class();
        foreach ($users as $user) {
            $return[] = new $class($user);
        }

        return $return;
    }

    public static function get($id)
    {
        $class = get_called_class();


        if (!isset($_SESSION['users'][$id])) {
            return new $class();
        }

        return new $class($_SESSION['users'][$id]);

    }

    public function save()
    {
        $_SESSION['users'][$this->user_id] = ['user_id' => $this->user_id, 'user_name' => $this->user_name];
    }

    public function delete()
    {
        if (isset($_SESSION['users'][$this->user_id])) {
            unset($_SESSION['users'][$this->user_id]);
        }
    }
}