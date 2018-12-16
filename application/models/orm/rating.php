<?php

namespace Models;

use function is_int;
use function is_string;
use stdClass;

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
            'type' => "Bewertung",
            'settings' => [
                [
                    'key' => "Beschriftung",
                    'type' => "text",
                    'name' => "label",
                    'value' => $this->label
                ],
                [
                    'key' => "Anzahl",
                    'type' => "number",
                    'name' => "count",
                    'value' => $this->count,
                    'attr' => 'min="3" max="12"'
                ],
                [
                    'key' => "Beschriftung links",
                    'type' => "text",
                    'name' => "label_before",
                    'value' => $this->label_before
                ],
                [
                    'key' => "Beschriftung rechts",
                    'type' => "text",
                    'name' => "label_after",
                    'value' => $this->label_after
                ],
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
        $o->type = 'rating';

        $j = new stdClass();
        $j->label = $this->label;
        $j->label_before = $this->label_before;
        $j->label_after = $this->label_after;
        $j->count = $this->count;
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
            $median = $data[$count/2];

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
            'datatype' => 'rating',
            'data' => $data
        ];

        return $stats;
    }
}
