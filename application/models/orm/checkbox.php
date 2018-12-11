<?php

namespace Models;

use function in_array;
use function is_string;

/**
 * Class Checkbox
 * Represents an <input type="checkbox">
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Checkbox extends Formelement
{

    const BEFORE = 0;
    const AFTER = 1;

    /**
     * @var string $label The label for the checkbox
     */
    public $label = '';

    /**
     * @var int $label_position Either Checkbox::BEFORE or Checkbox::AFTER
     */
    public $label_position = self::BEFORE;

    /**
     * Checkbox constructor.
     * @param object $data The data for initializing
     */
    public function __construct($data)
    {

        if (isset($data->label) && is_string($data->label))
            $this->label = $data->label;

        if (isset($data->label_position) && in_array($data->label_position, [self::BEFORE, self::AFTER])) {
            $this->label_position = $data->label_position;
        }

    }

    public function get_html()
    {
        // TODO: Implement get_html() method.
    }
    
    /**
     * Returns true, since this element is a checkbox
     * @return bool
     */
    public function is_checkbox()
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
        $html = '
            <input type="hidden" name="id" value="'.$this->id.'">
            <input type="hidden" name="index" value="'.$this->index.'">
            <div class="element-type"><strong>Typ:</strong> Checkbox</div> 
            <div class="element-settings">
                <div class="element-settings-title">Einstellungen:</div>
                <div class="element-setting">
                    <div class="element-setting-key">Beschriftung: </div>
                    <div class="element-setting-value"><input class="form-control" type="text" name="label" value="'.$this->label.'"></div>
                </div>
                <div class="element-setting">
                    <div class="element-setting-key">Beschriftungsposition: </div>
                    <div class="element-setting-value"><select name="label_position">
                        <option value="'.self::BEFORE.'" '.($this->label_position==self::BEFORE)?'selected':''.'>Links</option>
                        <option value="'.self::AFTER.'" '.($this->label_position==self::AFTER)?'selected':''.'>Rechts</option>                    
                    </select></div>
                </div>
            </div>';
        return $html;
    }
}
