<?php

namespace Models;

/**
 * Class Numeric
 * Represents an <input type="number">
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Numeric extends Formelement
{

    /**
     * @var string $label The label for the checkbox
     */
    public $label = '';

    /**
     * Numeric constructor.
     * @param object $data
     */
    public function __construct($data)
    {
        if (isset($data->label) && is_string($data->label))
            $this->label = $data->label;
    }

    public function get_html()
    {
        // TODO: Implement get_html() method.
    }

    /**
     * Returns true, since this is a numeric input
     * @return bool
     */
    public function is_numeric()
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
        $html = <<<HTML
            <input type="hidden" name="id" value="{$this->id}">
            <input type="hidden" name="index" value="{$this->index}">
            <div class="element-type"><strong>Typ:</strong> Nummer</div> 
            <div class="element-settings">
                <div class="element-settings-title">Einstellungen:</div>
                <div class="element-setting">
                    <div class="element-setting-key">Beschriftung: </div>
                    <div class="element-setting-value"><input class="form-control" type="text" name="label" value="{$this->label}"></div>
                </div>
            </div>
HTML;
        return $html;
    }
}
