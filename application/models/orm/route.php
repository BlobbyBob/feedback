<?php

namespace Models;

class Route
{
    public function __construct($data)
    {
        if ( is_array($data) ) {
            // TODO: Implement constructor
        }
    }

    /**
     * @var int $id ID of the route
     */
    public $id;

    /**
     * @var string $name Name of the route (optional)
     */
    public $name;

    /**
     * @var string $grade Grade of the route in UIAA roman numbers (e.g. VIII+)
     */
    public $grade;

    /**
     * @var Color $color Color of the route
     */
    public $color;

    /**
     * @var Setter $setter The setter of route (optional)
     */
    public $setter;

    /**
     * @var int $wall Number of the rope, where the route is set, special value -1 for lead climbing
     */
    public $wall;

    /**
     * @var int $image The ID of the associated image
     */
    public $image;

}
