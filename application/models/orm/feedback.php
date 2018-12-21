<?php

namespace Models;

class Feedback
{

    /**
     * @var int $id The ID of this feedback
     */
    public $id = NULL;

    /**
     * @var int $route The id of the route for this feedback
     */
    public $route;

    /**
     * @var string $author_id The md5 hash of the IP address and the date of the submission
     */
    public $author_id;

    /**
     * @var
     */
    public $date;

    /**
     * @var int $questions Answered questions
     */
    public $questions;

    /**
     * @var int $total Total asked questions
     */
    public $total;

    /**
     * @var object $data The actual feedback
     */
    public $data;

}
