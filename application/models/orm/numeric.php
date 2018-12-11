<?php

namespace Models;

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
}
