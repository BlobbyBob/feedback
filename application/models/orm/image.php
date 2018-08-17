<?php

namespace Models;

/**
 * Class Image
 * Wrapper for Images stored in the database
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Image
{

    /**
     * @var int $id ID of the image
     */
    public $id;

    /**
     * @var string $data Binary image data
     */
    public $data;

    /**
     * @var string $mime MIME type of the image
     */
    public $mime;

}
