<?php

namespace Models;

class Feedback
{

    public function __construct()
    {
    }

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
     * @var object $data The actual feedback
     */
    public $data;

}
