<?php

namespace Models;

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
     * Get the html of the settings of this form element
     * todo: This should be moved to views
     * @return string
     */
    public function get_settings()
    {
        $optionsettings = '';
        foreach ($this->options as $option) {
            $optionsettings .= '<div class="element-setting">
                    <div class="element-setting-key">Option: </div>
                    <div class="element-setting-value"><input class="form-control" type="text" name="options[]" value="'.$option.'" placeholder="Beschriftung"></div>
                    <a class="remove-option"><small class="form-text">Option löschen</small></a>
                </div>';
        }
        $html = <<<HTML
            <input type="hidden" name="id" value="{$this->id}">
            <input type="hidden" name="index" value="{$this->index}">
            <div class="element-type"><strong>Typ:</strong> Auswahlbox</div> 
            <div class="element-settings">
                <div class="element-settings-title">Einstellungen:</div>
                <div class="element-setting">
                    <div class="element-setting-key">Beschriftung: </div>
                    <div class="element-setting-value"><input class="form-control" type="text" name="label" value="{$this->label}"></div>
                </div>
                $optionsettings
                <div class="element-setting">
                    <div class="element-setting-value"><button type="button" class="btn btn-info add-option">Option hinzufügen</button></div>
                </div>
            </div>
HTML;
        return $html;
    }
}
