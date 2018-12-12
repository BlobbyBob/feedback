<?php

namespace Models;

use function is_string;
use function max;
use function min;
use stdClass;

/**
 * Class Text
 * Represents an <input type="text"> element
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Text extends Formelement
{

    const MAXLENGTH = 512;

    /**
     * @var string $label The label of this input
     */
    public $label = '';

    /**
     * @var string $placeholder The placeholder of this input
     */
    public $placeholder = '';

    /**
     * @var int $maxlength The max input length of this input, maximum is constant MAXLENGTH, minimum is 1
     */
    public $maxlength = self::MAXLENGTH;

    /**
     * Text constructor.
     * @param object $data The data for initialization
     */
    public function __construct($data)
    {

        if (isset($data->label) && is_string($data->label)) {
            $this->label = $data->label;
        }

        if (isset($data->placeholder) && is_string($data->placeholder)) {
            $this->placeholder = $data->placeholder;
        }

        if (isset($data->maxlength) && is_int($data->maxlength)) {
            $this->maxlength = min(self::MAXLENGTH, max(1, $data->maxlength));
        }

    }

    /**
     * Get the HTML representation of this element. Needs the matching CSS
     * @return string The HTML for this element
     */
    public function get_html()
    {
        $html = "<label for='field-{$this->id}'>{$this->label}</label>
                 <input id='field-{$this->id}' type='text' class='form-control' name='field-{$this->id}' placeholder='{$this->placeholder}' maxlength='{$this->maxlength}'>";
        return $html;
    }

    /**
     * This is a text element
     * @return bool true
     */
    public function is_text()
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
            'type' => "Textfeld",
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
                ],
                [
                    'key' => "Maximale Länge",
                    'type' => "number",
                    'name' => "maxlength",
                    'value' => $this->maxlength
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

        $j = new stdClass();
        $j->label = $this->label;
        $j->placeholder = $this->placeholder;
        $j->maxlength = $this->maxlength;
        $o->data = json_encode($j);

        return $o;
    }
}
