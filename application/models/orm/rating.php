<?php

namespace Models;

use function is_int;
use function is_string;

/**
 * Class Rating
 * Represents rating stars
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Rating extends Formelement
{

    /**
     * @var string $label Main label of the radio group
     */
    public $label = '';

    /**
     * @var string $label_before The label before the first star
     */
    public $label_before = '';

    /**
     * @var string $label_after The label after the last star
     */
    public $label_after = '';

    /**
     * @var int $count Number of stars
     */
    public $count = 6;

    /**
     * Rating constructor.
     * @param object $data The data for initalizing
     */
    public function __construct($data)
    {

        if (isset($data->label) && is_string($data->label)) {
            $this->label = $data->label;
        }

        if (isset($data->label_before) && is_string($data->label_before)) {
            $this->label_before = $data->label_before;
        }

        if (isset($data->label_after) && is_string($data->label_after)) {
            $this->label_after = $data->label_after;
        }

        if (isset($data->count) && is_int($data->count)) {
            $this->count = max(3, min(12, $data->count));
        }

    }

    /**
     * Get the styled html rating stars. Needs the specific style sheets
     * @return string The HTML for this element
     */
    public function get_html()
    {
        $html = "<label for='field-{$this->id}'>{$this->label}</label>
                <div class='starrating risingstar d-flex justify-content-center flex-row-reverse align-items-center'>
                    <span>{$this->label_before}</span>";
        for ($i = 1; $i <= $this->count; $i++) {
            $html .= "<input id='star{$this->id}-{$i}' type='radio' name='field-{$this->id}' value='{$i}'/><label for='star{$this->id}-{$i}'></label>";
        }
        $html .= "<span>{$this->label_after}</span>
                </div>";
        return $html;
    }

    /**
     * This is a rating
     * @return bool true
     */
    public function is_rating()
    {
        return true;
    }


}
