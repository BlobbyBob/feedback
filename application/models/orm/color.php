<?php

namespace Models;

class Color
{

    public $name;
    public $code;

    public function __construct($color)
    {

        if (Colors::getColorByName($color) !== false) {
            $this->name = Colors::getDislayName($color);
            $this->code = Colors::getColorByName($color);
        }

    }

}
