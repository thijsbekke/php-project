<?php

namespace Content;
/**
 * Interface IView
 * @package Content
 */
interface IView
{
    public function __construct($view);

    public function __toString();
}