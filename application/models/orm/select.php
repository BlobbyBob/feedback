<?php

namespace Models;

/**
 * Class Select
 * Represents <select> and <option> elements
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Select extends Formelement
{

    /**
     * @var string label The label for this Select
     */
    public $label = '';

    /**
     * @var string[] $options The value => optionlabel pairs
     */
    public $options = [];

    /**
     * Select constructor.
     * @param object $data The data to initialize with
     */
    public function __construct($data)
    {
        if (isset($data->label) && is_string($data->label)) {
            $this->label = $data->label;
        }

        if (isset($data->options) && (is_array($data->options) || is_object($data->options))) {
            foreach ($data->options as $key => $val) {
                if (is_string($val))
                    $this->options[$key] = $val;
            }
        }
    }

    public function get_html()
    {
        // TODO: Implement get_html() method.
    }

    /**
     * This is a select element
     * @return bool true
     */
    public function is_select()
    {
        return true;
    }


}
