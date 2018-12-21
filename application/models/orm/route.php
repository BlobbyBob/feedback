<?php

namespace Models;

class Route
{

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
     * @var string $color Color of the route
     */
    public $color;

    /**
     * @var string $setter The name of the setter of the route (optional)
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
