<?php

namespace Models;

/**
 * Class Textarea
 * Represents a <textarea> element
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Textarea extends Formelement
{
    /**
     * @var string $label The label for this element
     */
    public $label = '';

    /**
     * @var string $placeholder The placeholder for this element
     */
    public $placeholder = '';

    /**
     * Textarea constructor.
     * @param object $data The data for initializiation
     */
    public function __construct($data)
    {

        if (isset($data->label) && is_string($data->label)) {
            $this->label = $data->label;
        }

        if (isset($data->placeholder) && is_string($data->placeholder)) {
            $this->placeholder = $data->placeholder;
        }

    }

    /**
     * This is a textarea
     * @return bool true
     */
    public function is_textarea()
    {
        return true;
    }


    /**
     * Get the HTML representation of this element. Needs the matching CSS
     * @return string The HTML for this element
     */
    public function get_html()
    {
        $html = "<label for='field-{$this->id}'>{$this->label}</label>
                 <textarea id='field-{$this->id}' class='form-control' name='field-{$this->id}' placeholder='{$this->placeholder}'></textarea>";
        return $html;
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
            <div class="element-type"><strong>Typ:</strong> Großes Textfeld</div> 
            <div class="element-settings">
                <div class="element-settings-title">Einstellungen:</div>
                <div class="element-setting">
                    <div class="element-setting-key">Beschriftung: </div>
                    <div class="element-setting-value"><input class="form-control" type="text" name="label" value="{$this->label}"></div>
                </div>
                <div class="element-setting">
                    <div class="element-setting-key">Platzhalter: </div>
                    <div class="element-setting-value"><input class="form-control" type="text" name="placeholder" value="{$this->placeholder}"></div>
                </div>
            </div>
HTML;
        return $html;
    }
}
