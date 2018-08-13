<?php

namespace Models;

use ReflectionClass;

class Colors
{
    const WHITE = ['#FFFFFF', 'weiß'];
    const BLUE = ['', 'blau'];
    const RED = ['', 'rot'];
    const PINK = ['', 'rosa'];
    const MAGENTA = ['', 'magenta'];
    const PURPLE = ['', 'lila'];
    const GREEN = ['', 'grün'];
    const TURQOUISE = ['', 'türkis'];
    const BLACK = ['', 'schwarz'];

    /**
     * Get the color code of a color
     * @param string $name The name of the color
     * @return string|bool The color-code if it is found, otherwise false
     */
    static function getColorByName($name) {

        $class = new ReflectionClass(get_called_class());
        return ($class->getConstant(strtoupper($name)) !== false) ? ($class->getConstant(strtoupper($name)))[0] : false;

    }

    /**
     * Get the name of the color for the end user
     * @param string $name The name of the color
     * @return string|bool The name to display of the color if it is available, false otherwise
     */
    static function getDislayName($name) {

        $class = new ReflectionClass(get_called_class());
        return ($class->getConstant(strtoupper($name)) !== false) ? ($class->getConstant(strtoupper($name)))[1] : false;

    }

    /**
     * Get all available colors
     * @return array Available colors
     */
    static function getColors() {
        $class = new ReflectionClass(get_called_class());
        return $class->getConstants();
    }

}
