<?php

namespace Models;

class Feedback
{

    public function __construct($data)
    {
        if ( is_array($data) ) {
            // TODO: Implement constructor
        }

    }

    /**
     * @var int[] $ratings The ratings in the configurated order
     */
    public $ratings;

    /**
     * @var string[] $text The texts in the configurated order
     */
    public $text;

}
