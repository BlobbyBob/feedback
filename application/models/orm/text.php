<?php

namespace Models;

use function is_string;
use function max;
use function min;

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
     * Get the html of the settings of this form element
     * todo: This should be moved to views
     * @return string
     */
    public function get_settings()
    {
        $html = <<<HTML
            <input type="hidden" name="id" value="{$this->id}">
            <input type="hidden" name="index" value="{$this->index}">
            <div class="element-type"><strong>Typ:</strong> Textfeld</div> 
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
                <div class="element-setting">
                    <div class="element-setting-key">Maximale Länge: </div>
                    <div class="element-setting-value"><input class="form-control" type="number" name="maxlength" value="{$this->maxlength}"></div>
                </div>
            </div>
HTML;
        return $html;
    }
}
