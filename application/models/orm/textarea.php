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


    public function get_html()
    {
        // TODO: Implement get_html() method.
    }

}
