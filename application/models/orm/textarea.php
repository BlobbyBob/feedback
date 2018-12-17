<?php

namespace Models;

use stdClass;

/**
 * Class Textarea
 * Represents a <textarea> element
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Textarea extends Formelement
{
    /**
     * @var string $label The label for this element
     */
    public $label = '';

    /**
     * @var string $placeholder The placeholder for this element
     */
    public $placeholder = '';

    /**
     * Textarea constructor.
     * @param object $data The data for initializiation
     */
    public function __construct($data)
    {

        if (isset($data->label) && is_string($data->label)) {
            $this->label = $data->label;
        }

        if (isset($data->placeholder) && is_string($data->placeholder)) {
            $this->placeholder = $data->placeholder;
        }

    }

    /**
     * This is a textarea
     * @return bool true
     */
    public function is_textarea()
    {
        return true;
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
            'placeholder' => $this->placeholder,
            'tag' => 'textarea',
            'closing' => true,
            'special' => '',
            'maxlength' => ''
        ];
        return $data;
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
            'type' => "Großes Textfeld",
            'settings' => [
                [
                    'key' => "Beschriftung",
                    'type' => "text",
                    'name' => "label",
                    'value' => $this->label
                ],
                [
                    'key' => "Platzhalter",
                    'type' => "text",
                    'name' => "placeholder",
                    'value' => $this->placeholder
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
        $o->type = 'textarea';

        $j = new stdClass();
        $j->label = $this->label;
        $j->placeholder = $this->placeholder;
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
        $text = [];
        $i = 0;
        shuffle($data);
        foreach ($data as $d) {
            $text[] = [
                'key' => $i++,
                'value' => $d
            ];
        }

        $stats = [
            'id' => $this->id,
            'label' => $this->label,
            'type' => 'text',
            'text' => $text
        ];

        return $stats;
    }
}
