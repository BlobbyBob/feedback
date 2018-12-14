<?php

namespace Models;

use stdClass;

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
                'name' => "label",
                'value' => $this->label
            ]
        ];
        foreach ($this->options as $option) {
            $subsettings[] = [
                'key' => "Option",
                'type' => "text",
                'name' => "options[]",
                'value' => $option,
                'attr' => 'placeholder="Beschriftung"',
                'small' => '<a class="remove-option">Option löschen</a>'
            ];
        }
        $subsettings[] = [
            'type' => "button",
            'title' => "Option hinzufügen",
            'class' => "add-option"
        ];
        $settings = [
            'id' => $this->id,
            'index' => $this->index,
            'type' => "Auswahlbox",
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
        $o->type = 'select';

        $j = new stdClass();
        $j->label = $this->label;
        $j->options = $this->options;
        $o->data = json_encode($j);

        return $o;
    }
}
