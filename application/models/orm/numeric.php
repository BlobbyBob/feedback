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

    /**
     * Get the data to show render the HTML of this element
     * @return array The array for the view to parse
     */
    public function get_data()
    {
        $data = [
            'id' => $this->id,
            'label' => $this->label,
            'tag' => 'input',
            'type' => 'number',
            'closing' => false,
            'special' => '',
            'placeholder' => '',
            'maxlength' => ''
        ];
        return $data;
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
        $o->type = 'numeric';

        $j = new stdClass();
        $j->label = $this->label;
        $o->data = json_encode($j);

        return $o;
    }

    /**
     * Calculate statistics about this object
     *
     * @param array $data The data set saved for this element
     * @return array
     */
    public function stats($data)
    {
        $count = count($data);
        if ($count == 0) {
            $min = $max = $mean = $median = 0;
        } else {

            sort($data);
            $min = $data[0];
            $max = max($data);
            $mean = array_sum($data) / $count;
            if ($count & 1)
                $median = $data[$count/2];
            else
                $median = ($data[$count/2] + $data[$count/2-1]) / 2;

        }

        $stats = [
            'id' => $this->id,
            'label' => $this->label,
            'type' => 'numbers',
            'numbers' => [
                [
                    'key' => 'min',
                    'value' => $min
                ],
                [
                    'key' => 'max',
                    'value' => $max
                ],
                [
                    'key' => 'mean',
                    'value' => $mean
                ],
                [
                    'key' => 'median',
                    'value' => $median
                ]
            ],
            'datatype' => 'numeric',
            'data' => $data
        ];

        return $stats;
    }
}
