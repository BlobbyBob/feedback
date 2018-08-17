<?php

namespace Models;

use function is_array;
use function is_object;
use function is_string;

/**
 * Class Radiobutton
 * Represents multiple <input type="radio">
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Radio extends Formelement
{

    /**
     * @var string $main_label Main label of the radio group
     */
    public $main_label = '';

    /**
     * @var string[] $labels A radiobutton will be displayed for each label
     */
    public $labels = [];

    /**
     * Radio constructor.
     * @param object $data The data for initalizing
     */
    public function __construct($data)
    {

        if (isset($data->main_label) && is_string($data->main_label)) {
            $this->main_label = $data->main_label;
        }

        if (isset($data->labels) && (is_array($data->labels) || is_object($data->labels))) {
            foreach ($data->labels as $key => $val) {
                if (is_string($val))
                    $labels[$key] = $val;
            }
        }

    }

    public function get_html()
    {
        // TODO: Implement get_html() method.
    }

    /**
     * This is a radio button
     * @return bool true
     */
    public function is_radio()
    {
        return true;
    }


}
