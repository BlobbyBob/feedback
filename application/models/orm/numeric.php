<?php

namespace Models;

use stdClass;

/**
 * Class Numeric
 * Represents an <input type="number">
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Numeric extends Formelement
{

    /**
     * @var string $label The label for the checkbox
     */
    public $label = '';

    /**
     * Numeric constructor.
     * @param object $data
     */
    public function __construct($data)
    {
        if (isset($data->label) && is_string($data->label))
            $this->label = $data->label;
    }

    public function get_html()
    {
        // TODO: Implement get_html() method.
    }

    /**
     * Returns true, since this is a numeric input
     * @return bool
     */
    public function is_numeric()
    {
        return true;
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
            'type' => "Nummer",
            'settings' => [
                [
                    'key' => "Beschriftung",
                    'type' => "text",
                    'name' => "label",
                    'value' => $this->label
                ]
            ]
        ];
        return $settings;
    }

    /**
     * Return the data of this formelement as object similar to the object by Formelement::create
     *
     * @return object
     */
    public function export()
    {
        $o = new stdClass();
        $o->id = $this->id;
        $o->index = $this->index;

        $j = new stdClass();
        $j->label = $this->label;
        $o->data = json_encode($j);

        return $o;
    }
}
