<?php

namespace Models;

abstract class Formelement
{

    /**
     * @var int $id The numeric ID for this element
     */
    public $id;

    /**
     * @var string $name The label for this element
     */
    public $name;

    /**
     * @var int $page The number on which page this element gets shown
     */
    public $page;

    /**
     * @var int $index The index of the custom order
     */
    public $index;

    /**
     * Get the html of this form element
     * @return string
     */
    abstract public function get_html();

    /**
     * True if this form element is a text element, false otherwise
     * @return bool
     */
    public function is_text() {
        return $this instanceof Text;
    }

    /**
     * True if this form element is a textarea element, false otherwise
     * @return bool
     */
    public function is_textarea() {
        return $this instanceof Textarea;
    }

    /**
     * True if this form element is a select element, false otherwise
     * @return bool
     */
    public function is_select() {
        return $this instanceof Select;
    }

    /**
     * True if this form element is a checkbox element, false otherwise
     * @return bool
     */
    public function is_checkbox() {
        return $this instanceof Checkbox;
    }

    /**
     * True if this form element is a radio element, false otherwise
     * @return bool
     */
    public function is_radio() {
        return $this instanceof Radio;
    }

    /**
     * True if this form element is a numeric element, false otherwise
     * @return bool
     */
    public function is_numeric() {
        return $this instanceof Numeric;
    }

    /**
     * @param array $data Data of the form element
     * @return Formelement The instantiated subclass
     */
    public static function create($data)
    {
        // TODO implement create($data)
        return null;
    }

}
