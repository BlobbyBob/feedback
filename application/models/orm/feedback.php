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
     * @var int $id The ID of this feedback
     */
    public $id;

    /**
     * @var Route $route The route for this feedback
     */
    public $route;

    /**
     * @var int $date Date of feedback in unix epoch
     */
    public $date;

    /**
     * @var string $author The md5 hash of the IP address of the submitter
     */
    public $author;

    /**
     * @var int[] $ratings The ratings in the configurated order
     */
    public $ratings;

    /**
     * @var string[] $text The texts in the configurated order
     */
    public $text;

}
