<?php

namespace Models;

use function is_array;
use function is_object;
use function is_string;

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
     * Get the html of the settings of this form element
     * todo: This should be moved to views
     * @return string
     */
    public function get_settings()
    {
        $labelsettings = '';
        foreach ($this->labels as $label) {
            $labelsettings .= '<div class="element-setting">
                    <div class="element-setting-key">Radio Button: </div>
                    <div class="element-setting-value"><input class="form-control" type="text" name="labels[]" value="'.$label.'" placeholder="Beschriftung"></div>
                    <a class="remove-radio"><small class="form-text">Radio Button löschen</small></a>
                </div>';
        }
        $html = <<<HTML
            <input type="hidden" name="id" value="{$this->id}">
            <input type="hidden" name="index" value="{$this->index}">
            <div class="element-type"><strong>Typ:</strong> Radio Buttons</div> 
            <div class="element-settings">
                <div class="element-settings-title">Einstellungen:</div>
                <div class="element-setting">
                    <div class="element-setting-key">Beschriftung: </div>
                    <div class="element-setting-value"><input class="form-control" type="text" name="main_label" value="{$this->main_label}"></div>
                </div>
                $labelsettings
                <div class="element-setting">
                    <div class="element-setting-value"><button type="button" class="btn btn-info add-radio">Radio Button hinzufügen</button></div>
                </div>
            </div>
HTML;
        return $html;
    }
}
