<?php
namespace Content;

/**
 * Class ViewObject
 * @package Content
 */
class ViewObject implements IView
{
    protected $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function view($view)
    {
        $this->view = $view;
    }

    public function __toString()
    {

        $content = "";
        $filename = path('presentation') . $this->view . ".php";
        if (\FileSystem\File::exists($filename)) {
            ob_start();

            include($filename);

            $content = ob_get_contents();
            ob_end_clean();
        }

        return $content;

    }

}