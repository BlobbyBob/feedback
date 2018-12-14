<?php

namespace Models;

use function strtolower;

/**
 * Class Formelement
 *
 * @package Models
 */
abstract class Formelement
{

    /**
     * @var int $id The numeric ID for this element
     */
    public $id;

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
     * todo: This should be moved to views
     * @return string
     */
    abstract public function get_html();

    /**
     * Get the settings of this form element
     * Should be parsed by a view
     *
     * @return array
     */
    abstract public function get_settings();

    /**
     * True if this form element is a text element, false otherwise
     * @return bool
     */
    public function is_text()
    {
        return false;
    }

    /**
     * True if this form element is a textarea element, false otherwise
     * @return bool
     */
    public function is_textarea()
    {
        return false;
    }

    /**
     * True if this form element is a select element, false otherwise
     * @return bool
     */
    public function is_select()
    {
        return false;
    }

    /**
     * True if this form element is a checkbox element, false otherwise
     * @return bool
     */
    public function is_checkbox()
    {
        return false;
    }

    /**
     * True if this form element is a radio element, false otherwise
     * @return bool
     */
    public function is_radio()
    {
        return false;
    }

    /**
     * True if this form element is a numeric element, false otherwise
     * @return bool
     */
    public function is_numeric()
    {
        return false;
    }

    /**
     * True if this form element is a rating, false otherwise
     * @return bool
     */
    public function is_rating()
    {
        return false;
    }

    /**
     * Create a form element, doesn't set the page property
     * @param object $object Data of the form element
     * @return Formelement The instantiated subclass
     */
    public static function create($object)
    {
        $class = self::getFormelementClassName($object->type);
        /** @var Formelement $formelement */
        $formelement = new $class(json_decode($object->data));
        $formelement->id = $object->id;
        $formelement->index = $object->index;
        return $formelement;
    }

    /**
     * Return the data of this formelement as object similar to the object by Formelement::create
     *
     * @return object
     */
    abstract public function export();

    /**
     * Remove page breaks and generate a new array with page numbers set
     * @param Formelement[] $formelements The form elements to set the page number on
     * @return Formelement[] An updated array
     */
    public static function set_pages($formelements)
    {
        $new = [];
        $page = 1;
        foreach ($formelements as $element) {
            if ($element instanceof Pagebreak)
                $page++;
            else {
                $element->page = $page;
                $new[] = $element;
            }
        }
        return $new;
    }

    /**
     * Get the class name of a form element by its type
     *
     * @param string $type Type of Formelement
     * @return string|null Return the class name or null in case of a wrong type
     */
    public static function getFormelementClassName($type) {
        switch (strtolower($type)) {
            case 'check':
            case 'checkbox':
                $class = '\Models\Checkbox';
                break;
            case 'num':
            case 'numeric':
                $class = '\Models\Numeric';
                break;
            case 'page':
            case 'pagebreak':
                $class = '\Models\Pagebreak';
                break;
            case 'radio':
            case 'radiobutton':
                $class = '\Models\Radio';
                break;
            case 'rating':
            case 'starrating':
                $class = '\Models\Rating';
                break;
            case 'select':
                $class = '\Models\Select';
                break;
            case 'text':
                $class = '\Models\Text';
                break;
            case 'textarea':
                $class = '\Models\Textarea';
                break;
            default:
                return null;
                break;
        }
        return $class;
    }

}
