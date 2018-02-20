<?php

class ViewRender
{
    /**
     * generate all html code
     * @param string $view With a name class with render form in view folder
     * @param string $data With a data for render form such as input data, validated data
     */
    function __construct($view, $data) {
        include "View/ViewStructure.php";
    }
}
