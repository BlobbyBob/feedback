<?php

namespace Models;

class Color
{

    public $name;
    public $code;

    public function __construct($color)
    {

        if (Colors::get_color_by_name($color) !== false) {
            $this->name = Colors::get_display_name($color);
            $this->code = Colors::get_color_by_name($color);
        }

    }

}
