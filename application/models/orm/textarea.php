<?php

namespace Models;

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
     * Get the HTML representation of this element. Needs the matching CSS
     * @return string The HTML for this element
     */
    public function get_html()
    {
        $html = "<label for='field-{$this->id}'>{$this->label}</label>
                 <textarea id='field-{$this->id}' class='form-control' name='field-{$this->id}' placeholder='{$this->placeholder}'></textarea>";
        return $html;
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
}
