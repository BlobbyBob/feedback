<?php

namespace Models;

use function in_array;
use function is_string;

/**
 * Class Checkbox
 * Represents an <input type="checkbox">
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Checkbox extends Formelement
{

    const BEFORE = 0;
    const AFTER = 1;

    /**
     * @var string $label The label for the checkbox
     */
    public $label = '';

    /**
     * @var int $label_position Either Checkbox::BEFORE or Checkbox::AFTER
     */
    public $label_position = self::BEFORE;

    /**
     * Checkbox constructor.
     * @param object $data The data for initializing
     */
    public function __construct($data)
    {

        if (isset($data->label) && is_string($data->label))
            $this->label = $data->label;

        if (isset($data->label_position) && in_array($data->label_position, [self::BEFORE, self::AFTER])) {
            $this->label_position = $data->label_position;
        }

    }

    public function get_html()
    {
        // TODO: Implement get_html() method.
    }
    
    /**
     * Returns true, since this element is a checkbox
     * @return bool
     */
    public function is_checkbox()
    {
        return true;
    }

    /**
     * Get the html of the settings of this form element
     * todo: This should be moved to views
     * @return string
     */
    public function get_settings()
    {
        // TODO: Implement get_settings() method.
    }
}
