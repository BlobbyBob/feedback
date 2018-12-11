<?php

namespace Models;

/**
 * Class Pagebreak
 * Represents a new div / page
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 * @see Formelement
 */
class Pagebreak extends Formelement
{

    /**
     * Pagebreak constructor.
     * @param object $data The data object is not used in this Formelement
     */
    public function __construct($data)
    {
    }

    /**
     * Get the html of this form element
     * @return string
     */
    public function get_html()
    {
        return '';
    }

    /**
     * Get the settings of this form element
     * Should be parsed by a view
     *
     * @return array
     */
    public function get_settings()
    {
        $settings = [
            'id' => $this->id,
            'index' => $this->index,
            'type' => "Seitenumbruch",
            'settings' => []
        ];
        return $settings;
    }
}