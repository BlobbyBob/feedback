<?php

namespace Models;

use function array_sum;
use function is_array;
use function is_object;
use function is_string;
use stdClass;

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


    /**
     * Get the settings of this form element
     * Should be parsed by a view
     *
     * @return array
     */
    public function get_settings()
    {
        $subsettings = [
            [
                'key' => "Beschriftung",
                'type' => "text",
                'name' => "main_label",
                'value' => $this->main_label
            ]
        ];
        foreach ($this->labels as $label) {
            $subsettings[] = [
                'key' => "Radio Button",
                'type' => "text",
                'name' => "labels[]",
                'value' => $label,
                'attr' => 'placeholder="Beschriftung"',
                'small' => '<a class="remove-radio">Radio Button löschen</a>'
            ];
        }
        $subsettings[] = [
            'type' => "button",
            'title' => "Radio Button hinzufügen",
            'class' => "add-radio"
        ];
        $settings = [
            'id' => $this->id,
            'index' => $this->index,
            'type' => "Radio Buttons",
            'settings' => $subsettings
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
        $o->type = 'radio';

        $j = new stdClass();
        $j->main_label = $this->main_label;
        $j->labels = $this->labels;
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

        for ($i = 0; $i < count($this->labels); $i++) {
            $n[$i] = 0;
        }

        foreach ($data as $value) {
            if (isset($n[$value]))
                $n[$value]++;
        }

        $options = [];
        foreach ($n as $i => $val) {
            $options[] = [
                'key' => $this->labels[$i],
                'value' => $val
            ];
        }

        $stats = [
            'label' => $this->main_label,
            'type' => 'options',
            'options' => $options
        ];

        return $stats;
    }
}
