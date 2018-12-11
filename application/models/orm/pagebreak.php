<?php

namespace Models;

/**
 * Class Pagebreak
 * Represents a new div / page
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 * @see Formelement
 */
class Pagebreak extends Formelement
{

    /**
     * Pagebreak constructor.
     * @param object $data The data object is not used in this Formelement
     */
    public function __construct($data)
    {
    }

    /**
     * Get the html of this form element
     * @return string
     */
    public function get_html()
    {
        return '';
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
            <div class="element-type"><strong>Typ:</strong> Seitenumbruch</div> 
            <div class="element-settings">
                <div class="element-settings-title">Einstellungen:</div>
            </div>
HTML;
        return $html;
    }
}